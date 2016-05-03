<?php

namespace Cerbero\FluentApi\ConcreteApi;

use Exception;
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

    /**
     * Dummy method to test resource custom methods.
     *
     * @param    mixed    $input
     * @return    string
     */
    public function customMethod($input)
    {
        throw new Exception("called custom method with \"{$input}\"");
    }
}
