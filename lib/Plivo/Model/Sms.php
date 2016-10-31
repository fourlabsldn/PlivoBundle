<?php

namespace Plivo\Model;

/**
 * Model Sms
 * @package Plivo\Model
 */
abstract class Sms implements SmsInterface
{
    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $text;

    /**
     * MessageUUID, unique message identifier obtained from Plivo.
     * @var string
     */
    protected $uuid;

    /**
     * {@inheritdoc}
     */
    public function setFrom(string $from = null): SmsInterface
    {
        $this->from = $from;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * {@inheritdoc}
     */
    public function setTo(string $to = null): SmsInterface
    {
        $this->to = $to;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * {@inheritdoc}
     */
    public function setText(string $text = null): SmsInterface
    {
        $this->text = $text;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * {@inheritdoc}
     */
    public function setUuid(string $uuid = null): SmsInterface
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
