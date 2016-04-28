<?php

namespace Cerbero\FluentApi;

use BadMethodCallException;
use Cerbero\FluentApi\Inflectors\Psr4ResourceInflector;
use Cerbero\FluentApi\Inflectors\ResourceInflectorInterface;

/**
 * Abstract implementation of a versionable request maker.
 *
 * @author    Andrea Marco Sartori
 */
abstract class VersionableRequestMaker
{
    /**
     * The HTTP call request.
     *
     * @var Cerbero\FluentApi\Requests\Request
     */
    protected $request;

    /**
     * The version number of the API.
     *
     * @author  Andrea Marco Sartori
     * @var     string|null
     */
    protected $version;

    /**
     * Retrieve the request to pass through resources.
     *
     * @return    Cerbero\FluentApi\Requests\Request
     */
    abstract public function getRequest();

    /**
     * Set the version number.
     *
     * @author    Andrea Marco Sartori
     * @param    string|null    $version
     * @return    $this
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Retrieve the version number.
     *
     * @author    Andrea Marco Sartori
     * @return    string
     */
    public function getVersion()
    {
        return $this->version;
    }
}
