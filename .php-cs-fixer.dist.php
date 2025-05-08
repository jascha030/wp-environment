<?php

declare(strict_types=1);

use Jascha030\PhpCsFixer\Config;
use PhpCsFixer\Finder;

require_once __DIR__ . '/tools/php-cs-fixer/vendor/autoload.php';

/**
 * Create a .cache dir if not already present.
 */
$cacheDirectory = __DIR__ . '/.var/cache';
$cacheFile      = "{$cacheDirectory}/.php-cs-fixer.cache";

if (! file_exists($cacheDirectory) && ! mkdir($cacheDirectory, 0o700, true) && ! is_dir($cacheDirectory)) {
    throw new RuntimeException(sprintf('Directory "%s" was not created', $cacheDirectory));
}

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude([
        'tests/Fixtures',
        'vendor',
    ])
    ->ignoreVCSIgnored(true)
    ->ignoreDotFiles(false);

return (new Config(
    Config::PHP_82,
    null
))
    ->setFinder($finder)
    ->setCacheFile($cacheFile);
