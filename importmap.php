<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'admin' => [
        'path' => './assets/admin.js',
        'entrypoint' => true,
    ],
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    'login' => [
        'path' => './assets/login.js',
        'entrypoint' => true,
    ],
    'boutique' => [
        'path' => './assets/boutique.js',
        'entrypoint' => true,
    ],
    'produit' => [
        'path' => './assets/produit.js',
        'entrypoint' => true,
    ],
    'commande' => [
        'path' => './assets/commande.js',
        'entrypoint' => true,
    ],
    'register' => [
        'path' => './assets/register.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
    'tom-select' => [
        'version' => '2.3.1',
    ],
    'react' => [
        'version' => '18.2.0',
    ],
    'react-dom' => [
        'version' => '18.2.0',
    ],
    'scheduler' => [
        'version' => '0.23.0',
    ],
    '@symfony/ux-react' => [
        'path' => './vendor/symfony/ux-react/assets/dist/loader.js',
        'entrypoint' => true,
    ],
    'tom-select/dist/css/tom-select.default.css' => [
        'version' => '2.3.1',
        'type' => 'css',
    ],
];
