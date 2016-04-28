<?php

namespace Cerbero\FluentApi\ConcreteApi\DummyResource;

use Cerbero\FluentApi\AbstractResource;

/**
 * Dummy class to test nested resources.
 *
 */
class NestedResource extends AbstractResource
{
    /**
     * The resource HTTP verb.
     *
     * @var string|null
     */
    protected $verb = 'POST';

    /**
     * Retrieve the resource endpoint.
     *
     * @return    string
     */
    public function getEndpoint()
    {
        return 'nested';
    }
}
