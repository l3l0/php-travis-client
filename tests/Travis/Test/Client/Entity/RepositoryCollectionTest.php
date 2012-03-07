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

use Travis\Client\Entity\Repository,
    Travis\Client\Entity\RepositoryCollection;

class RepositoryCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldAddRepositoryToCollection()
    {
        $repository = new Repository();
        $repository->setId(666);

        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection->add($repository);

        $this->assertCount(1, $repositoryCollection);
        $this->assertEquals(666, $repositoryCollection[0]->getId());
    }

    /**
     * @test
     */
    public function shouldAddArrayToCollectionAsRepository()
    {
        $repositoryArray = array('id' => 777);

        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection->add($repositoryArray);

        $this->assertCount(1, $repositoryCollection);
        $this->assertEquals(777, $repositoryCollection[0]->getId());
    }

    /**
     * @test
     */
    public function shouldSetArrayToCollectionAsRepository()
    {
        $repositoryArray = array('id' => 777);

        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection->set(2, $repositoryArray);

        $this->assertCount(1, $repositoryCollection);
        $this->assertEquals(777, $repositoryCollection[2]->getId());
    }

    /**
     * @test
     */
    public function shouldCreateCollectionFromArrayOfValuesOrRepository()
    {
        $repository = new Repository();
        $repository->setId(888);

        $constructorArray = array(
            array('id' => 777),
            $repository
        );

        $repositoryCollection = new RepositoryCollection($constructorArray);

        $this->assertCount(2, $repositoryCollection);
        $this->assertEquals(777, $repositoryCollection[0]->getId());
        $this->assertEquals(888, $repositoryCollection[1]->getId());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldNotAddStringTypeToRepositoryCollection()
    {
        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection->add('test');
    }

    /**
     * @test
     */
    public function shouldContainElement()
    {
        $repository = new Repository();
        $repository->setId(666);

        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection->add($repository);

        $this->assertTrue($repositoryCollection->contains($repository));
    }

    /**
     * @test
     */
    public function shouldNotContainElement()
    {
        $repository = new Repository();
        $repository->setId(666);

        $otherRepository = new Repository();
        $otherRepository->setId(777);

        $repositoryCollection = new RepositoryCollection();
        $repositoryCollection->add($repository);

        $this->assertFalse($repositoryCollection->contains($otherRepository));
    }

    /**
     * @test
     */
    public function shouldFoundElementByStatus()
    {
        $constructorArray = array(
            array('id' => 777, 'status' => 'stable'),
            array('id' => 888, 'status' => 'other')
        );

        $repositoryCollection = new RepositoryCollection($constructorArray);
        $foundRepositoryCollection  = $repositoryCollection->findBy(array('status' => 'stable'));

        $this->assertCount(1, $foundRepositoryCollection);
        $this->assertEquals(777, $foundRepositoryCollection->first()->getId());
    }
}
