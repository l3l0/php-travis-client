<?php

/*
 * This is part of php travis client
 *
 * (c) Leszek Prabucki <leszek.prabucki@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Travis;

use Travis\Client\Entity\BuildCollection;
use Travis\Client\Entity\Repository;

use Buzz\Browser;

class Client
{
    /**
     * @var string
     */
    protected $apiUrl = 'https://api.travis-ci.org';

    /**
     * @var \Buzz\Browser
     */
    private $browser;

    /**
     * @param \Buzz\Browser $browser
     *
     * @return self
     */
    public function __construct(Browser $browser = null)
    {
        if (null === $browser) {
            $browser = new Browser();
        }
        $this->setBrowser($browser);
    }

    public function fetchRepository($slug)
    {
        $repositoryUrl = sprintf('%s/%s.json', $this->apiUrl, $slug);
        $buildsUrl = sprintf('%s/%s/builds.json', $this->apiUrl, $slug);

        $repository = new Repository();
        $repositoryArray = json_decode($this->browser->get($repositoryUrl)->getContent(), true);
        if (!$repositoryArray) {
            throw new \UnexpectedValueException(sprintf('Response is empty for url %s', $repositoryUrl));
        }
        $repository->fromArray($repositoryArray);

        $buildCollection = new BuildCollection(json_decode($this->browser->get($buildsUrl)->getContent(), true));
        $repository->setBuilds($buildCollection);

        return $repository;
    }

    public function restartBuild($build, $token) {
        $restartUrl = sprintf('%s/builds/%s/restart.json', $this->apiUrl, $build->getId());
        $headers = array(
            'Authorization' => 'token ' . $token
        );

        $restartArray = json_decode($this->browser->post($restartUrl, $headers, $content)->getContent(), true);
        if (!$restartArray) {
            throw new \UnexpectedValueException(sprintf('Response is empty for url %s', $restartUrl));
        }

        return $restartArray;
    }

    /**
     * @param \Buzz\Browser
     *
     * @return self
     */
    public function setBrowser(Browser $browser)
    {
        $this->browser = $browser;
        return $this;
    }
}
