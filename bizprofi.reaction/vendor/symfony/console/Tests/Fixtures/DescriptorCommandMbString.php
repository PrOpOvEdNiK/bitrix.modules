<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Fixtures;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DescriptorCommandMbString extends Command
{
    protected function configure()
    {
        $this
            ->setName('descriptor:åèae')
            ->setDescription('command åèae description')
            ->setHelp('command åèae help')
            ->addUsage('-o|--option_name <argument_name>')
            ->addUsage('<argument_name>')
            ->addArgument('argument_åèae', InputArgument::REQUIRED)
            ->addOption('option_åèae', 'o', InputOption::VALUE_NONE)
        ;
    }
}
