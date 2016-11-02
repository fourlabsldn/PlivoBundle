<?php

namespace FL\PlivoBundle\EventListener\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use FL\PlivoBundle\Event\IncomingSmsReceivedEvent;

class PersistSmsReceivedListener
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }

    /**
     * @param IncomingSmsReceivedEvent $event
     */
    public function onMessageReceived(IncomingSmsReceivedEvent $event)
    {
        $this->manager->persist($event->getSms());
        $this->manager->flush();
    }
}