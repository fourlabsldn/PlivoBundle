<?php

namespace Plivo;

use Plivo\Client\RestClientInterface;
use Plivo\DataTransformer\BulkSmsTransformer;
use Plivo\DataTransformer\SmsTransformer;
use Plivo\Model\BulkSmsInterface;
use Plivo\Model\SmsOutgoingInterface;

/**
 * Class Plivo
 * @package Plivo
 */
class Plivo
{
    /**
     * @var RestClientInterface
     */
    private $client;

    /**
     * Plivo constructor.
     * @param RestClientInterface $client
     */
    public function __construct(RestClientInterface $client) {
        $this->client = $client;
    }

    /**
     * Send a single SMS through the client.
     * @param SmsOutgoingInterface $sms
     * @param string $deliveryReportUrl
     */
    public function sendSms(SmsOutgoingInterface $sms, string $deliveryReportUrl)
    {
        $transformer = new SmsTransformer();
        $message = $transformer->transform($sms);
        $message['url'] = $deliveryReportUrl;

        $uuids = $this->client->postMessage($message);

        $sms->setUuid($uuids[0]);
        $sms->setQueued();
    }

    /**
     * Send several SMS messages through the client in a single call.
     * @param BulkSmsInterface $bulkSms
     * @param string $deliveryReportUrl
     */
    public function sendBulkSms(BulkSmsInterface $bulkSms, string $deliveryReportUrl)
    {
        $transformer = new BulkSmsTransformer();
        $message = $transformer->transform($bulkSms);
        $message['url'] = $deliveryReportUrl;

        $uuids = $this->client->postMessage($message);

        $bulkSms->setUuids($uuids);
    }
}
