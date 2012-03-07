<?php

/*
 * This is part of php travis client
 *
 * (c) Leszek Prabucki <leszek.prabucki@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Travis\Test\Client\EntityBuilder;

use Travis\Client\Util\BuildUtil;
use Travis\Client\Entity\Repository;

class BuildUtilTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldFillRepositoryFromArray()
    {
        $repository = new Repository();

        BuildUtil::fillFromArray($repository, array('id' => 777, 'slug' => 'test'));

        $this->assertEquals('test', $repository->getSlug());
        $this->assertEquals(777, $repository->getId());
    }

    /**
     * @test
     */
    public function shouldCompareValuesWithObject()
    {
        $repository = new Repository();
        $repository->setId(777);
        $repository->setSlug('test');

        $this->assertTrue(BuildUtil::compareValues($repository, array('id' => 777, 'slug' => 'test')));
        $this->assertFalse(BuildUtil::compareValues($repository, array('id' => 888, 'slug' => 'test')));
        $this->assertFalse(BuildUtil::compareValues($repository, array('id' => 777, 'slug' => 'test1')));
        $this->assertFalse(BuildUtil::compareValues($repository, array('id' => 777, 'slug' => 'test', 'status' => 'failed')));
    }
}
