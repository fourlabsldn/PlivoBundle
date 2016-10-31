<?php

namespace Plivo\Model;

interface BulkSmsInterface
{
    /**
     * Set phone number from which these messages will be sent.
     * @param string $from
     * @return BulkSmsInterface
     */
    public function setFrom(string $from): BulkSmsInterface;

    /**
     * Get phone number from which these messages will be sent.
     * @return string
     */
    public function getFrom();

    /**
     * Set phone numbers these messages will be sent to.
     * @param array $to
     * @return BulkSmsInterface
     */
    public function setTo(array $to): BulkSmsInterface;

    /**
     * Get phone numbers these messages will be sent to.
     * @return string
     */
    public function getTo();

    /**
     * Set content of the message.
     * @param string $text
     * @return BulkSmsInterface
     */
    public function setText(string $text): BulkSmsInterface;

    /**
     * Get content of the message.
     * @return string
     */
    public function getText();

    /**
     * Get MessageUUIDs for each message sent.
     * This identifier comes from Plivo.
     * @return BulkSmsInterface
     */
    public function setUuids(array $uuids): BulkSmsInterface;

    /**
     * Set MessageUUIDs for each message sent.
     * @return mixed
     */
    public function getUuids();
}
