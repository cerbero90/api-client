<?php

namespace spec\Cerbero\FluentApi;

use BadMethodCallException;
use Cerbero\FluentApi\Clients\AsyncClientInterface;
use Cerbero\FluentApi\Clients\ClientInterface;
use Cerbero\FluentApi\Clients\GuzzleAdapter;
use Cerbero\FluentApi\ConcreteApi\DummyResource;
use Cerbero\FluentApi\Inflectors\Psr4ResourceInflector;
use Cerbero\FluentApi\Inflectors\ResourceInflectorInterface;
use Cerbero\FluentApi\Requests\Request;
use Exception;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConcreteApiSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\FluentApi\ConcreteApi');
    }

    /**
     * @testdox    It sets and retrieves the version of the API to use.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_sets_and_retrieves_the_version_of_the_API_to_use()
    {
        $this->setVersion('foo')->shouldReturn($this);

        $this->getVersion()->shouldReturn('foo');
    }

    /**
     * @testdox    It sets and retrieves the HTTP client.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_sets_and_retrieves_the_HTTP_client(ClientInterface $client)
    {
        $this->setClient($client)->shouldReturn($this);

        $this->getClient()->shouldReturn($client);
    }

    /**
     * @testdox    It uses the Guzzle client by default if no client has provided.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_uses_the_Guzzle_client_by_default_if_no_client_has_provided()
    {
        $this->getClient()->shouldBeAnInstanceOf(GuzzleAdapter::class);
    }

    /**
     * @testdox    It retrieves the base URL.
     *
     * @return    void
     */
    public function it_retrieves_the_base_URL()
    {
        $this->getUrl()->shouldReturn('http://test.com/v1/');
    }

    /**
     * @testdox    It retrieves a new request with the base API URL.
     *
     * @return    void
     */
    public function it_retrieves_a_new_request_with_the_base_API_URL()
    {
        $request = $this->getRequest();

        $request->shouldBeAnInstanceOf(Request::class);

        $request->endpoint()->shouldReturn('http://test.com/v1/');
    }

    /**
     * @testdox    It sets and retrieves the resource inflector.
     *
     * @return    void
     */
    public function it_sets_and_retrieves_the_resource_inflector(ResourceInflectorInterface $inflector)
    {
        $this->setInflector($inflector)->shouldReturn($this);

        $this->getInflector()->shouldReturn($inflector);
    }

    /**
     * @testdox    It uses the PSR4 inflector by default if no inflector has provided.
     *
     * @return    void
     */
    public function it_uses_the_PSR4_inflector_by_default_if_no_inflector_has_provided()
    {
        $this->getInflector()->shouldBeAnInstanceOf(Psr4ResourceInflector::class);
    }

    /**
     * @testdox    It throws an exception when a resource does not exist.
     *
     * @return    void
     */
    public function it_throws_an_exception_when_a_resource_does_not_exist()
    {
        $message = 'The resource [Cerbero\FluentApi\ConcreteApi\MissingResource] does not exist.';

        $exception = new BadMethodCallException($message);

        $this->shouldThrow($exception)->duringMissingResource();
    }

    /**
     * @testdox    It adds the version number to the inflected resource if it has provided.
     *
     * @return    void
     */
    public function it_adds_the_version_number_to_the_inflected_resource_if_it_has_provided()
    {
        $this->setVersion('v1');

        $message = 'The resource [Cerbero\FluentApi\ConcreteApi\V1\MissingResource] does not exist.';

        $exception = new BadMethodCallException($message);

        $this->shouldThrow($exception)->duringMissingResource();
    }

    /**
     * @testdox    It dynamically resolves resources and fill the request.
     *
     * @return    void
     */
    public function it_dynamically_resolves_resources_and_fill_the_request()
    {
        $this->dummyResource()->shouldReturn($this);

        $request = $this->getRequest();

        $request->verb()->shouldReturn('GET');
        $request->endpoint()->shouldReturn('http://test.com/v1/resources');
        $request->options()->shouldReturn([]);
    }

    /**
     * @testdox    It resolves nested resources.
     *
     * @return    void
     */
    public function it_resolves_nested_resources()
    {
        $this->dummyResource()->nestedResource()->shouldReturn($this);
    }

    /**
     * @testdox    It performs a synchronous HTTP call.
     *
     * @return    void
     */
    public function it_performs_a_synchronous_HTTP_call(ClientInterface $client)
    {
        $client->call('GET', 'http://test.com/v1/resources', [])->willReturn('response');

        $this->setClient($client);

        $this->dummyResource()->call()->shouldReturn('response');
    }

    /**
     * @testdox    It performs a synchronous HTTP call with nested resources.
     *
     * @return    void
     */
    public function it_performs_a_synchronous_HTTP_call_with_nested_resources(ClientInterface $client)
    {
        $client->call('POST', 'http://test.com/v1/resources/nested', [])->willReturn('response');

        $this->setClient($client);

        $this->dummyResource()->nestedResource()->call()->shouldReturn('response');
    }

    /**
     * @testdox    It performs a synchronous HTTP call with versioned nested resources.
     *
     * @return    void
     */
    public function it_performs_a_synchronous_HTTP_call_with_versioned_nested_resources(ClientInterface $client)
    {
        $client->call('POST', 'http://test.com/v1/resources/nested', [])->willReturn('response');

        $this->setClient($client);

        $this->versionedResource()->nestedResource()->call()->shouldReturn('response');
    }

    /**
     * @testdox    It throws an exception when performing an asynchronous call with a synchronous client.
     *
     * @return    void
     */
    public function it_throws_an_exception_when_performing_an_asynchronous_call_with_a_synchronous_client(ClientInterface $client)
    {
        $this->setClient($client);

        $exception = new Exception("The set client can't perform asynchronous calls.");
        $this->shouldThrow($exception)->duringThen(function () {});
    }

    /**
     * @testdox    It performs an asynchronous HTTP call.
     *
     * @return    void
     */
    public function it_performs_an_asynchronous_HTTP_call(AsyncClientInterface $client)
    {
        $success = function ($response) {};
        $failure = function ($exception) {};

        $client->then('GET', 'http://test.com/v1/resources', [], $success, $failure)->willReturn('response');

        $this->setClient($client);

        $this->dummyResource()->then($success, $failure)->shouldReturn('response');
    }

    /**
     * @testdox    It performs an asynchronous HTTP call with nested resources.
     *
     * @return    void
     */
    public function it_performs_an_asynchronous_HTTP_call_with_nested_resources(AsyncClientInterface $client)
    {
        $success = function ($response) {};
        $failure = function ($exception) {};

        $client->then('POST', 'http://test.com/v1/resources/nested', [], $success, $failure)->willReturn('response');

        $this->setClient($client);

        $this->dummyResource()->nestedResource()->then($success, $failure)->shouldReturn('response');
    }

    /**
     * @testdox    It performs an asynchronous HTTP call with versioned nested resources.
     *
     * @return    void
     */
    public function it_performs_an_asynchronous_HTTP_call_with_versioned_nested_resources(AsyncClientInterface $client)
    {
        $success = function ($response) {};
        $failure = function ($exception) {};

        $client->then('POST', 'http://test.com/v1/resources/nested', [], $success, $failure)->willReturn('response');

        $this->setClient($client);

        $this->versionedResource()->nestedResource()->then($success, $failure)->shouldReturn('response');
    }
}
