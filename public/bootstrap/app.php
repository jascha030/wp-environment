<?php

declare(strict_types=1);

namespace Jascha030\Xerox;

use Dotenv\Dotenv;
use Jascha030\Xerox\Config\WPConfigStore;
use RuntimeException;

use function define;
use function defined;
use function dirname;
use function sprintf;

$public = dirname(__DIR__);

/**
 * Load composer autoloader.
 */
(static function () use ($public): void {
    if (! file_exists($autoloader = $public . '/vendor/autoload.php')) {
        throw new RuntimeException(sprintf('Couldn\'t find "autoload.php" file in path: %s.', $autoloader));
    }

    require_once $autoloader;
})();

/**
 * Load env.
 */
$env = Dotenv::createImmutable($public, '.env');
$env->ifPresent(WPConfigStore::BOOLEAN_VALUES)
    ->isBoolean();

/**
 * Create WPConfigStore, converts dotEnv variables to constants.
 */
WPConfigStore::create($env->load());

/**
 * Add custom content root.
 */
WPConfigStore::add('WP_CONTENT_DIR', $public . '/app');

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

if (WPConfigStore::has('TABLE_PREFIX')) {
    $table_prefix = WPConfigStore::get('TABLE_PREFIX');
}

/**
 * Initializes WP-required constants.
 *
 * Any environment variable that need further customization should be edited before this line.
 */
WPConfigStore::save();

if (! defined('ABSPATH')) {
    define('ABSPATH', dirname(__DIR__) . '/wordpress/');
}
