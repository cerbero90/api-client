<?php

namespace Cerbero\FluentApi;

use BadMethodCallException;
use Cerbero\FluentApi\Clients\AsyncClientInterface;
use Cerbero\FluentApi\Clients\ClientInterface;
use Cerbero\FluentApi\Clients\GuzzleAdapter;
use Cerbero\FluentApi\Inflectors\Psr4ResourceInflector;
use Cerbero\FluentApi\Inflectors\ResourceInflectorInterface;
use Cerbero\FluentApi\Requests\Request;
use Closure;
use Exception;
use GuzzleHttp\Client;

/**
 * Abstract implementation of an API start point.
 *
 * @author    Andrea Marco Sartori
 */
abstract class AbstractApi extends VersionableRequestMaker
{
    /**
     * The HTTP client.
     *
     * @author  Andrea Marco Sartori
     * @var     Cerbero\FluentApi\Clients\ClientInterface
     */
    protected $client;

    /**
     * The resource inflector.
     *
     * @author  Andrea Marco Sartori
     * @var     Cerbero\FluentApi\Inflectors\ResourceInflectorInterface
     */
    protected $inflector;

    /**
     * The latest resource invoked.
     *
     * @var Cerbero\FluentApi\AbstractResource|null
     */
    protected $resource;

    /**
     * Set the dependencies.
     *
     * @author    Andrea Marco Sartori
     * @param    string|null    $version
     * @param    Cerbero\FluentApi\Clients\ClientInterface|null    $client
     * @param    Cerbero\FluentApi\Inflectors\ResourceInflectorInterface|null    $inflector
     * @return    void
     */
    public function __construct(
        $version = null,
        ClientInterface $client = null,
        ResourceInflectorInterface $inflector = null
    ) {
        $client    = $client    ?: $this->defaultClient();
        $inflector = $inflector ?: $this->defaultInflector();

        $this->setVersion($version)->setClient($client)->setInflector($inflector);
    }

    /**
     * Dynamically resolve resources.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $name
     * @param    array    $parameters
     * @return    $this
     */
    public function __call($name, array $parameters)
    {
        if ($this->resource && method_exists($this->resource, $name)) {
            $this->request = $this->getRequestFromPreviousResource($name, $parameters);
        } else {
            $this->request = $this->getRequestByResolvingResource($name, $parameters);
        }

        return $this;
    }

    /**
     * Retrieve the updated request from the previously resolved resource.
     *
     * @param    string    $method
     * @param    array    $parameters
     * @return    Cerbero\FluentApi\Requests\Request
     */
    private function getRequestFromPreviousResource($method, array $parameters)
    {
        call_user_func_array([$this->resource, $method], $parameters);

        return $this->resource->updateOptions($this->getRequest());
    }

    /**
     * Retrieve the request from the newly resolved resource.
     *
     * @param    string    $resource
     * @param    array    $parameters
     * @return    Cerbero\FluentApi\Requests\Request
     */
    private function getRequestByResolvingResource($resource, array $parameters)
    {
        $class = $this->inflectResource($resource);

        $this->resource = new $class(...$parameters);

        return $this->resource->fillRequest($this->getRequest());
    }

    /**
     * Retrieve the base URL.
     *
     * @author    Andrea Marco Sartori
     * @return    string
     */
    abstract public function getUrl();

    /**
     * Retrieve the resource to call by inflecting the given name.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $name
     * @return    Cerbero\FluentApi\Resources\ResourceInterface
     */
    protected function inflectResource($name)
    {
        $target = $this->resource ?: $this;

        $resource = $this->getInflector()->baseNamespace(get_class($target))
                                         ->version($target->getVersion())
                                         ->inflect($name);

        if (class_exists($resource)) {
            return $resource;
        }

        throw new BadMethodCallException("The resource [$resource] does not exist.");
    }

