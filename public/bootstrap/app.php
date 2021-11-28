<?php

use Dotenv\Dotenv;
use Jascha030\Xerox\Config\WPConfigStore;

/**
 * Public path
 */
$public = dirname(__DIR__);

/**
 * Autoloader path
 */
$autoloader = $public . '/vendor/autoload.php';

/**
 * Load Composer autoloader/ throw exception when autoload.php is not found in expected directory.
 * @throws \RuntimeException
 */
if (! file_exists($autoloader)) {
    $errorMsg = sprintf('Couldn\'t find Composer\'s Autoloader file in path: "%s", please make sure you run the %s or %s commands.',
        $autoloader,
        '<pre>composer install --prefer-source</pre>',
        '<pre>composer dump-autoload</pre>');

    throw new \RuntimeException($errorMsg);
}

/**
 * Require autoloader when it does exist.
 */
require_once $autoloader;

/**
 * Create DotEnv.
 */
$env = Dotenv::createImmutable($public, '.env');

//$env->required(WPConfigStore::REQUIRED_VALUES);
$env->ifPresent(WPConfigStore::BOOLEAN_VALUES)
    ->isBoolean();

/**
 * Create WPConfigStore instance, to convert dotEnv variables to constants.
 */
WPConfigStore::create($env->load());

/**
 * Add custom content root
 */
WPConfigStore::add('WP_CONTENT_DIR', $public . '/app');


/**
 * WordPress database table prefix.
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

if (WPConfigStore::has('TABLE_PREFIX')) {
    $table_prefix = WPConfigStore::get('TABLE_PREFIX');
}

/**
 * Initializes WP constants.
 * Any environment variable that need further customization should be edited before this line.
 */
WPConfigStore::save();

if (! defined('ABSPATH')) {
    define('ABSPATH', dirname(__DIR__) . '/wordpress/');
}

require_once ABSPATH . 'wp-settings.php';
