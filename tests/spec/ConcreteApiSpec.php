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
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\FluentApi\ConcreteApi');
    }

    /**
     * @testdox    It uses v1 by default if no version has provided.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_uses_v1_by_default_if_no_version_has_provided()
    {
        $this->version()->shouldReturn('v1');
    }

    /**
     * @testdox    It uses the Guzzle client by default if no client has provided.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_uses_the_Guzzle_client_by_default_if_no_client_has_provided()
    {
        $this->client()->shouldBeAnInstanceOf(GuzzleAdapter::class);
    }

    /**
     * @testdox    It uses the PSR4 inflector by default if no inflector has provided.
     *
     * @return    void
     */
    public function it_uses_the_PSR4_inflector_by_default_if_no_inflector_has_provided()
    {
        $this->inflector()->shouldBeAnInstanceOf(Psr4ResourceInflector::class);
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

        $this->client()->shouldReturn($client);
    }

    /**
     * @testdox    It sets and retrieves the base URL.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_sets_and_retrieves_the_base_URL()
    {
        $this->setUrl('foo')->shouldReturn($this);

        $this->url()->shouldReturn('foo');
    }

    /**
     * @testdox    It retrieves version 1 as default if no version has provided.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_retrieves_version_1_as_default_if_no_version_has_provided()
    {
        $this->version()->shouldReturn('v1');
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

        $this->version()->shouldReturn('foo');
    }
}
