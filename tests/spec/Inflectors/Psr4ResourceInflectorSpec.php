<?php

namespace spec\Cerbero\FluentApi\Inflectors;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Psr4ResourceInflectorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\FluentApi\Inflectors\Psr4ResourceInflector');
    }

    /**
     * @testdox    It inflects the given name.
     *
     * @return    void
     */
    public function it_inflects_the_given_name()
    {
        $this->inflect('foo')->shouldReturn('Foo');
    }

    /**
     * @testdox    It inflects the given name with the base namespace.
     *
     * @return    void
     */
    public function it_inflects_the_given_name_with_the_base_namespace()
    {
        $this->baseNamespace('foo')->inflect('bar')->shouldReturn('foo\Bar');
    }

    /**
     * @testdox    It inflects the given name with the version number.
     *
     * @return    void
     */
    public function it_inflects_the_given_name_with_the_version_number()
    {
        $this->version('v1')->inflect('bar')->shouldReturn('V1\Bar');
    }

    /**
     * @testdox    It inflects the given name with the base namespace and the version number.
     *
     * @return    void
     */
    public function it_inflects_the_given_name_with_the_base_namespace_and_the_version_number()
    {
        $this->baseNamespace('foo')->version('v1')->inflect('bar')->shouldReturn('foo\V1\Bar');
    }
}
