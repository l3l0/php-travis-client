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

class Build
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var int
     */
    protected $duration;

    /**
     * @var \DataTime
     */
    protected $commitedAt;

    /**
     * @var \DateTime
     */
    protected $startedAt;

    /**
     * @var \DateTime
     */
    protected $finishedAt;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $authorName;

    /**
     * @var string
     */
    protected $log;

    /**
     * @var string
     */
    protected $branch;

    /**
     * @var int
     */
    protected $parentId;

    /**
     * @var int
     */
    protected $repositoryId;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $compareUrl;

    public function fromArray($buildData)
    {
        BuildUtil::fillFromArray($this, $buildData);
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
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return \DateTime
     */
    public function getCommittedAt()
    {
        return $this->committedAt;
    }

    /**
     * @return string
     */
    public function setCommittedAt($date)
    {
        $this->committedAt = date_create($date);
    }

    /**
     * @return \DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * @return string
     */
    public function setStartedAt($date)
    {
        $this->startedAt = date_create($date);
    }

    /**
     * @return \DateTime
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * @return string
     */
    public function setFinishedAt($date)
    {
        $this->finishedAt = date_create($date);
    }

    /**
     * @return string
     */
    public function getCommit()
    {
        return $this->commit;
    }

    /**
     * @param string
     */
    public function setCommit($commit)
    {
        $this->commit = $commit;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param string
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * @param string
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;
    }

    /**
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param string
     */
    public function setLog($log)
    {
        $this->log = $log;
    }

    /**
     * @param int
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int
     */
    public function setRepositoryId($repositoryId)
    {
        $this->repositoryId = $repositoryId;
    }

    /**
     * @return int
     */
    public function getRepositoryId()
    {
        return $this->repositoryId;
    }

    /**
     * @param string
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string
     */
    public function setCompareUrl($compareUrl)
    {
        $this->compareUrl = $compareUrl;
    }

    /**
     * @return string
     */
    public function getCompareUrl()
    {
        return $this->compareUrl;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
}
