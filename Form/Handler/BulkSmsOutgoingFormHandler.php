<?php

namespace FL\PlivoBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BulkSmsOutgoingFormHandler.
 */
class BulkSmsOutgoingFormHandler extends SmsFormHandler
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

        $bulkSms = $form->getData();

        $this->plivo->sendBulkSms($bulkSms);
    }
}
