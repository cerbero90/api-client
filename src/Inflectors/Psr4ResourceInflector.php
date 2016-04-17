<?php

namespace Cerbero\ApiClient\Inflectors;

/**
 * Resource inflector using the PSR-4 standard.
 *
 * @author    Andrea Marco Sartori
 */
class Psr4ResourceInflector implements ResourceInflectorInterface
{
    /**
     * Set the base namespace.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $namespace
     * @return    $this
     */
    public function namespace($namespace)
    {
        //
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
        //
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
        //
    }
}
