<?php

namespace Plivo\Model;

/**
 * Interface SmsOutgoingInterface.
 */
interface SmsOutgoingInterface extends SmsInterface
{
    /**
     * Ideally, SmsOutgoing will have this status flow:
     * Pending -> Queued -> Delivered.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_QUEUED = 'queued';
    const STATUS_SENT = 'sent';
    const STATUS_FAILED = 'failed';
    const STATUS_UNDELIVERED = 'undelivered';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_REJECTED = 'rejected';
    const STATUS_UNKNOWN = 'unknown';

    const ALL_STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_QUEUED,
        self::STATUS_SENT,
        self::STATUS_FAILED,
        self::STATUS_UNDELIVERED,
        self::STATUS_DELIVERED,
        self::STATUS_REJECTED,
        self::STATUS_UNKNOWN,
    ];

    /**
     * Get the message status.
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * Set the message status.
     *
     * @param string $status
     *
     * @return SmsOutgoingInterface
     */
    public function setStatus(string $status): SmsOutgoingInterface;
}
