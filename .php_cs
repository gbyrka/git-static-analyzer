<?php

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->files()
            ->in(__DIR__ . '/src')
            ->in(__DIR__ . '/tests')
            ->append(array(
                __DIR__ . 'analyse.php',
                __FILE__,
            ))
    )
    ->setRules(array(
        'array_syntax' => true,
    ));
