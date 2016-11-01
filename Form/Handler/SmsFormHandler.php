<?php

namespace FL\PlivoBundle\Form\Handler;

use Plivo\Plivo;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class SmsFormHandler
 * @package FL\PlivoBundle\Form\Handler
 */
abstract class SmsFormHandler
{
    /**
     * @var Plivo
     */
    protected $plivo;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var string
     */
    protected $smsClass;

    /**
     * SmsFormHandler constructor.
     * @param Plivo $plivo
     * @param EventDispatcherInterface $dispatcher
     * @param RouterInterface $router
     * @param string $smsClass
     */
    public function __construct(
        Plivo $plivo,
        EventDispatcherInterface $dispatcher,
        RouterInterface $router,
        string $smsClass
    ) {
        $this->plivo = $plivo;
        $this->dispatcher = $dispatcher;
        $this->router = $router;
        $this->smsClass = $smsClass;
    }

    /**
     * Return the absolute URL for Plivo to send the message delivery report.
     * @return string
     */
    protected function getDeliveryReportUrl(): string
    {
        return $this->router->generate('fl_plivo.message_delivery_report', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
