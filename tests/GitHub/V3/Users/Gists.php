<?php

namespace Cerbero\FluentApi\GitHub\V3\Users;

use Cerbero\FluentApi\AbstractResource;

/**
 * GitHub v3 user's gists endpoint.
 *
 */
class Gists extends AbstractResource
{
    /**
     * The resource HTTP verb.
     *
     * @var string|null
     */
    protected $verb = 'GET';

    /**
     * Retrieve the resource endpoint.
     *
     * @return    string
     */
    public function getEndpoint()
    {
        return 'gists';
    }
}
