<?php

namespace Plivo\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;

/**
 * Class RestClientGuzzle.
 */
class RestClientGuzzle extends RestClient implements RestClientGuzzleInterface
{
    /**
     * @var ClientInterface
     */
    private $guzzle;

    /**
     * {@inheritdoc}
     */
    public function __construct(ClientInterface $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * {@inheritdoc}
     */
    public function postMessage(array $message)
    {
        $response = $this->guzzle->request('POST', self::PATH_MESSAGE, [
            'json' => $message,
            'allow_redirects' => false,
        ]);

        if ($response->getStatusCode() !== 202) {
            throw new TransferException(
                'Unexpected HTTP status code, expected 202, received '.$response->getStatusCode(),
                $response->getStatusCode()
            );
        }

        // Added this line due to a Guzzle bug. If you use $response->getBody->getContents()
        // without rewinding, the body will be empty. More information here:
        // https://github.com/8p/GuzzleBundle/issues/48
        $response->getBody()->rewind();

        $plivoResponse = json_decode($response->getBody()->getContents());

        return $plivoResponse->message_uuid;
    }
}
