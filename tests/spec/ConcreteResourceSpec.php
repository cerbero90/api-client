<?php

namespace spec\Cerbero\FluentApi;

use BadMethodCallException;
use Cerbero\FluentApi\Inflectors\Psr4ResourceInflector;
use Cerbero\FluentApi\Inflectors\ResourceInflectorInterface;
use Cerbero\FluentApi\Requests\Request;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConcreteResourceSpec extends ObjectBehavior
{
    /**
     * Initialise the test.
     *
     * @return    void
     */
    public function let()
    {
        $this->beConstructedWith(22);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\FluentApi\ConcreteResource');
    }

    /**
     * @testdox    It retrieves the endpoint.
     *
     * @return    void
     */
    public function it_retrieves_the_endpoint()
    {
        $this->getEndpoint()->shouldReturn('resources/22');
    }

    /**
     * @testdox    It retrieves the request after filling it.
     *
     * @return    void
     */
    public function it_retrieves_the_request_after_filling_it()
    {
        $request = new Request('foo');

        $this->fillRequest($request);

        $this->getRequest()->shouldReturn($request);
        $this->getRequest()->endpoint()->shouldReturn('foo/resources/22');
    }

    /**
     * @testdox    It retrieves the verb.
     *
     * @return    void
     */
    public function it_retrieves_the_verb()
    {
        $this->getVerb()->shouldReturn('GET');
    }

    /**
     * @testdox    It sets and retrieves the HTTP call options.
     *
     * @return    void
     */
    public function it_sets_and_retrieves_the_HTTP_call_options()
    {
        $this->getOptions()->shouldReturn([]);

        $this->setOptions(['foo'])->shouldReturn($this);

        $this->getOptions()->shouldReturn(['foo']);
    }

    /**
     * @testdox    It sets and retrieves the version of the resource to use.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_sets_and_retrieves_the_version_of_the_resource_to_use()
    {
        $this->setVersion('foo')->shouldReturn($this);

        $this->getVersion()->shouldReturn('foo');
    }
}
