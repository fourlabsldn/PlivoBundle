<?php

namespace Plivo\Action;

use FOS\RestBundle\View\View;
use Plivo\Webhook\WebhookInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ApiMessageDeliveryReportAction
 * @package Plivo\Action
 */
class ApiMessageDeliveryReportAction
{
    /**
     * @var WebhookInterface
     */
    private $webhook;

    /**
     * ApiMessageDeliveryReportAction constructor.
     * @param WebhookInterface $webhook
     */
    public function __construct(WebhookInterface $webhook)
    {
        $this->webhook = $webhook;
    }

    /**
     * Receive and validate an SMS delivery request coming from Plivo.
     * @param Request $request
     * @return View
     */
    public function __invoke(Request $request): View
    {
        if (!$request->request->has('From')) {
            throw new BadRequestHttpException('Expected field "from" not set.');
        }

        if (!$request->request->has('To')) {
            throw new BadRequestHttpException('Expected field "to" not set.');
        }

        if (!$request->request->has('Status')) {
            throw new BadRequestHttpException('Expected field "status" not set.');
        }

        if (!$request->request->has('MessageUUID')) {
            throw new BadRequestHttpException('Expected field "messageUUID" not set.');
        }

        $this->webhook->handleRequest($request);

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
