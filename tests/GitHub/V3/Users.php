<?php

namespace Cerbero\FluentApi\GitHub\V3;

use Cerbero\FluentApi\AbstractResource;

/**
 * GitHub v3 users endpoint.
 *
 */
class Users extends AbstractResource
{
    /**
     * The resource HTTP verb.
     *
     * @var string|null
     */
    protected $verb = 'GET';

    /**
     * The user's nickname.
     *
     * @var string|null
     */
    protected $user;

    /**
     * Set the dependencies.
     *
     * @param    string|null    $user
     * @return    void
     */
    public function __construct($user = null)
    {
        $this->user = $user;
    }

    /**
     * Retrieve the resource endpoint.
     *
     * @return    string
     */
    public function getEndpoint()
    {
        return $this->user ? "users/{$this->user}" : 'users';
    }
}
