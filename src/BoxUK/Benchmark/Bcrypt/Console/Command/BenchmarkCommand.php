<?php

namespace BoxUK\Benchmark\Bcrypt\Console\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 *
 */
class BenchmarkCommand extends Command
{

    const PASSWORD = 'password';

    protected $secureRandom;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('benchmark')
            ->setDefinition(
                array(
                    new InputOption('cost', '', InputOption::VALUE_OPTIONAL, 'The algorithmic cost that should be used', null),
                )
            )
            ->setDescription('Benchmarks how fast a server can generate bcrypt hashes')
            ->setHelp(
                <<<EOF
The <info>%command.name%</info> command benchmarks how fast a server can
generate bcrypt hashes.

The <comment>--cost</comment> option limits benchmarking to a particular cost

    <info>php %command.full_name% --cost=2</info>

Cost must be in the range of 4-31

If a cost is not provided, all costs will be benchmarked in ascending order.
EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->secureRandom = new SecureRandom();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $costs = range(4, 31);

        if ($cost = $input->getOption('cost')) {
            $cost = (int)$cost;

            if ($cost < 4 || $cost > 31) {
                throw new \InvalidArgumentException('Cost must be in the range of 4-31.');
            }
            $costs = array($cost);
        }

        $stopwatch = new Stopwatch();

        $output->writeln('cost duration');
        $output->writeln('==== ========');
        foreach ($costs as $cost) {
            $stopwatch->start((string)$cost);
            $this->benchmark($cost);
            $event = $stopwatch->stop((string)$cost);
            $output->writeln(sprintf("%02d   %dms", $cost, $event->getDuration()));
        }

    }

    /**
     * @param int $cost
     */
    protected function benchmark($cost)
    {
        $encoder = new BCryptPasswordEncoder($this->secureRandom, $cost);
        $encoder->encodePassword(self::PASSWORD, null);
    }

}