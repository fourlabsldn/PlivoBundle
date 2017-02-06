<?php

namespace Plivo\Model;

/**
 * Model SmsOutgoing.
 */
class SmsOutgoing extends Sms implements SmsOutgoingInterface
{
    /**
     * SmsOutgoing status
     * Possible values: pending|queued|delivered.
     *
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
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(string $status): SmsOutgoingInterface
    {
        if (!in_array($status, SmsOutgoingInterface::ALL_STATUSES)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid status', $status));
        }
        $this->status = SmsOutgoingInterface::STATUS_UNKNOWN;

        return $this;
    }
}
