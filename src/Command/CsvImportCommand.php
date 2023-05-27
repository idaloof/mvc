<?php

/**
 * This class provides configures a command for importing a csv
 * and a method for executing the command.
 */

namespace App\Command;

use App\Entity\PreFlopRankings;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CsvImportCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('Reads CSV file')
            ->setHelp('This command allows you to read and store its data in the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inOut = new SymfonyStyle($input, $output);
        $inOut->title('Attempting to import the data...');

        try {
            $reader = Reader::createFromPath('%kernel.root_dir%/../src/Data/preflop.csv');

            $results = $reader->getRecords();
            $inOut->progressStart(iterator_count($results));

            foreach ($results as $row) {
                $cardCombo = (new PreFlopRankings())
                    ->setCards($row[1])
                    ->setType($row[2])
                    ->setRank($row[0]);

                $this->entityManager->persist($cardCombo);

                $inOut->progressAdvance();
            }

            $this->entityManager->flush();
            $inOut->progressFinish();
            $inOut->success('Everything is ok!');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->entityManager->getConnection()->executeQuery('DELETE FROM pre_flop_rankings');
            $errorMessage = $e->getMessage();
            $inOut->error('An error occurred during the import. The entity table has been reset.');
            $inOut->error($errorMessage);
            return Command::FAILURE;
        }
    }
}
