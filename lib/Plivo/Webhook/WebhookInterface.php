<?php

namespace Plivo\Webhook;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface WebhookInterface
 * @package Webhook
 */
interface WebhookInterface
{
    /**
     * Handle a request
     * @param Request $request
     * @return mixed
     */
    public function handleRequest(Request $request);
}
