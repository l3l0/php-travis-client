<?php

/*
 * This is part of php travis client
 *
 * (c) Leszek Prabucki <leszek.prabucki@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Travis\Test\Client\Entity;

use Travis\Client\Entity\Build,
    Travis\Client\Entity\BuildCollection;

class BuildCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldAddBuildToCollection()
    {
        $build = new Build();
        $build->setId(666);

        $buildCollection = new BuildCollection();
        $buildCollection->add($build);

        $this->assertCount(1, $buildCollection);
        $this->assertEquals(666, $buildCollection[0]->getId());
    }

    /**
     * @test
     */
    public function shouldAddArrayToCollectionAsBuild()
    {
        $buildArray = array('id' => 777);

        $buildCollection = new BuildCollection();
        $buildCollection->add($buildArray);

        $this->assertCount(1, $buildCollection);
        $this->assertEquals(777, $buildCollection[0]->getId());
    }

    /**
     * @test
     */
    public function shouldSetArrayToCollectionAsBuild()
    {
        $buildArray = array('id' => 777);

        $buildCollection = new BuildCollection();
        $buildCollection->set(2, $buildArray);

        $this->assertCount(1, $buildCollection);
        $this->assertEquals(777, $buildCollection[2]->getId());
    }

    /**
     * @test
     */
    public function shouldCreateCollectionFromArrayOfValuesOrBuild()
    {
        $build = new Build();
        $build->setId(888);

        $constructorArray = array(
            array('id' => 777),
            $build
        );

        $buildCollection = new BuildCollection($constructorArray);

        $this->assertCount(2, $buildCollection);
        $this->assertEquals(777, $buildCollection[0]->getId());
        $this->assertEquals(888, $buildCollection[1]->getId());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldNotAddStringTypeToBuildCollection()
    {
        $buildCollection = new BuildCollection();
        $buildCollection->add('test');
    }

    /**
     * @test
     */
    public function shouldContainElement()
    {
        $build = new Build();
        $build->setId(666);

        $buildCollection = new BuildCollection();
        $buildCollection->add($build);

        $this->assertTrue($buildCollection->contains($build));
    }

    /**
     * @test
     */
    public function shouldNotContainElement()
    {
        $build = new Build();
        $build->setId(666);

        $otherBuild = new Build();
        $otherBuild->setId(777);

        $buildCollection = new BuildCollection();
        $buildCollection->add($build);

        $this->assertFalse($buildCollection->contains($otherBuild));
    }

    /**
     * @test
     * @dataProvider authorProvider
     */
    public function shouldFoundElementByAuthorName($author1, $author2)
    {
        $build = new Build();
        $build->setId(888);
        $build->setAuthorName($author1);

        $constructorArray = array(
            array('id' => 777, 'author_name' => $author2),
            $build
        );

        $buildCollection = new BuildCollection($constructorArray);
        $foundBuildCollection  = $buildCollection->findBy(array('author_name' => $author2));
        $build = $buildCollection->findOneBy(array('author_name' => $author2));

        $this->assertCount(1, $foundBuildCollection);
        $this->assertEquals(777, $foundBuildCollection->first()->getId());
        $this->assertEquals(777, $build->getId());
    }

    /**
     * @test
     */
    public function shouldFoundElementByFinishedAt()
    {
        $build = new Build();
        $build->setId(888);
        $build->setFinishedAt('2011-02-22 16:12:11');

        $constructorArray = array(
            array('id' => 777, 'finished_at' => '2010-02-15 12:33:01'),
            $build
        );

        $buildCollection = new BuildCollection($constructorArray);
        $foundBuildCollection  = $buildCollection->findBy(array('finished_at' => \date_create('2010-02-15 12:33:01')));
        $build = $buildCollection->findOneBy(array('finished_at' => \date_create('2010-02-15 12:33:01')));

        $this->assertCount(1, $foundBuildCollection);
        $this->assertEquals(777, $foundBuildCollection->first()->getId());
        $this->assertEquals(777, $build->getId());
    }

    /**
     * @test
     */
    public function shouldFoundElementByManyElements()
    {
        $constructorArray = array(
            array('id' => 777, 'number' => '21', 'author_name' => 'l3l0'),
            array('id' => 888, 'number' => '21', 'author_name' => 'Leszek'),
        );

        $buildCollection = new BuildCollection($constructorArray);
        $foundBuildCollection  = $buildCollection->findBy(array('number' => '21', 'author_name' => 'l3l0'));

        $this->assertCount(1, $foundBuildCollection);
        $this->assertEquals(777, $foundBuildCollection->first()->getId());
    }

    /**
     * @return array
     */
    public static function authorProvider()
    {
        return array(
            array('Leszek Prabucki', 'l3l0'),
            array('Leszek', 'John'),
        );
    }
}
