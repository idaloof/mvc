<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectResetDatabaseController extends AbstractController
{
    #[Route("/proj/reset-database", name: 'proj_reset_database')]
    public function jsonDeckShuffle(
        EntityManagerInterface $entityManager,
        SessionInterface $session
    ): Response {

        // Reset the database and import data from the CSV file

        $session->invalidate();

        // Delete contents of the 'messages' table
        $connection = $entityManager->getConnection();
        // $platform = $connection->getDatabasePlatform();
        $connection->executeStatement('DELETE FROM messages');

        // Run the command to reset the database
        exec('php bin/console doctrine:schema:drop --force');
        exec('php bin/console doctrine:schema:update --force');

        // Import data from the CSV file
        exec('php bin/console csv:import');

        // Redirect back to the page where the reset button is
        return $this->redirectToRoute('proj');
    }
}
