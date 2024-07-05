<?php
/**
 * Plugin Name: Muvitomatic for Muvipro
 * Plugin URI: https://clonesia.com/item/muvitomatic
 * Description: Muvitomatic adalah plugin penghemat waktu posting movie, posting movie dalam hitungan detik dan menjalankannya dengan cron autopost
 * Version: 2.1.1
 * Author: Clonesia
 * Author URI:  https://clonesia.com
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

define('MUVITOMATIC__FILE__', __FILE__);
define('MUVITOMATIC_PLUGIN_BASE', plugin_basename(MUVITOMATIC__FILE__));
define('MUVITOMATIC_URL', plugins_url('/', MUVITOMATIC__FILE__));
define('MUVITOMATIC_PATH', plugin_dir_path(MUVITOMATIC__FILE__));
define('MUVITOMATIC_ASSETS_URL', MUVITOMATIC_URL . 'assets/');
define('MUVITOMATIC_VERSION', '2.1.1');
define('MUVITOMATIC_PHP_VERSION_REQUIRED', '7.2');
define('MUVITOMATIC_PHP_VERSION_RECOMMENDED', '7.2');
define('MUVITOMATIC_TEXTDOMAIN', 'muvitomatic');

include MUVITOMATIC_PATH . 'includes/helpers.php';

