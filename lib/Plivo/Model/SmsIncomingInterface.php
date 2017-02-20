<?php

namespace Plivo\Model;

interface SmsIncomingInterface
{
    /**
     * Appends the text of given $sms to this sms's text. Used to join long messages received
     * in multiple requests.
     *
     * @return SmsInterface
     */
    public function append(SmsInterface $sms): SmsInterface;
}
