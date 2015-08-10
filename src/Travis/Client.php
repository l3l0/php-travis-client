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
use Travis\Client\Listener\TokenAuthListener;
use Buzz\Browser;
use Buzz\Client\FileGetContents;
use Buzz\Client\Curl;

class Client
{
    /**
     * @var string
     */
    private $apiUrl = 'https://api.travis-ci.org';
    private $apiUrlPrivate = 'https://api.travis-ci.com';

    /**
     * @var \Buzz\Browser
     */
    private $browser;

    /**
     * @param \Buzz\Browser $browser
     *
     * @return self
     */
    public function __construct(Browser $browser = null, $clientInterface = FALSE, $token = FALSE)
    {
        if (null === $browser) {
            $browser = ($clientInterface) ? new Browser(new $clientInterface) : new Browser();
        }
        $this->setBrowser($browser);

        if ($token) {
            $this->browser->addListener(new TokenAuthListener($token));
        }
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

    public function restartBuild($build) {
        $url = sprintf('%s/builds/%s/restart.json', $this->apiUrl, $build->getId());
        $restartArray = json_decode($this->browser->post($url)->getContent(), true);
        if (!$restartArray) {
            throw new \UnexpectedValueException(sprintf('Response is empty for url %s', $url));
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

    public function setApiUrlPrivate()
    {
        $this->apiUrl = $this->apiUrlPrivate;
    }
}
