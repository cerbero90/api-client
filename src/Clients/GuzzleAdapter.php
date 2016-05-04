<?php

namespace Cerbero\FluentApi\Clients;

use Closure;
use GuzzleHttp\ClientInterface as Guzzle;
use Guzzle\Http\Client;

/**
 * Adapter for the Guzzle HTTP client.
 *
 * @author    Andrea Marco Sartori
 */
class GuzzleAdapter implements AsyncClientInterface
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
     * Process the HTTP request synchronously.
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

    /**
     * Process the HTTP request asynchronously.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $verb
     * @param    string    $endpoint
     * @param    array    $options
     * @param    Closure    $success
     * @param    Closure|null    $failure
     * @return    mixed
     */
    public function then($verb, $endpoint, array $options = [], Closure $success, Closure $failure = null)
    {
        return $this->client->requestAsync($verb, $endpoint, $options)->then($success, $failure);
    }

    /**
     * Retrieve the query string parameters from the given options.
     *
     * @param    array    $options
     * @return    array
     */
    public function getQueryByOptions(array $options)
    {
        return isset($options['query']) ? $options['query'] : [];
    }
}