    /**
     * Retrieve the resource inflector.
     *
     * @return    Cerbero\FluentApi\Inflectors\ResourceInflectorInterface
     */
    public function getInflector()
    {
        return $this->inflector ?: $this->defaultInflector();
    }

    /**
     * Retrieve the default inflector.
     *
     * @author    Andrea Marco Sartori
     * @return    Cerbero\FluentApi\Inflectors\ResourceInflectorInterface
     */
    protected function defaultInflector()
    {
        return new Psr4ResourceInflector;
    }

    /**
     * Set the resource inflector.
     *
     * @author    Andrea Marco Sartori
     * @param    Cerbero\FluentApi\Inflectors\ResourceInflectorInterface    $inflector
     * @return    $this
     */
    public function setInflector(ResourceInflectorInterface $inflector)
    {
        $this->inflector = $inflector;

        return $this;
    }

    /**
     * Perform a synchronous call to the eventual endpoint.
     *
     * @return    Psr\Http\Message\ResponseInterface
     */
    public function call()
    {
        return $this->performCall();
    }

    /**
     * Perform an HTTP call by using the client.
     *
     * @param    Closure|null    $success
     * @param    Closure|null    $failure
     * @return    mixed
     */
    private function performCall(Closure $success = null, Closure $failure = null)
    {
        $parameters = [
            $this->request->verb(), $this->request->endpoint(), $this->request->options(),
        ];

        if ($success) {
            array_push($parameters, $success, $failure);
        }

        return call_user_func_array(
            [$this->getClient(), $success ? 'then' : 'call'], $parameters
        );
    }

    /**
     * Perform an asynchronous call to the eventual endpoint.
     *
     * @param    Closure    $success
     * @param    Closure|null    $failure
     * @return    mixed
     */
    public function then(Closure $success, Closure $failure = null)
    {
        if (! $this->getClient() instanceof AsyncClientInterface) {
            throw new Exception("The set client can't perform asynchronous calls.");
        }

        return $this->performCall($success, $failure);
    }

    /**
     * Retrieve the body of the response as a JSON object.
     *
     * @return    \StdClass
     */
    public function toJson()
    {
        return $this->decodeBody();
    }

    /**
     * Retrieve the decoded response body.
     *
     * @param    boolean    $toArray
     * @return    \StdClass|array
     */
    private function decodeBody($toArray = false)
    {
        $body = $this->call()->getBody()->getContents();

        return json_decode($body, $toArray);
    }

    /**
     * Retrieve the body of the response as an array.
     *
     * @return    array
     */
    public function toArray()
    {
        return $this->decodeBody(true);
    }

    /**
     * Retrieve the eventual API URL.
     *
     * @return    string
     */
    public function toUrl()
    {
        $options = $this->getRequest()->options();

        $query = $this->getQueryByOptions($options);

        return $this->getRequest()->endpoint() . $query;
    }

    /**
     * Retrieve the query string parameters by the given options.
     *
     * @param    array    $options
     * @return    string
     */
    private function getQueryByOptions(array $options)
    {
        $query = $this->getClient()->getQueryByOptions($options);

        return empty($query) ? '' : '?' . http_build_query($query);
    }

    /**
     * Retrieve the request to pass through resources.
     *
     * @return    Cerbero\FluentApi\Requests\Request
     */
    public function getRequest()
    {
        return $this->request ?: new Request($this->getUrl());
    }

    /**
     * Set the HTTP client.
     *
     * @author    Andrea Marco Sartori
     * @param    Cerbero\FluentApi\Clients\ClientInterface    $client
     * @return    $this
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Retrieve the HTTP client.
     *
     * @author    Andrea Marco Sartori
     * @return    Cerbero\FluentApi\Clients\ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Retrieve the default HTTP client to use if none is provided.
     *
     * @author    Andrea Marco Sartori
     * @return    Cerbero\FluentApi\Clients\ClientInterface
     */
    protected function defaultClient()
    {
        return new GuzzleAdapter(new Client);
    }
}
