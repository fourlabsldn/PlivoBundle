<?php

namespace FL\PlivoBundle\Event;

use Plivo\Model\SmsInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class OutgoingSmsSentEvent
 * @package Plivo\Event
 */
class OutgoingSmsSentEvent extends Event
{
    const EVENT_NAME = 'fl_plivo.outgoing_sms.sent';

    /**
     * @var SmsInterface
     */
    protected $sms;

    /**
     * OutgoingSmsSentEvent constructor.
     * @param SmsInterface $sms
     */
    public function __construct(SmsInterface $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Get SMS sent through the event.
     * @return SmsInterface
     */
    public function getSms()
    {
        return $this->sms;
    }
}
