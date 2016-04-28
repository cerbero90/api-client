<?php

namespace Cerbero\FluentApi\Inflectors;

/**
 * Resource inflector using the PSR-4 standard.
 *
 * @author    Andrea Marco Sartori
 */
class Psr4ResourceInflector implements ResourceInflectorInterface
{
    /**
     * The base namespace.
     *
     * @author  Andrea Marco Sartori
     * @var     string
     */
    protected $namespace;

    /**
     * The version number.
     *
     * @author  Andrea Marco Sartori
     * @var     string
     */
    protected $version;

    /**
     * Set the base namespace.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $namespace
     * @return    $this
     */
    public function baseNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Set the version number.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $version
     * @return    $this
     */
    public function version($version)
    {
        $this->version = ucfirst($version);

        return $this;
    }

    /**
     * Inflect the given name returning the full resource name.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $name
     * @return    string
     */
    public function inflect($name)
    {
        $segments = [$this->namespace, $this->version, ucfirst($name)];

        return implode('\\', array_filter($segments));
    }
}
