<?php

namespace Plivo\Action;

use FOS\RestBundle\View\View;
use Plivo\Webhook\WebhookInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ApiPostMessageAction
 * This will be the endpoint that receives SMS messages
 * sent from Plivo when they are received.
 * @package Plivo\Action
 */
class ApiPostMessageAction
{
    /**
     * @var WebhookInterface
     */
    private $webhook;

    /**
     * ApiPostMessageAction constructor.
     * @param WebhookInterface $webhook
     */
    public function __construct(WebhookInterface $webhook)
    {
        $this->webhook = $webhook;
    }

    /**
     * Receive and validate an Sms received request coming from Plivo.
     * @param Request $request
     * @return View
     */
    public function __invoke(Request $request): View
    {
        if (!$request->request->has('From')) {
            throw new BadRequestHttpException('Expected field "From" not set.');
        }

        if (!$request->request->has('To')) {
            throw new BadRequestHttpException('Expected field "To" not set.');
        }

        if (!$request->request->has('Text')) {
            throw new BadRequestHttpException('Expected field "Text" not set.');
        }

        if (!$request->request->has('MessageUUID')) {
            throw new BadRequestHttpException('Expected field "MessageUUID" not set.');
        }

        $this->webhook->handleRequest($request);

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
