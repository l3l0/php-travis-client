<?php

/*
 * This is part of php travis client
 *
 * (c) Leszek Prabucki <leszek.prabucki@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Travis\Client\Entity;

use Travis\Client\Util\BuildUtil;

class Repository
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $lastBuildId;

    /**
     * @var int
     */
    protected $lastBuildDuration;

    /**
     * @var \DateTime
     */
    protected $lastBuildStartedAt;

    /**
     * @var int
     */
    protected $lastBuildStatus;

    /**
     * @var int
     */
    protected $lastBuildNumber;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var \DateTime
     */
    protected $lastBuildFinishedAt;

    /**
     * @var BuildCollection
     */
    protected $builds;

    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @param array
     */
    public function fromArray($repositoryData)
    {
        BuildUtil::fillFromArray($this, $repositoryData);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @param string
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getLastBuildId()
    {
        return $this->lastBuildId;
    }

    /**
     * @param int
     */
    public function setLastBuildId($buildId)
    {
        $this->lastBuildId = $buildId;
    }

    /**
     * @return int
     */
    public function getLastBuildDuration()
    {
        return $this->lastBuildDuration;
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param string
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @param int
     */
    public function setLastBuildDuration($duration)
    {
        $this->lastBuildDuration = $duration;
    }

    /**
     * @return \DateTime
     */
    public function getLastBuildStartedAt()
    {
        return $this->lastBuildStartedAt;
    }

    /**
     * @param string
     */
    public function setLastBuildStartedAt($date)
    {
        $this->lastBuildStartedAt = date_create($date);
    }

    /**
     * @return int
     */
    public function getLastBuildStatus()
    {
        return $this->lastBuildStatus;
    }

    /**
     * @param int
     */
    public function setLastBuildStatus($status)
    {
        $this->lastBuildStatus = $status;
    }

    /**
     * @return int
     */
    public function getLastBuildNumber()
    {
        return $this->lastBuildNumber;
    }

    /**
     * @param int
     */
    public function setLastBuildNumber($buildNumber)
    {
        $this->lastBuildNumber = $buildNumber;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getLastBuildFinishedAt()
    {
        return $this->lastBuildFinishedAt;
    }

    /**
     * @param string
     */
    public function setLastBuildFinishedAt($date)
    {
        $this->lastBuildFinishedAt = date_create($date);
    }

    /**
     * @return BuildCollection
     */
    public function getBuilds()
    {
        return $this->builds;
    }

    /**
     * @param mixed $builds - array of BuildCollection
     */
    public function setBuilds($builds)
    {
        if ($builds instanceof BuildCollection) {
            $this->builds = $builds;

            return;
        }

        $this->builds = new BuildCollection($builds);
    }

    /**
     * @return Build
     */
    public function getLastBuild()
    {
        return $this->getBuilds()->findOneBy(array('id' => $this->getLastBuildId()));
    }
}
