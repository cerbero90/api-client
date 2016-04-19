<?php

namespace Cerbero\ApiClient\Inflectors;

use BadMethodCallException;
use Cerbero\ApiClient\Inflectors\Psr4ResourceInflector;

/**
 * Trait to inflect resources.
 *
 * @author    Andrea Marco Sartori
 */
trait InflectsResources
{
    /**
     * The resource inflector.
     *
     * @author  Andrea Marco Sartori
     * @var     Cerbero\ApiClient\Inflectors\ResourceInflectorInterface
     */
    protected $inflector;

    /**
     * Set the resource inflector.
     *
     * @author    Andrea Marco Sartori
     * @param    Cerbero\ApiClient\Inflectors\ResourceInflectorInterface    $inflector
     * @return    $this
     */
    public function setInflector(ResourceInflectorInterface $inflector = null)
    {
        $this->inflector = $inflector ?: $this->defaultInflector();

        return $this;
    }

    /**
     * Retrieve the default inflector.
     *
     * @author    Andrea Marco Sartori
     * @return    Cerbero\ApiClient\Inflectors\ResourceInflectorInterface
     */
    protected function defaultInflector()
    {
        return new Psr4ResourceInflector;
    }

    /**
     * Retrieve the resource inflector.
     *
     * @return    Cerbero\ApiClient\Inflectors\ResourceInflectorInterface
     */
    public function inflector()
    {
        return $this->inflector;
    }

    /**
     * Retrieve the resource to call by inflecting the given name.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $name
     * @param    array    $arguments
     * @return    Cerbero\ApiClient\Resources\ResourceInterface
     */
    protected function inflectResource($name, array $arguments)
    {
        $resource = $this->inflectWithVersionIfAvailable($name);

        if (class_exists($resource)) {
            return new $resource($arguments);
        }

        throw new BadMethodCallException("The resource [$resource] does not exist.");
    }

    /**
     * Retrieve the inflected resource with namespace if available.
     *
     * @param    string    $name
     * @return    string
     */
    private function inflectWithVersionIfAvailable($name)
    {
        $inflection = $this->inflector()->baseNamespace(get_called_class());

        if (method_exists($this, 'version')) {
            $inflection->version($this->version());
        }

        return $inflection->inflect($name);
    }
}
