<?php

/**
 * Plugin Name:       Algolia Index Modularity Addon
 * Plugin URI:        https://github.com/helsingborg-stad/algolia-index-modularity-addon
 * Description:       Adds support for modularity indexing to algolia-index plugin.
 * Version:           1.0.0
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

require_once ALGOLIAINDEXMODADDON_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once ALGOLIAINDEXMODADDON_PATH . 'Public.php';

// Instantiate and register the autoloader
$loader = new AlgoliaIndexModularityAddon\Vendor\Psr4ClassLoader();
$loader->addPrefix('AlgoliaIndexModularityAddon', ALGOLIAINDEXMODADDON_PATH);
$loader->addPrefix('AlgoliaIndexModularityAddon', ALGOLIAINDEXMODADDON_PATH . 'source/php/');
$loader->register();

// Start application
new AlgoliaIndexModularityAddon\App();
