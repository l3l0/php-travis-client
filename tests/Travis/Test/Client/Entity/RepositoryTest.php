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

use Travis\Client\Entity\Repository;
use Travis\Client\Entity\BuildCollection;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldLoadDataFromArray()
    {
        $repository = new Repository();
        $repository->fromArray(array(
            'slug' => 'travis-ci/travis-ci',
            'description' => 'travis ci project',
            'last_build_id' => 61817,
            'last_build_started_at' => '2011-08-01T14:50:07Z',
            'last_build_status' => 0,
            'last_build_number' => '721',
            'last_build_duration' => '11',
            'id' => 59,
            'status' => 'stable',
            'public_key' => 'MIGJAoGBALEXzQFoNltkT4PBHJiC+UXCcIfdJNvObnT2IspuDOAISNnUVRBaAAs=',
            'last_build_finished_at' => '2011-08-01T14:56:44Z',
            'builds' => array(
                array('id' => 111)
            )
        ));

        $this->assertEquals(59, $repository->getId());
        $this->assertEquals('travis-ci/travis-ci', $repository->getSlug());
        $this->assertEquals(61817, $repository->getLastBuildId());
        $this->assertEquals('2011-08-01 14:50:07', $repository->getLastBuildStartedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals(0, $repository->getLastBuildStatus());
        $this->assertEquals('721', $repository->getLastBuildNumber());
        $this->assertEquals('11', $repository->getLastBuildDuration());
        $this->assertEquals('stable', $repository->getStatus());
        $this->assertEquals('2011-08-01 14:56:44', $repository->getLastBuildFinishedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals(111, $repository->getBuilds()->first()->getId());
        $this->assertEquals('travis ci project', $repository->getDescription());
        $this->assertEquals('MIGJAoGBALEXzQFoNltkT4PBHJiC+UXCcIfdJNvObnT2IspuDOAISNnUVRBaAAs=', $repository->getPublicKey());
    }

    /**
     * @test
     */
    public function shouldSetId()
    {
        $repository = new Repository();
        $repository->setId(123);

        $this->assertEquals(123, $repository->getId());
    }

    /**
     * @test
     */
    public function shouldSetSlug()
    {
        $repository = new Repository();
        $repository->setSlug('travis-ci/travis-ci');

        $this->assertEquals('travis-ci/travis-ci', $repository->getSlug());
    }

    /**
     * @test
     */
    public function shouldSetLastBuildId()
    {
        $repository = new Repository();
        $repository->setLastBuildId(61817);

        $this->assertEquals(61817, $repository->getLastBuildId());
    }

    /**
     * @test
     */
    public function shouldSetLastBuildStartedAtDate()
    {
        $repository = new Repository();
        $repository->setLastBuildStartedAt('2011-08-01T14:50:07Z');

        $this->assertEquals('2011-08-01 14:50:07', $repository->getLastBuildStartedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     */
    public function shouldSetLastBuildStatus()
    {
        $repository = new Repository();
        $repository->setLastBuildStatus(1);

        $this->assertEquals(1, $repository->getLastBuildStatus());
    }

    /**
     * @test
     */
    public function shouldSetLastBuildNumber()
    {
        $repository = new Repository();
        $repository->setLastBuildNumber(721);

        $this->assertEquals(721, $repository->getLastBuildNumber());
    }

    /**
     * @test
     */
    public function shouldSetStatus()
    {
        $repository = new Repository();
        $repository->setStatus('stable');

        $this->assertEquals('stable', $repository->getStatus());
    }

    /**
     * @test
     */
    public function shouldSetLastBuildFinishedAt()
    {
        $repository = new Repository();
        $repository->setLastBuildFinishedAt('2011-08-01T14:56:44Z');

        $this->assertEquals('2011-08-01 14:56:44', $repository->getLastBuildFinishedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     */
    public function shouldSetArrayBuilds()
    {
        $repository = new Repository();
        $repository->setBuilds(array(array('id' => 222)));

        $this->assertEquals(222, $repository->getBuilds()->first()->getId());
    }

    /**
     * @test
     */
    public function shouldSetCollectionBuilds()
    {
        $repository = new Repository();

        $builds = new BuildCollection();
        $builds->fromArray(array(array('id' => 222)));
        $repository->setBuilds($builds);

        $this->assertEquals(222, $repository->getBuilds()->first()->getId());
    }

    /**
     * @test
     */
    public function shouldReturnsLastBuild()
    {
        $repository = new Repository();
        $repository->setLastBuildId(222);
        $repository->setBuilds(array(
            array('id' => 111),
            array('id' => 222)
        ));

        $lastBuild = $repository->getLastBuild();

        $this->assertEquals(222, $lastBuild->getId());
    }

    /**
     * @test
     */
    public function shouldNotReturnsLastBuild()
    {
        $repository = new Repository();
        $repository->setLastBuildId(333);
        $repository->setBuilds(array(
            array('id' => 111),
            array('id' => 222)
        ));

        $lastBuild = $repository->getLastBuild();

        $this->assertFalse($lastBuild);
    }
}
