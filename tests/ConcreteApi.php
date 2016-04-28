<?php

namespace Cerbero\FluentApi;

/**
 * Dummy class for testing AbstractApi.
 *
 * @author    Andrea Marco Sartori
 */
class ConcreteApi extends AbstractApi
{
    /**
     * Retrieve the base URL.
     *
     * @author    Andrea Marco Sartori
     * @return    string
     */
    public function getUrl()
    {
        return 'http://test.com/v1/';
    }
}
