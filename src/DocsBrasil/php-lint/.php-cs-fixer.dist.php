<?php

require_once "vendor/autoload.php";

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR1' => true,
    '@PSR2' => true,
    '@PSR12' => true,
    'array_syntax' => [
        'syntax' => 'short',
    ],
    'no_unused_imports' => true,
    'blank_line_after_opening_tag' => true,
];

$rootDir = dirname(__DIR__);

$finder = Finder::create()
    ->in([$rootDir])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new Config();
$config = $config
    ->setCacheFile(__DIR__ . "/.php-cs-fixer.cache")
    ->setFinder($finder)
    ->setRules($rules)
    ->setUsingCache(true)
    ->setLineEnding("\n");

return $config;
