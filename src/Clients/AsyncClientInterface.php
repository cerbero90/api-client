<?php

namespace Cerbero\FluentApi\Clients;

use Closure;

/**
 * Interface for clients able to perform asynchronous calls.
 *
 */
interface AsyncClientInterface extends ClientInterface
{
    /**
     * Process the HTTP request asynchronously.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $verb
     * @param    string    $endpoint
     * @param    array    $options
     * @param    Closure    $success
     * @param    Closure|null    $failure
     * @return    mixed
     */
    public function then($verb, $endpoint, array $options = [], Closure $success, Closure $failure = null);
}
