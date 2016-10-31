<?php

namespace Plivo\Client;

interface RestClientInterface
{
    /**
     * Post an SMS message through Plivo.
     * @param array $message
     * @return mixed
     */
    public function postMessage(array $message);
}
