<?php

/*
 * This is part of php travis client
 *
 * (c) Leszek Prabucki <leszek.prabucki@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Travis\Test;

use Travis\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldFetchRepository()
    {
        $browser = $this->getBrowser();
        $browser->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('http://travis-ci.org/l3l0/OpenSocialBundle.json'))
            ->will($this->returnValue($this->getResponse($this->getRepositoryJson())));
        $browser->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('http://travis-ci.org/l3l0/OpenSocialBundle/builds.json'))
            ->will($this->returnValue($this->getResponse($this->getBuildsJson())));

        $client = new Client();
        $client->setBrowser($browser);

        $repository = $client->fetchRepository('l3l0/OpenSocialBundle');

        $this->assertEquals('Symfony2 osapi implementation', $repository->getDescription());
        $this->assertEquals(5, $repository->getLastBuildNumber());
        $this->assertEquals(28, $repository->getBuilds()->findOneBy(array('id' => 371648))->getDuration());
        $this->assertEquals(70, $repository->getLastBuild()->getDuration());
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     */
    public function shouldThrowException()
    {
        $browser = $this->getBrowser();
        $browser->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('http://travis-ci.org/l3l0/OpenSocialBundle.json'))
            ->will($this->returnValue($this->getResponse('')));

        $client = new Client();
        $client->setBrowser($browser);

        $repository = $client->fetchRepository('l3l0/OpenSocialBundle');
    }

    private function getBrowser()
    {
        return $this->getMock('Buzz\Browser');
    }

    private function getResponse($content)
    {
        $mock = $this->getMock('Buzz\Message\Response');
        $mock->expects($this->any())
            ->method('getContent')
            ->will($this->returnValue($content));

        return $mock;
    }

    private function getRepositoryJson()
    {
        return '{"id":4546,"description":"Symfony2 osapi implementation","last_build_id":383340,"last_build_number":"5","last_build_started_at":"2011-12-07T19:18:42Z","last_build_finished_at":"2011-12-07T19:19:52Z","last_build_status":0,"last_build_language":null,"last_build_duration":70,"last_build_result":0,"slug":"l3l0/OpenSocialBundle","public_key":"-----BEGIN RSA PUBLIC KEY-----\nMIGJAoGBALEXzQFoNltkT4PBHJiC+UXCcIfdJNvObnT2IspuDOAISNnUVRBaAAs5\nRjg9mVmI/EjhzrfUbnABDbUerK60UXruuGAow6yu14ue7Zu4wHwH+e0xWnGWrZti\ndx+QTzQroTr9C7MA9jD37COYJR1Xgq9w5rh7yhsX2IiB9r8y9CYlAgMBAAE=\n-----END RSA PUBLIC KEY-----\n"}';
    }

    private function getBuildsJson()
    {
        return '[{"id":383340,"repository_id":4546,"number":"5","started_at":"2011-12-07T19:18:42Z","finished_at":"2011-12-07T19:19:52Z","duration":70,"result":0,"commit":"b00286f6a6ef0bc452abc520d1948b3799ec3c7d","branch":"master","message":"Fix in readme"},
{"id":379808,"repository_id":4546,"number":"4","started_at":"2011-12-06T18:13:14Z","finished_at":"2011-12-06T18:14:05Z","duration":51,"result":0,"commit":"03b830c5c2a7806994260ae778dff75389c74a39","branch":"master","message":"Added extension for travisci needed for two tests."},
{"id":371817,"repository_id":4546,"number":"3","started_at":"2011-12-04T13:28:43Z","finished_at":"2011-12-04T13:29:13Z","duration":30,"result":0,"commit":"01cc75720c461b7511c70ae0f495495a06962fd1","branch":"master","message":"Added travis-ci build status to readme file"},
{"id":371716,"repository_id":4546,"number":"2","started_at":"2011-12-04T12:24:11Z","finished_at":"2011-12-04T12:24:40Z","duration":29,"result":0,"commit":"7c4aef267331ea89428b1c3b808ff2791fcf6fdf","branch":"master","message":"Try to fix build via remove svn and use wget and tar instead. Travisci did not recognize svn command."},
{"id":371648,"repository_id":4546,"number":"1","started_at":"2011-12-04T11:44:06Z","finished_at":"2011-12-04T11:44:34Z","duration":28,"result":1,"commit":"1186ad4cd6e88d56cfeb0b64f87b4746da2da11a","branch":"master","message":"Integrated project with travis-ci"}]';
    }
}
