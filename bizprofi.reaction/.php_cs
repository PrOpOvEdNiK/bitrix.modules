<?php

$config = PhpCsFixer\Config::create();

$config->setRules([
    // Use preconfigured set of fixers
    '@Symfony' => true,

    // Disable some rules from @Symfony
    'return_type_declaration' => false,
    'blank_line_before_return' => false,
    'no_unneeded_control_parentheses' => false,
    'no_extra_consecutive_blank_lines' => false,

    // Enable additional fixers not included in @Symfony
    'array_syntax' => ['syntax' => 'short'],
    'no_useless_else' => true,
    'no_useless_return' => true,
    'ordered_imports' => true,
    'phpdoc_order' => true,
]);

$finder = PhpCsFixer\Finder::create()
    ->in(['./']);

$config->setFinder($finder);

return $config;
