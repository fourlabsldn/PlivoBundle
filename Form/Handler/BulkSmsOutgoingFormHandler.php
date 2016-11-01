<?php

namespace FL\PlivoBundle\Form\Handler;

use FL\PlivoBundle\Event\OutgoingSmsSentEvent;
use Plivo\Model\BulkSmsInterface;
use Plivo\Model\SmsOutgoingInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BulkSmsOutgoingFormHandler
 * @package FL\PlivoBundle\Form\Handler
 */
class BulkSmsOutgoingFormHandler extends SmsFormHandler
{
    /**
     * @param FormInterface $form
     * @param Request $request
     */
    public function handle(FormInterface $form, Request $request)
    {
        if (!$request->isMethod('POST')) {
            return;
        }

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return;
        }

        $bulkSms = $form->getData();

        if (!$this->developmentMode) {
            $this->plivo->sendBulkSms($bulkSms, $this->getDeliveryReportUrl());
        }

        $this->dispatchEvents($bulkSms);
    }

    /**
     * Dispatch an event for each SMS that has been sent to Plivo.
     * Since the messages have already been sent, they also need to
     * be set as 'queued'.
     * @param BulkSmsInterface $bulkSms
     */
    public function dispatchEvents(BulkSmsInterface $bulkSms)
    {
        $to = $bulkSms->getTo();
        $uuids = $bulkSms->getUuids();

        for ($i = 0, $count = count($to); $i < $count; $i++) {
            $sms = new $this->smsClass();
            /** @var SmsOutgoingInterface $sms */
            $sms->setQueued()
                ->setTo($to[$i])
                ->setUuid($uuids[$i])
                ->setFrom($bulkSms->getFrom())
                ->setText($bulkSms->getText())
            ;

            $event = new OutgoingSmsSentEvent($sms);
            $this->dispatcher->dispatch(OutgoingSmsSentEvent::EVENT_NAME, $event);
        }
    }
}
