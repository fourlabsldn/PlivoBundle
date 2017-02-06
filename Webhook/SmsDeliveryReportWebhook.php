<?php

namespace FL\PlivoBundle\Webhook;

use FL\PlivoBundle\Event\OutgoingSmsDeliveredEvent;
use Plivo\Model\SmsOutgoingInterface;
use Plivo\Webhook\WebhookInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SmsDeliveryReportWebhook.
 */
class SmsDeliveryReportWebhook implements WebhookInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var string
     */
    private $smsClass;

    /**
     * SmsDeliveryReportWebhook constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     * @param string                   $smsClass
     */
    public function __construct(EventDispatcherInterface $dispatcher, string $smsClass)
    {
        $this->dispatcher = $dispatcher;
        $this->smsClass = $smsClass;
    }

    /**
     * Convert a request into an SmsOutgoing object.
     *
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        $sms = new $this->smsClass();
        /* @var SmsOutgoingInterface $sms */
        $sms
            ->setStatus($request->request->get('Status'))
            ->setFrom($request->request->get('From'))
            ->setTo($request->request->get('To'))
            ->setUuid($request->request->get('MessageUUID'))
        ;

        $event = new OutgoingSmsDeliveredEvent($sms);
        $this->dispatcher->dispatch(OutgoingSmsDeliveredEvent::EVENT_NAME, $event);
    }
}
