<?php

require_once "vendor/autoload.php";

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR1' => true,
    '@PSR2' => true,
    '@PSR12' => true,
    'include' => true,
    'no_unused_imports' => true,
    'trim_array_spaces' => true,
    'statement_indentation' => true,
    'no_leading_import_slash' => true,
    'blank_line_after_opening_tag' => true,
    'no_multiple_statements_per_line' => true,
    'no_leading_namespace_whitespace' => true,
    'whitespace_after_comma_in_array' => true,
    'no_unneeded_control_parentheses' => true,
    'object_operator_without_whitespace' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'array_syntax' => [
        'syntax' => 'short',
    ],
    'concat_space' => [
        'spacing' => 'one',
    ],
    'ordered_imports' => [
        'sort_algorithm' => 'length',
    ],
    'class_attributes_separation' => [
        'elements' => [
            'const' => 'none',
            'method' => 'one',
            'property' => 'none',
            'trait_import' => 'none',
        ],
    ],
    'braces_position' => [
        'allow_single_line_anonymous_functions' => false,
        'allow_single_line_empty_anonymous_classes' => false,
        'anonymous_classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
        'anonymous_functions_opening_brace' => 'next_line_unless_newline_at_signature_end',
        'classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
        'functions_opening_brace' => 'next_line_unless_newline_at_signature_end',
    ],
    'no_extra_blank_lines' => ['tokens' => [
        'attribute',
        'break',
        'case',
        'continue',
        'curly_brace_block',
        'default',
        'extra',
        'parenthesis_brace_block',
        'return',
        'square_brace_block',
        'switch',
        'throw',
        'use',
    ]],
    'blank_line_before_statement' => [
        'statements' => [
            'continue',
            'declare',
            'foreach',
            'return',
            'throw',
            'try',
            'for',
            'if',
        ],
    ],
    'binary_operator_spaces' => [
        'default' => 'single_space',
    ],
];

$rootDir = dirname(__DIR__);

$finder = Finder::create()
    ->in([$rootDir])
    ->name('*.php')
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
