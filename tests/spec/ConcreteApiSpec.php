<?php

namespace spec\Cerbero\ApiClient;

use Cerbero\ApiClient\Clients\ClientInterface;
use Cerbero\ApiClient\Clients\GuzzleAdapter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConcreteApiSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\ApiClient\ConcreteApi');
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
