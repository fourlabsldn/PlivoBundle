<?php

namespace FL\PlivoBundle\EventListener\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use FL\PlivoBundle\Event\IncomingSmsReceivedEvent;
use Plivo\Model\SmsInterface;

class PersistSmsReceivedListener
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
     * @param IncomingSmsReceivedEvent $event
     */
    public function onMessageReceived(IncomingSmsReceivedEvent $event)
    {
        $newSms = $event->getSms();
        $repository = $this->manager->getRepository(get_class($newSms));

        // Long messages have the same parent uuid
        /** @var SmsInterface $existingSms */
        if (($existingSms = $repository->findOneByUuid($newSms->getUuid()))) {
            $existingSms->append($newSms);
            $this->manager->persist($existingSms);
        } else {
            $this->manager->persist($newSms);
        }

        $this->manager->flush();
    }
}
