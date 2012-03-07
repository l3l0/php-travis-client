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

class BuildCollection extends Collection
{
    protected function getCollectedObjectName()
    {
        return 'Travis\Client\Entity\Build';
    }
}
