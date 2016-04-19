<?php

namespace Cerbero\ApiClient\Inflectors;

/**
 * Interface for resource inflectors.
 *
 * @author    Andrea Marco Sartori
 */
interface ResourceInflectorInterface
{
    /**
     * Set the base namespace.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $namespace
     * @return    $this
     */
    public function baseNamespace($namespace);

    /**
     * Set the version number.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $version
     * @return    $this
     */
    public function version($version);

    /**
     * Inflect the given name returning the full resource name.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $name
     * @return    string
     */
    public function inflect($name);
}
