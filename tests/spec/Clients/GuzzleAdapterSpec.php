<?php

namespace spec\Cerbero\FluentApi\Clients;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GuzzleAdapterSpec extends ObjectBehavior
{
    /**
     * Initialise the test.
     *
     * @param    GuzzleHttp\ClientInterface    $client
     * @return    void
     */
    public function let(ClientInterface $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\FluentApi\Clients\GuzzleAdapter');
    }

    /**
     * @testdox    It proxies synchronous calls to the Guzzle client.
     *
     * @return    void
     */
    public function it_proxies_synchronous_calls_to_the_Guzzle_client($client)
    {
        $client->request('verb', 'endpoint', [])->willReturn('foo');

        $this->call('verb', 'endpoint', [])->shouldReturn('foo');
    }

    /**
     * @testdox    It proxies asynchronous calls to the Guzzle client.
     *
     * @return    void
     */
    public function it_proxies_asynchronous_calls_to_the_Guzzle_client($client, PromiseInterface $promise)
    {
        $success = function ($response) {};
        $failure = function ($exception) {};

        $promise->then($success, $failure)->willReturn('foo');
        $client->requestAsync('verb', 'endpoint', [])->willReturn($promise);

        $this->then('verb', 'endpoint', [], $success, $failure)->shouldReturn('foo');
    }
}
