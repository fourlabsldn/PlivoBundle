<?php

namespace FL\PlivoBundle\EventListener\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use FL\PlivoBundle\Event\OutgoingSmsDeliveredEvent;
use Plivo\Model\SmsOutgoingInterface;

class PersistSmsDeliveredListener
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var EntityRepository
     */
    private $smsOutgoingRepository;

    /**
     * @param EntityManagerInterface $manager
     * @param string                 $smsOutgoingClass
     */
    public function __construct(
        EntityManagerInterface $manager,
        string $smsOutgoingClass
    ) {
        $this->manager = $manager;
        $this->smsOutgoingRepository = $manager->getRepository($smsOutgoingClass);
    }

    /**
     * @param OutgoingSmsDeliveredEvent $event
     */
    public function onMessageDelivered(OutgoingSmsDeliveredEvent $event)
    {
        if (!$message = $this->smsOutgoingRepository->findOneByUuid($event->getSms()->getUuid())) {
            throw new \RuntimeException(
                'SmsOutgoing with this MessageUUID not found.'
            );
        }
        /* @var SmsOutgoingInterface $message */
        $message->setStatus($event->getSms()->getStatus());
        $this->manager->flush();
    }
}
