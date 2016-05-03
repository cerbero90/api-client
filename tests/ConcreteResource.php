<?php

namespace Cerbero\FluentApi;

use Cerbero\FluentApi\Requests\Request;

/**
 * Dummy class for testing AbstractResource.
 *
 * @author    Andrea Marco Sartori
 */
class ConcreteResource extends AbstractResource
{
    /**
     * The resource HTTP verb.
     *
     * @var string|null
     */
    protected $verb = 'GET';

    /**
     * The ID of the resource.
     *
     * @var integer|null
     */
    protected $id;

    /**
     * The HTTP call options.
     *
     * @var array
     */
    protected $options = ['foo'];

    /**
     * Set the dependencies.
     *
     * @param    integer|null    $id
     * @return    void
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Retrieve the resource endpoint.
     *
     * @return    string
     */
    public function getEndpoint()
    {
        return $this->id ? "resources/{$this->id}" : 'resources';
    }

    /**
     * Retrieve the request to pass through resources.
     *
     * @return    Cerbero\FluentApi\Requests\Request
     */
    public function getRequest()
    {
        return $this->request ?: new Request('');
    }
}
