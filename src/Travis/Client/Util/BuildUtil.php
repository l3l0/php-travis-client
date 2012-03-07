<?php

/*
 * This is part of php travis client
 *
 * (c) Leszek Prabucki <leszek.prabucki@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Travis\Client\Util;

use Doctrine\Common\Util\Inflector;

class BuildUtil
{
    /**
     * @param Object $object
     * @param array $objectDataArray
     */
    public static function fillFromArray($object, $objectDataArray)
    {
        foreach ($objectDataArray as $key => $value) {
            $method = 'set' . Inflector::classify($key);
            if (method_exists($object, $method)) {
                $object->$method($value);
            }
        }
    }

    /**
     * @param Object $object
     * @param array $valuesToCompare
     */
    public static function compareValues($object, $valuesToCompare)
    {
        foreach ($valuesToCompare as $key => $value) {
            $method = 'get' . Inflector::classify($key);
            if (method_exists($object, $method)) {
                if ($value != $object->$method()) {
                    return false;
                }
            }
        }

        return (bool) $valuesToCompare;
    }
}
