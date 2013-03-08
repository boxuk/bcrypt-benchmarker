<?php

namespace BoxUK\Benchmark\Bcrypt\Console;

use BoxUK\Benchmark\Bcrypt\Console\Command\BenchmarkCommand;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * The console application that handles the commands
 */
class Application extends BaseApplication
{

    /**
     * Initializes all the composer commands
     */
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = new BenchmarkCommand();

        return $commands;
    }

}
