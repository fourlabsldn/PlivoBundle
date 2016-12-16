<?php

namespace Plivo;

use FL\PlivoBundle\Event\OutgoingSmsSentEvent;
use Plivo\Client\RestClientInterface;
use Plivo\DataTransformer\BulkSmsTransformer;
use Plivo\DataTransformer\SmsTransformer;
use Plivo\Model\BulkSmsInterface;
use Plivo\Model\SmsOutgoingInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class Plivo.
 */
class Plivo
{
    /**
     * @var RestClientInterface
     */
    private $client;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var string
     */
    private $smsClass;

    /**
     * @var bool
     */
    private $developmentMode;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Plivo constructor.
     *
     * @param RestClientInterface      $client
     * @param EventDispatcherInterface $dispatcher
     * @param string                   $smsClass
     * @param bool                     $developmentMode
     * @param RouterInterface          $router
     */
    public function __construct(
        RestClientInterface $client,
        EventDispatcherInterface $dispatcher,
        string $smsClass,
        bool $developmentMode,
        RouterInterface $router
    ) {
        $this->client = $client;
        $this->dispatcher = $dispatcher;
        $this->smsClass = $smsClass;
        $this->developmentMode = $developmentMode;
        $this->router = $router;
    }

    /**
     * Send a single SMS through the client.
     *
     * @param SmsOutgoingInterface $sms
     */
    public function sendSms(SmsOutgoingInterface $sms)
    {
        $transformer = new SmsTransformer();
        $message = $transformer->transform($sms);
        $message['url'] = $this->getDeliveryReportUrl();

        $sms->setUuid(uniqid());
        $sms->setDelivered();
        if (!$this->developmentMode) {
            $uuids = $this->client->postMessage($message);
            $sms->setUuid($uuids[0]);
            $sms->setQueued();
        }

        $this->dispatcher->dispatch(OutgoingSmsSentEvent::EVENT_NAME, new OutgoingSmsSentEvent($sms));
    }

    /**
     * Send several SMS messages through the client in a single call.
     *
     * @param BulkSmsInterface $bulkSms
     */
    public function sendBulkSms(BulkSmsInterface $bulkSms)
    {
        $transformer = new BulkSmsTransformer();
        $message = $transformer->transform($bulkSms);
        $message['url'] = $this->getDeliveryReportUrl();

        $uuids = $this->client->postMessage($message);
        $bulkSms->setUuids($uuids);

        $to = $bulkSms->getTo();

        for ($i = 0, $count = count($to); $i < $count; ++$i) {
            $sms = new $this->smsClass();
            /* @var SmsOutgoingInterface $sms */
            $sms->setDelivered()
                ->setUuid(uniqid())
                ->setTo($to[$i])
                ->setFrom($bulkSms->getFrom())
                ->setText($bulkSms->getText())
            ;

            if (!$this->developmentMode) {
                $sms->setQueued()->setUuid($uuids[$i]);
            }

            $this->dispatcher->dispatch(OutgoingSmsSentEvent::EVENT_NAME, new OutgoingSmsSentEvent($sms));
        }
    }

    /**
     * Return the absolute URL for Plivo to send the message delivery report.
     *
     * @return string
     */
    private function getDeliveryReportUrl(): string
    {
        return $this->router->generate('fl_plivo.message_delivery_report', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
