<?php

namespace Jascha030\Xerox;

use Dotenv\Dotenv;
use Jascha030\Xerox\Config\WPConfigStore;
use RuntimeException;

$public = dirname(__DIR__);

(static function () use($public) {
    if (! file_exists($autoloader = $public . '/vendor/autoload.php')) {
        throw new RuntimeException(sprintf('Couldn\'t find "autoload.php" file in path: %s.', $autoloader));
    }

    include_once $autoloader;
})();

/**
 * Create DotEnv.
 */
$env = Dotenv::createImmutable($public, '.env');
$env->ifPresent(WPConfigStore::BOOLEAN_VALUES)
    ->isBoolean();

/**
 * Create WPConfigStore instance, to convert dotEnv variables to constants.
 */
WPConfigStore::create($env->load());

/**
 * Add custom content root.
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

