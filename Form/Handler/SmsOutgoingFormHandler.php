<?php

namespace FL\PlivoBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SmsOutgoingFormHandler.
 */
class SmsOutgoingFormHandler extends SmsFormHandler
{
    /**
     * @param FormInterface $form
     * @param Request       $request
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
    }
}
