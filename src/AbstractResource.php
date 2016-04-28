<?php

namespace Cerbero\FluentApi;

use Cerbero\FluentApi\Requests\Request;

/**
 * Abstract implementation of an API resource.
 *
 */
abstract class AbstractResource extends VersionableRequestMaker
{
    /**
     * The resource HTTP verb.
     *
     * @var string|null
     */
    protected $verb;

    /**
     * The HTTP call options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Retrieve the resource endpoint.
     *
     * @return    string
     */
    abstract public function getEndpoint();

    /**
     * Retrieve the request to pass through resources.
     *
     * @return    Cerbero\FluentApi\Requests\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Fill the given request with the resource details.
     *
     * @param    Cerbero\FluentApi\Requests\Request    $request
     * @return    Cerbero\FluentApi\Requests\Request
     */
    public function fillRequest(Request $request)
    {
        return $this->request = $request->setVerb($this->getVerb())
                                        ->setOptions($this->getOptions())
                                        ->setEndpoint($this->getEndpoint());
    }

    /**
     * Retrieve the resource HTTP verb.
     *
     * @return    string
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * Set the HTTP call options.
     *
     * @param    array    $options
     * @return    $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Retrieve the HTTP call options.
     *
     * @return    array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
