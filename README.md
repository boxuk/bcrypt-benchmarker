PHP Bcrypt Benchmarker
==========================

# This repository is unmaintained

A tool that benchmarks how fast a server can generate bcrypt hashes.

Installation
------------

### Locally

Install composer vendors

    $ php ./bin/composer.phar install

Usage
-----

The `benchmark` command provides timings to generate hashes for different costs.

For usage: 

    $ php ./bin/benchmark benchmark --help

Each cost is only benchmarked once, so it is suggested you run the tool multiple times to attain your own average.
