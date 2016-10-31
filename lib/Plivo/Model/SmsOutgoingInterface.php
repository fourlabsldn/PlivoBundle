<?php

namespace Plivo\Model;

/**
 * Interface SmsOutgoingInterface
 * @package Plivo\Model
 */
interface SmsOutgoingInterface extends SmsInterface
{
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
