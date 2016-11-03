<?php

namespace FL\PlivoBundle\Event;

use Plivo\Model\SmsOutgoingInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class OutgoingSmsDeliveredEvent.
 */
class OutgoingSmsDeliveredEvent extends Event
{
    const EVENT_NAME = 'fl_plivo.outgoing_sms.delivered';

    /**
     * @var SmsOutgoingInterface
     */
    protected $sms;

    /**
     * OutgoingSmsDeliveredEvent constructor.
     *
     * @param SmsOutgoingInterface $sms
     */
    public function __construct(SmsOutgoingInterface $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Get delivered SMS through the event.
     *
     * @return SmsOutgoingInterface
     */
    public function getSms() : SmsOutgoingInterface
    {
        return $this->sms;
    }
}
