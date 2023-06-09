<?php

namespace App\Texas;

use App\Entity\Messages;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Message trait
 * Responsible for adding messages to the Messages entity.
 */

trait MessageTrait
{
    /**
     * Creates and inserts message into Messages entity
     *
     * @param string $messenger
     * @param string $aMessage
     * @param ManagerRegistry $doctrine
     *
     * @return bool
     */
    public function addMessage(
        string $messenger,
        string $aMessage,
        ManagerRegistry $doctrine
    ): bool {
        $entityManager = $doctrine->getManager();

        $message = new Messages();

        date_default_timezone_set('Europe/Stockholm');

        $currentTime = date('H:i:s');

        $message->setCreated(strval($currentTime));
        $message->setMessenger($messenger);
        $message->setMessage($aMessage);

        $entityManager->persist($message);
        $entityManager->flush();

        return true;
    }
}
