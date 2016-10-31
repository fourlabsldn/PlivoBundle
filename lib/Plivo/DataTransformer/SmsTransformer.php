<?php

namespace Plivo\DataTransformer;

use Plivo\Model\SmsIncoming;
use Plivo\Model\SmsInterface;

/**
 * Class SmsTransformer
 * @package Plivo\DataTransformer
 */
class SmsTransformer
{
    /**
     * Transform main SMS attributes into an array: from, to, text
     * @param SmsInterface $sms
     * @return array
     */
    public function transform(SmsInterface $sms): array
    {
        return [
            'src' => $sms->getFrom(),
            'dst' => $sms->getTo(),
            'text' => $sms->getText()
        ];
    }

    /**
     * Transform an array into an SMS using its main attributes: from, to, text
     * @param array $message
     * @return SmsInterface
     */
    public function reverseTransform(array $message): SmsInterface
    {
        $sms = new SmsIncoming();
        $sms->setFrom($message['src']);
        $sms->setTo($message['dst']);
        $sms->setText($message['text']);

        return $sms;
    }
}
