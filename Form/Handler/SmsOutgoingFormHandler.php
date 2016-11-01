<?php

namespace FL\PlivoBundle\Form\Handler;

use FL\PlivoBundle\Event\OutgoingSmsSentEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SmsOutgoingFormHandler
 * @package FL\PlivoBundle\Form\Handler
 */
class SmsOutgoingFormHandler extends SmsFormHandler
{
    /**
     * @param FormInterface $form
     * @param Request $request
     * @return void
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

        $sms = $form->getData();

        $this->plivo->sendSms($sms, $this->getDeliveryReportUrl());

        $event = new OutgoingSmsSentEvent($sms);
        $this->dispatcher->dispatch(OutgoingSmsSentEvent::EVENT_NAME, $event);
    }
}
