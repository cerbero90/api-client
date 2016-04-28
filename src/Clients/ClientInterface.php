<?php

namespace Cerbero\FluentApi\Clients;

/**
 * Interface for HTTP clients.
 *
 * @author    Andrea Marco Sartori
 */
interface ClientInterface
{
    /**
     * Process the HTTP request synchronously.
     *
     * @author    Andrea Marco Sartori
     * @param    string    $verb
     * @param    string    $endpoint
     * @param    array    $options
     * @return    mixed
     */
    public function call($verb, $endpoint, array $options = []);
}
