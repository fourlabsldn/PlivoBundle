<?php

namespace Plivo\Client;

use GuzzleHttp\ClientInterface;

interface RestClientGuzzleInterface extends RestClientInterface
{
    /**
     * RestClientGuzzleInterface constructor.
     * @param ClientInterface $guzzle
     */
    public function __construct(ClientInterface $guzzle);
}
