<?php

namespace Cerbero\FluentApi\Requests;

/**
 * Resource request.
 *
 */
class Request implements RequestInterface
{
    /**
     * The HTTP verb.
     *
     * @var string
     */
    protected $verb;

    /**
     * The endpoint.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Set the base API URL.
     *
     * @param    string    $url
     * @return    void
     */
    public function __construct($url)
    {
        $this->setEndpoint($url);
    }

    /**
     * Set the HTTP verb.
     *
     * @param    string    $verb
     * @return    $this
     */
    public function setVerb($verb)
    {
        $this->verb = $verb;

        return $this;
    }

    /**
     * Retrieve the HTTP verb.
     *
     * @return    string
     */
    public function verb()
    {
        return $this->verb;
    }

    /**
     * Set the endpoint.
     *
     * @param    string    $endpoint
     * @return    $this
     */
    public function setEndpoint($endpoint)
    {
        $this->normalizeEndpoint($endpoint);

        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Normalize the API endpoint.
     *
     * @param    string    $endpoint
     * @return    void
     */
    private function normalizeEndpoint(&$endpoint)
    {
        if ($url = $this->endpoint()) {
            $endpoint = rtrim($url, '/') . '/' . ltrim($endpoint, '/');
        }
    }

    /**
     * Retrieve the endpoint.
     *
     * @return    string
     */
    public function endpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set the options.
     *
     * @param    array    $options
     * @return    $this
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options(), $options);

        return $this;
    }

    /**
     * Retrieve the options.
     *
     * @return    array
     */
    public function options()
    {
        return $this->options;
    }
}
