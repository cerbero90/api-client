<?php

namespace Cerbero\FluentApi\Clients;

use GuzzleHttp\ClientInterface as Guzzle;
use Guzzle\Http\Client;

/**
 * Adapter for the Guzzle HTTP client.
 *
 * @author    Andrea Marco Sartori
 */
class GuzzleAdapter implements ClientInterface
{
    /**
     * The Guzzle client.
     *
     * @author  Andrea Marco Sartori
     * @var     GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Set the dependencies.
     *
     * @author    Andrea Marco Sartori
     * @param    GuzzleHttp\ClientInterface    $client
     * @return    void
     */
    public function __construct(Guzzle $client)
    {
        $this->client = $client;
    }

    /**
     * Process the HTTP request.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $verb
     * @param    string    $endpoint
     * @param    array    $options
     * @return    mixed
     */
    public function call($verb, $endpoint, array $options = [])
    {
        return $this->client->request($verb, $endpoint, $options);
    }
}
