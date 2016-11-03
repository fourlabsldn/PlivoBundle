<?php

namespace Plivo\Model;

/**
 * Interface SmsInterface.
 */
interface SmsInterface
{
    /**
     * Set the text for the SMS.
     *
     * @param string $text
     *
     * @return SmsInterface
     */
    public function setText(string $text): SmsInterface;

    /**
     * Get the text in the SMS.
     *
     * @return string
     */
    public function getText();

    /**
     * Sets phone number the SMS is sent from.
     *
     * @param string $from
     *
     * @return SmsInterface
     */
    public function setFrom(string $from): SmsInterface;

    /**
     * Gets phone number the SMS is sent from.
     *
     * @return string|null
     */
    public function getFrom();

    /**
     * Set destination phone number for the SMS.
     *
     * @param string $to
     *
     * @return SmsInterface
     */
    public function setTo(string $to): SmsInterface;

    /**
     * Get destination phone number for the SMS.
     *
     * @return string
     */
    public function getTo();

    /**
     * Set the message ID, references Plivo MessageUUID.
     *
     * @param string|null $uuid
     *
     * @return SmsInterface
     */
    public function setUuid(string $uuid = null): SmsInterface;

    /**
     * Get the message ID, references Plivo MessageUUID.
     *
     * @return mixed
     */
    public function getUuid();
}
