<?php

namespace Cerbero\FluentApi\Requests;

/**
 * Interface for requests.
 *
 */
interface RequestInterface
{
    /**
     * Set the HTTP verb.
     *
     * @param    string    $verb
     * @return    $this
     */
    public function setVerb($verb);

    /**
     * Retrieve the HTTP verb.
     *
     * @return    string
     */
    public function verb();

    /**
     * Set the endpoint.
     *
     * @param    string    $endpoint
     * @return    $this
     */
    public function setEndpoint($endpoint);

    /**
     * Retrieve the endpoint.
     *
     * @return    string
     */
    public function endpoint();

    /**
     * Set the options.
     *
     * @param    array    $options
     * @return    $this
     */
    public function setOptions(array $options);

    /**
     * Retrieve the options.
     *
     * @return    array
     */
    public function options();
}
