<?php

namespace spec\Cerbero\FluentApi\Requests;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
    /**
     * Initialise the test.
     *
     * @return    void
     */
    public function let()
    {
        $this->beConstructedWith('url/');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\FluentApi\Requests\Request');
    }

    /**
     * @testdox    It sets the base API URL when initialised.
     *
     * @return    void
     */
    public function it_sets_the_base_API_URL_when_initialised()
    {
        $this->endpoint()->shouldReturn('url/');
    }

    /**
     * @testdox    It sets and retrieves the HTTP verb.
     *
     * @return    void
     */
    public function it_sets_and_retrieves_the_HTTP_verb()
    {
        $this->setVerb('foo')->shouldReturn($this);

        $this->verb()->shouldReturn('foo');
    }

    /**
     * @testdox    It sets and retrieves the endpoint.
     *
     * @return    void
     */
    public function it_sets_and_retrieves_the_endpoint()
    {
        $this->setEndpoint('foo')->shouldReturn($this);

        $this->endpoint()->shouldReturn('url/foo');
    }

    /**
     * @testdox    It sets and retrieves the options.
     *
     * @return    void
     */
    public function it_sets_and_retrieves_the_options()
    {
        $this->setOptions(['foo'])->shouldReturn($this);

        $this->options()->shouldReturn(['foo']);
    }
}
