<?php

namespace FL\PlivoBundle\Event;

use Plivo\Model\SmsInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class IncomingSmsReceivedEvent.
 */
class IncomingSmsReceivedEvent extends Event
{
    const EVENT_NAME = 'fl_plivo.incoming_sms.received';

    /**
     * @var SmsInterface
     */
    protected $sms;

    /**
     * IncomingSmsReceivedEvent constructor.
     *
     * @param SmsInterface $sms
     */
    public function __construct(SmsInterface $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Get the SMS sent through the event.
     *
     * @return SmsInterface
     */
    public function getSms()
    {
        return $this->sms;
    }
}
