<?php

namespace Cerbero\FluentApi\ConcreteApi;

use Cerbero\FluentApi\AbstractResource;
use Cerbero\FluentApi\Requests\Request;

/**
 * Dummy class to test versioned resources.
 *
 */
class VersionedResource extends AbstractResource
{
    /**
     * The resource HTTP verb.
     *
     * @var string|null
     */
    protected $verb = 'GET';

    /**
     * The version number of the API.
     *
     * @author  Andrea Marco Sartori
     * @var     string|null
     */
    protected $version = 'v2';

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
