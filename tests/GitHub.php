<?php

namespace Cerbero\FluentApi;

use Cerbero\FluentApi\AbstractApi;

/**
 * The HTTP client for GitHub APIs.
 *
 */
class GitHub extends AbstractApi
{
    /**
     * Retrieve the base URL.
     *
     * @author    Andrea Marco Sartori
     * @return    string
     */
    public function getUrl()
    {
        return 'https://api.github.com';
    }
}
