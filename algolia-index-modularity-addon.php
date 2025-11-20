<?php

/**
 * Plugin Name:       Algolia Index Modularity Addon
 * Plugin URI:        https://github.com/helsingborg-stad/algolia-index-modularity-addon
 * Description:       Adds support for modularity indexing to algolia-index plugin.
 * Version: 3.1.3
 * Author:            Sebastian Thulin
 * Author URI:        https://github.com/sebastianthulin
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       algolia-index-modularity-addon
 * Domain Path:       /languages
 */

 // Protect agains direct file access
if (! defined('WPINC')) {
    die;
}

define('ALGOLIAINDEXMODADDON_PATH', plugin_dir_path(__FILE__));
define('ALGOLIAINDEXMODADDON_URL', plugins_url('', __FILE__));
define('ALGOLIAINDEXMODADDON_TEMPLATE_PATH', ALGOLIAINDEXMODADDON_PATH . 'templates/');

load_plugin_textdomain('algolia-index-modularity-addon', false, plugin_basename(dirname(__FILE__)) . '/languages');

// Autoload from plugin
if (file_exists(ALGOLIAINDEXMODADDON_PATH . 'vendor/autoload.php')) {
    require_once ALGOLIAINDEXMODADDON_PATH . 'vendor/autoload.php';
}
require_once ALGOLIAINDEXMODADDON_PATH . 'Public.php';

// Start application
new AlgoliaIndexModularityAddon\App();
