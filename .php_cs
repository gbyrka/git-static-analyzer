<?php

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->files()
            ->in(__DIR__ . '/src')
            ->in(__DIR__ . '/tests')
            ->append(array(
                __DIR__ . 'index.php',
                __FILE__,
            ))
    );
