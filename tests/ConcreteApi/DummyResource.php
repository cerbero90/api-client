<?php

namespace Cerbero\FluentApi\ConcreteApi;

use Cerbero\FluentApi\AbstractResource;
use Cerbero\FluentApi\Requests\Request;

/**
 * Dummy class to test resources.
 *
 */
class DummyResource extends AbstractResource
{
    /**
     * The resource HTTP verb.
     *
     * @var string|null
     */
    protected $verb = 'GET';

    /**
     * Retrieve the resource endpoint.
     *
     * @return    string
     */
    public function getEndpoint()
    {
        return 'resources';
    }
}
