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

use Travis\Client\Entity\Build;

class BuildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldLoadDataFromArray()
    {
        $build = new Build();
        $build->fromArray(array(
            'id' => 63812,
            'number' => '731.1',
            'committed_at' => '2011-08-02T23:16:51Z',
            'commit' => '9b5786d7164ef5a960e0d7b87764b9cbc0fb95e3',
            'finished_at' => '2011-08-02T23:24:06Z',
            'config' => array(
                'script' => 'bundle exec rake test:ci',
                '.configured' => true,
                'bundler_args' => "--without development",
                'notifications' => array(
                    'irc' => 'irc.freenode.org#travis'
                ),
                'rvm' => '1.8.7'
            ),
            'author_name' => 'Josh Kalderimis',
            'log' => 'Using worker: main.railshoster:worker-3',
            'branch' => 'master',
            'id' => 63812,
            'parent_id' => 63811,
            'started_at' => '2011-08-02T23:20:13Z',
            'author_email' => 'josh.kalderimis@gmail.com',
            'status' => 0,
            'repository_id' => 59,
            'message' => 'Merge branch \'staging\'',
            'compare_url' => 'https://github.com/travis-ci/travis-ci/compare/ca5b190...9b5786d'
        ));

        $expectedConfig = array(
            'script' => 'bundle exec rake test:ci',
            '.configured' => true,
            'bundler_args' => "--without development",
            'notifications' => array(
                'irc' => 'irc.freenode.org#travis'
            ),
            'rvm' => '1.8.7'
        );

        $this->assertEquals(63812, $build->getId());
        $this->assertEquals('731.1', $build->getNumber());
        $this->assertEquals('2011-08-02 23:16:51', $build->getCommittedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('9b5786d7164ef5a960e0d7b87764b9cbc0fb95e3', $build->getCommit());
        $this->assertEquals('2011-08-02 23:20:13', $build->getStartedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('2011-08-02 23:24:06', $build->getFinishedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals($expectedConfig, $build->getConfig());
        $this->assertEquals('Josh Kalderimis', $build->getAuthorName());
        $this->assertEquals('Using worker: main.railshoster:worker-3', $build->getLog());
        $this->assertEquals('master', $build->getBranch());
        $this->assertEquals(63811, $build->getParentId());
        $this->assertEquals(59, $build->getRepositoryId());
        $this->assertEquals('Merge branch \'staging\'', $build->getMessage());
        $this->assertEquals('https://github.com/travis-ci/travis-ci/compare/ca5b190...9b5786d', $build->getCompareUrl());
    }
}
