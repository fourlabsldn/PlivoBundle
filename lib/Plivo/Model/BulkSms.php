<?php

namespace Plivo\Model;

abstract class BulkSms implements BulkSmsInterface
{
    /**
     * Number these messages will be sent from.
     * @var string
     */
    protected $from;

    /**
     * Numbers these messages will be sent to.
     * @var string[]
     */
    protected $to = [];

    /**
     * Content of the message to send.
     * @var string
     */
    protected $text;

    /**
     * MessageUUIDs of each message that has been sent.
     * Their order will match the order of the phones in the $to field.
     * @var string[]
     */
    protected $uuids = [];

    /**
     * @param string|null $from
     * @return BulkSmsInterface
     */
    public function setFrom(string $from = null): BulkSmsInterface
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param array|null $to
     * @return BulkSmsInterface
     */
    public function setTo(array $to = null): BulkSmsInterface
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string|null $text
     * @return BulkSmsInterface
     */
    public function setText(string $text = null): BulkSmsInterface
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param array|null $uuids
     * @return BulkSmsInterface
     */
    public function setUuids(array $uuids = null): BulkSmsInterface
    {
        $this->uuids = $uuids;

        return $this;
    }

    /**
     * @return array
     */
    public function getUuids()
    {
        return $this->uuids;
    }
}
