<?php

namespace FL\PlivoBundle\Webhook;

use FL\PlivoBundle\Event\IncomingSmsReceivedEvent;
use Plivo\Model\SmsInterface;
use Plivo\Webhook\WebhookInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IncomingSmsWebhook
 * @package Webhook
 */
class IncomingSmsWebhook implements WebhookInterface
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
     * IncomingSmsWebhook constructor.
     * @param EventDispatcherInterface $dispatcher
     * @param string $smsClass
     */
    public function __construct(EventDispatcherInterface $dispatcher, string $smsClass)
    {
        $this->dispatcher = $dispatcher;
        $this->smsClass = $smsClass;
    }

    /**
     * Convert a request into an SmsIncoming object
     * @param Request $request
     * @return void
     */
    public function handleRequest(Request $request)
    {
        $smsIncoming = new $this->smsClass();
        /** @var SmsInterface $smsIncoming */
        $smsIncoming
            ->setFrom($request->request->get('From'))
            ->setTo($request->request->get('To'))
            ->setText($request->request->get('Text'))
            ->setUuid($request->request->get('MessageUUID'))
        ;

        $event = new IncomingSmsReceivedEvent($smsIncoming);
        $this->dispatcher->dispatch(IncomingSmsReceivedEvent::EVENT_NAME, $event);
    }
}
