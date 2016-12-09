<?php

namespace FL\PlivoBundle\Webhook;

use FL\PlivoBundle\Event\IncomingSmsReceivedEvent;
use Plivo\Model\SmsInterface;
use Plivo\Webhook\WebhookInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IncomingSmsWebhook.
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
     * Convert a request into an SmsIncoming object.
     *
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        /* @var SmsInterface $smsIncoming */
        $smsIncoming = new $this->smsClass();

        $from = $request->request->get('From');
        if (substr($from, 0, 1) !== '+') {
            $from = '+' . $from;
        }

        $to = $request->request->get('To');
        if (substr($to, 0, 1) !== '+') {
            $to = '+' . $to;
        }

        $smsIncoming
            ->setFrom($from)
            ->setTo($to)
            ->setText($request->request->get('Text'))
            ->setUuid($request->request->get('MessageUUID'))
        ;

        $event = new IncomingSmsReceivedEvent($smsIncoming);
        $this->dispatcher->dispatch(IncomingSmsReceivedEvent::EVENT_NAME, $event);
    }
}
