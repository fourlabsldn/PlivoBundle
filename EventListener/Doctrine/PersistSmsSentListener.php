<?php

namespace FL\PlivoBundle\EventListener\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use FL\PlivoBundle\Event\OutgoingSmsSentEvent;

class PersistSmsSentListener
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param OutgoingSmsSentEvent $event
     */
    public function onMessageSent(OutgoingSmsSentEvent $event)
    {
        $this->manager->persist($event->getSms());
        $this->manager->flush();
    }
}
