<?php

namespace Cerbero\ApiClient;

use Cerbero\ApiClient\Clients\ClientInterface;
use Cerbero\ApiClient\Clients\GuzzleAdapter;
use Cerbero\ApiClient\Inflectors\InflectsResources;
use Cerbero\ApiClient\Inflectors\ResourceInflectorInterface;
use GuzzleHttp\Client;

/**
 * Abstract implementation of an API start point.
 *
 * @author    Andrea Marco Sartori
 */
abstract class AbstractApi
{
    use InflectsResources;

    /**
     * The version number of the API.
     *
     * @author  Andrea Marco Sartori
     * @var     string
     */
    protected $version;

    /**
     * The HTTP client.
     *
     * @author  Andrea Marco Sartori
     * @var     Cerbero\ApiClient\Clients\ClientInterface
     */
    protected $client;

    /**
     * The API base URL. eg: https://test.com:123/api/v1
     *
     * @author  Andrea Marco Sartori
     * @var     string
     */
    protected $url;

    /**
     * Set the dependencies.
     *
     * @author    Andrea Marco Sartori
     * @param    string|null    $version
     * @param    Cerbero\ApiClient\Clients\ClientInterface|null    $client
     * @param    Cerbero\ApiClient\Inflectors\ResourceInflectorInterface|null    $inflector
     * @return    void
     */
    public function __construct(
        $version = null,
        ClientInterface $client = null,
        ResourceInflectorInterface $inflector = null
    ) {
        $this->setVersion($version)
             ->setClient($client)
             ->setInflector($inflector);
    }

    /**
     * Dynamically call API endpoints.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $name
     * @return    mixed
     */
    public function __call($name, array $arguments)
    {
        $resource = $this->inflectResource($name, $arguments);

        $resource->request($request = new Request);

        return $this->client->call(
            $request->verb(), $request->endpoint(), $request->options()
        );
    }

    /**
     * Set the version number.
     *
     * @author    Andrea Marco Sartori
     * @param    string|null    $version
     * @return    $this
     */
    public function setVersion($version)
    {
        $this->version = $version ?: $this->defaultVersion();

        return $this;
    }

    /**
     * Retrieve the default version number.
     *
     * @author    Andrea Marco Sartori
     * @return    string
     */
    protected function defaultVersion()
    {
        return 'v1';
    }

    /**
     * Set the HTTP client.
     *
     * @author    Andrea Marco Sartori
     * @param    Cerbero\ApiClient\Clients\ClientInterface|null    $client
     * @return    $this
     */
    public function setClient(ClientInterface $client = null)
    {
        $this->client = $client ?: $this->defaultClient();

        return $this;
    }

    /**
     * Retrieve the default HTTP client to use if none is provided.
     *
     * @author    Andrea Marco Sartori
     * @return    Cerbero\ApiClient\Clients\ClientInterface
     */
    protected function defaultClient()
    {
        return new GuzzleAdapter(new Client);
    }

    /**
     * Retrieve the version number.
     *
     * @author    Andrea Marco Sartori
     * @return    string
     */
    public function version()
    {
        return $this->version;
    }

    /**
     * Retrieve the HTTP client.
     *
     * @author    Andrea Marco Sartori
     * @return    Cerbero\ApiClient\Clients\ClientInterface
     */
    public function client()
    {
        return $this->client;
    }

    /**
     * Set the base URL.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $url
     * @return    $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Retrieve the base URL.
     *
     * @author    Andrea Marco Sartori
     * @return    string
     */
    public function url()
    {
        return $this->url;
    }
}
