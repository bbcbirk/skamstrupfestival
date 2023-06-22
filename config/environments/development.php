<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;
use function Env\env;

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', true);
Config::define('WP_DEBUG_LOG', env('WP_DEBUG_LOG') ?? true);
Config::define('WP_DISABLE_FATAL_ERROR_HANDLER', true);
Config::define('SCRIPT_DEBUG', true);
Config::define('DISALLOW_INDEXING', true);

ini_set('display_errors', '1');

// Enable plugin and theme updates and installation from the admin
Config::define('DISALLOW_FILE_MODS', false);

// Custom Overrides
Config::define('DB_NAME', 'blauner_dk_db_skam');
Config::define('DB_USER', 'root');
Config::define('DB_PASSWORD', 'admin');
Config::define('DB_HOST', 'db' ?: 'localhost');
$table_prefix = 'skam_' ?: 'wp_';
Config::define('WP_HOME', 'http://localhost');
Config::define('WP_SITEURL', Config::get('WP_HOME') . '/wp');
