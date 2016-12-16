<?php

namespace FL\PlivoBundle\Form\Handler;

use Plivo\Plivo;

/**
 * Class SmsFormHandler.
 */
abstract class SmsFormHandler
{
    /**
     * @var Plivo
     */
    protected $plivo;

    /**
     * SmsFormHandler constructor.
     *
     * @param Plivo $plivo
     */
    public function __construct(
        Plivo $plivo
    ) {
        $this->plivo = $plivo;
    }
}
