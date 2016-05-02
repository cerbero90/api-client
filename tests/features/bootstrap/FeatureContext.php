<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Cerbero\FluentApi\GitHub;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * The API implementation.
     *
     * @var Cerbero\FluentApi\AbstractApi
     */
    protected $api;

    /**
     * The HTTP client response.
     *
     * @var mixed
     */
    protected $response;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I have an implementation of GitHub APIs :version
     */
    public function iHaveAnImplementationOfGithubApis($version)
    {
        $this->api = new GitHub($version);
    }

    /**
     * @When I call the endpoint to show the user :user followers
     */
    public function iCallTheEndpointToShowTheUserFollowers($user)
    {
        $this->response = $this->api->users($user)->followers()->call();
    }

    /**
     * @Then I should see a correct response
     */
    public function iShouldSeeACorrectResponse()
    {
        if ($this->response->getHeader('Status') != ['200 OK']) {
            throw new Exception('Failed asserting that the status is 200.');
        }

        if ($this->response->getHeader('Server') != ['GitHub.com']) {
            throw new Exception('Failed asserting that the called server is GitHub.');
        }
    }

    /**
     * @When I call the endpoint to show the user :user gists
     */
    public function iCallTheEndpointToShowTheUserGists($user)
    {
        $this->response = $this->api->users($user)->gists()->call();
    }

    /**
     * @When I asynchronously call the endpoint to show the user :user gists
     */
    public function iAsynchronouslyCallTheEndpointToShowTheUserGists($user)
    {
        $this->response = $this->api->users($user)->gists()->then(function () {});
    }

    /**
     * @Then I should see a promise as a response
     */
    public function iShouldSeeAPromiseAsAResponse()
    {
        if (! $this->response instanceof PromiseInterface) {
            throw new Exception('Failed asserting that the response is a promise.');
        }
    }

    /**
     * @When I call the endpoint to show the user :user gists as a JSON
     */
    public function iCallTheEndpointToShowTheUserGistsAsAJson($user)
    {
        $this->response = $this->api->users($user)->gists()->toJson();
    }

    /**
     * @Then I should see a correct JSON response
     */
    public function iShouldSeeACorrectJsonResponse()
    {
        foreach ($this->response as $item) {
            if (! $item instanceof StdClass) {
                throw new Exception('Failed asserting that the response has been decoded to JSON.');
            }
        }
    }

    /**
     * @When I call the endpoint to show the user :user gists as an array
     */
    public function iCallTheEndpointToShowTheUserGistsAsAnArray($user)
    {
        $this->response = $this->api->users($user)->gists()->toArray();
    }

    /**
     * @Then I should see a correct array response
     */
    public function iShouldSeeACorrectArrayResponse()
    {
        foreach ($this->response as $item) {
            if (! is_array($item)) {
                throw new Exception('Failed asserting that the response has been decoded to an array.');
            }
        }
    }
}
