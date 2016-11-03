<?php

namespace Plivo\Model;

/**
 * Interface SmsOutgoingInterface
 * @package Plivo\Model
 */
interface SmsOutgoingInterface extends SmsInterface
{
    /**
     * SmsOutgoing will have this status flow:
     * Pending -> Queued -> Delivered
     */
    const STATUS_PENDING = 'pending';
    const STATUS_QUEUED = 'queued';
    const STATUS_DELIVERED = 'delivered';

    /**
     * Get the message status
     * @return mixed
     */
    public function getStatus();

    /**
     * Set status as 'queued'
     * @return SmsOutgoingInterface
     */
    public function setQueued(): SmsOutgoingInterface;

    /**
     * Set status as 'delivered'
     * @return SmsOutgoingInterface
     */
    public function setDelivered(): SmsOutgoingInterface;
}
