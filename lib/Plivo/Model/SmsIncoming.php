<?php

namespace Plivo\Model;

/**
 * Model SmsIncoming.
 */
class SmsIncoming extends Sms implements SmsIncomingInterface
{
    public function append(SmsInterface $sms): SmsInterface
    {
        $this->setText(
            $this->getText().$sms->getText()
        );

        return $this;
    }
}
