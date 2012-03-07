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
use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;

abstract class Collection extends ArrayCollection
{
    public function __construct($objects = array())
    {
        $this->fromArray($objects);
    }

    /**
     * Fill in collection from array
     *
     * @param array $objectData
     */
    public function fromArray($objects)
    {
        $this->clear();
        foreach ($objects as $objectData) {
            $this->add($objectData);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add($objectData)
    {
        return parent::add($this->convertArrayToObject($objectData));
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $objectData)
    {
        parent::set($key, $this->convertArrayToObject($objectData));
    }

    public function findOneBy(array $criteria) {
        return $this->findBy($criteria)->first();
    }

    public function findBy(array $criteria)
    {
        return $this->filter(function ($object) use ($criteria) {
            return BuildUtil::compareValues($object, $criteria);
        });
    }

    /**
     * Converts array to build or throw exception
     *
     * Converts array to build or throw exception when build argument have incompatibile type
     *
     * @param mixed $objectData
     * @throws \InvalidArgumentException
     * @return Build
     */
    protected function convertArrayToObject($objectData)
    {
        $objectName = $this->getCollectedObjectName();

        if (is_array($objectData)) {
            $object = new $objectName();
            $object->fromArray($objectData);
            $objectData = $object;
        }

        if (!($objectData instanceof $objectName)) {
            throw new InvalidArgumentException(sprintf('%s collection can handle %s objects only', $objectName, $objectName));
        }

        return $objectData;
    }

    /**
     * @return string
     */
    abstract protected function getCollectedObjectName();
}
