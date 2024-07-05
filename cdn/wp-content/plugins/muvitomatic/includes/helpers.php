<?php

function muvitomatic_load() {

    load_plugin_textdomain( 'muvitomatic', false, dirname( MUVITOMATIC_PLUGIN_BASE ) . '/lang/' );
    muvitomatic_include( 'includes/licensing.php' );
    muvitomatic_include( 'model/setup.php' );
    muvitomatic_include( 'includes/notice.php' );
    muvitomatic_include( 'includes/plugin.php' );

}
add_action( 'plugins_loaded', 	'muvitomatic_load' );

register_activation_hook( MUVITOMATIC__FILE__, 'muvitomatic_activate' );

function muvitomatic_include( $file ) {

    $path = muvitomatic_get_path( $file );

    if ( file_exists( $path ) ) {
        include_once( $path );
    }
}

function muvitomatic_get_path( $path ) {

    return MUVITOMATIC_PATH . $path;

}

/**
 * Runs code upon activation
 *
 * @since 1.1.3
 */
function muvitomatic_activate() {
    add_option( 'muvitomatic_do_activation_redirect', true );
}

/**
 * Deactivates the plugin
 *
 * @since 0.1.0
 */
function muvitomatic_deactivate() {
    deactivate_plugins( plugin_basename( __FILE__ ) );
}

/**
 * Cron Setup
 */

    add_action('init', 'cron_activation', 10);
    add_action('muvitomatic_cron', 'cron_action');
    add_filter('cron_schedules', 'cron_schedule');

function cron_activation()
{
    $option = get_option('muvitomatic_option');
    if ($option['status'] == 'enable') {
        if (!wp_next_scheduled('muvitomatic_cron', array('muvitomatic'))) {
            wp_schedule_event(time(), $option['interval'], 'muvitomatic_cron', array('muvitomatic'));
        }
    } else {
        wp_clear_scheduled_hook('muvitomatic_cron', array('muvitomatic'));
    }
}

function cron_schedule($schedules = '')
{
    $sch = array(1, 5, 10, 15, 20, 30, 40, 50, 55, 120, 240, 360);
    foreach ($sch as $d) {
        if (!isset($schedules[$d])) {
            $runSchedule = "every_".$d."_minutes";
            $timeSchedule = $d * 60;
            $schedules[$runSchedule] = array(
                'interval' => $timeSchedule,
                'display' => __('Once every ' . $d . ' minutes'));
        }
    }
    return $schedules;
}

function cron_action($id = '')
{
    \Muvitomatic\Utils::instance()->post_all();
    \Muvitomatic\Utils::instance()->post_anime();
    \Muvitomatic\Utils::instance()->post_series();
}