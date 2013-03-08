<?php

function includeIfExists($file)
{
    if (file_exists($file)) {
        return include $file;
    }
}

if ((!$loader = includeIfExists(__DIR__ . '/../vendor/autoload.php')) && (!$loader = includeIfExists(
    __DIR__ . '/../../../autoload.php'
))
) {
    echo 'You must set up the project dependencies, run the following commands:' . PHP_EOL .
        'php ./bin/composer.phar install' . PHP_EOL;
    exit(1);
}

return $loader;
