<?php

namespace Plivo\DataTransformer;

use Plivo\Model\BulkSmsInterface;
use Plivo\Model\BulkSmsOutgoing;

class BulkSmsTransformer
{
    public function transform(BulkSmsInterface $bulkSms): array
    {
        return [
            'src' => $bulkSms->getFrom(),
            'dst' => implode('<', $bulkSms->getTo()),
            'text' => $bulkSms->getText(),
        ];
    }

    public function reverseTransform(array $message): BulkSmsInterface
    {
        $bulkSms = new BulkSmsOutgoing();
        $bulkSms->setFrom($message['src']);
        $bulkSms->setTo(explode('<', $message['dst']));
        $bulkSms->setText($message['text']);

        return $bulkSms;
    }
}
