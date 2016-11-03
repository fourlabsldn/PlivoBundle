<?php

namespace Plivo\Model;

/**
 * Model SmsOutgoing
 * @package Plivo\Model
 */
class SmsOutgoing extends Sms implements SmsOutgoingInterface
{
    /**
     * SmsOutgoing status
     * Possible values: pending|queued|delivered
     * @var string
     */
    protected $status;

    /**
     * Default status for SmsOutgoing is 'sent'
     * SmsOutgoing constructor.
     */
    public function __construct()
    {
        $this->status = self::STATUS_PENDING;
    }

    /**
     * Set SmsOutgoing status as 'queued'
     * @return SmsOutgoingInterface
     */
    public function setQueued(): SmsOutgoingInterface
    {
        $this->status = self::STATUS_QUEUED;

        return $this;
    }

    /**
     * Set SmsOutgoing status as 'delivered'
     * @return SmsOutgoingInterface
     */
    public function setDelivered(): SmsOutgoingInterface
    {
        $this->status = self::STATUS_DELIVERED;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }
}
