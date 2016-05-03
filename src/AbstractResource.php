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
     * Update the given request with the resource options.
     *
     * @param    Cerbero\FluentApi\Requests\Request    $request
     * @return    Cerbero\FluentApi\Requests\Request
     */
    public function updateOptions(Request $request)
    {
        return $this->request = $request->setOptions($this->getOptions());
    }

    /**
     * Fill the given request with the resource details.
     *
     * @param    Cerbero\FluentApi\Requests\Request    $request
     * @return    Cerbero\FluentApi\Requests\Request
     */
    public function fillRequest(Request $request)
    {
        return $this->request = $this->updateOptions($request)
                                     ->setVerb($this->getVerb())
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
        $this->options = array_merge_recursive($this->getOptions(), $options);

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

    /**
     * Set a singular HTTP call option.
     *
     * @param    string    $option
     * @param    mixed    $value
     * @return    $this
     */
    public function setOption($option, $value)
    {
        if (is_array($value)) {
            $value = array_merge((array) $this->getOption($option), $value);
        }

        $this->options[$option] = $value;

        return $this;
    }

    /**
     * Retrieve a singular HTTP call option.
     *
     * @param    string    $option
     * @return    mixed
     */
    public function getOption($option)
    {
        if (isset($this->options[$option])) {
            return $this->options[$option];
        }

        return null;
    }
}
