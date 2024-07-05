<?php
namespace Muvitomatic\Models;

class Setup {

    protected static $instance = null;

    public static function instance()
    {
        if (NULL === self::$instance)
            self::$instance = new self;

        return self::$instance;
    }

    public function database() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $movie_table = $wpdb->prefix . 'muvitomatic_movie';
        $movie_anime = $wpdb->prefix . 'muvitomatic_anime';
        $movie_series = $wpdb->prefix . 'muvitomatic_series';

        if ($wpdb->get_var("SHOW TABLES LIKE '{$movie_table}'") != $movie_table) {
            $sql = "CREATE TABLE $movie_table (
		id bigint(0) NOT NULL AUTO_INCREMENT,
		muvi varchar(200) NOT NULL,
		date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		title varchar(200) NOT NULL,
		post_id longtext NOT NULL,
		UNIQUE KEY id (ID)
	    ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
        if ($wpdb->get_var("SHOW TABLES LIKE '{$movie_anime}'") != $movie_anime) {
            $sql = "CREATE TABLE $movie_anime (
		id bigint(0) NOT NULL AUTO_INCREMENT,
		gdp_id varchar(200) NOT NULL,
		type varchar(200) NOT NULL,
		title varchar(200) NOT NULL,
		total_episodes varchar(200) NOT NULL,
		date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		post_id longtext NOT NULL,
		UNIQUE KEY id (ID)
	    ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
        if ($wpdb->get_var("SHOW TABLES LIKE '{$movie_series}'") != $movie_series) {
            $sql = "CREATE TABLE $movie_series (
		id bigint(0) NOT NULL AUTO_INCREMENT,
		gdp_id varchar(200) NOT NULL,
		type varchar(200) NOT NULL,
		title varchar(200) NOT NULL,
		total_episodes varchar(200) NOT NULL,
		date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		post_id longtext NOT NULL,
		UNIQUE KEY id (ID)
	    ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
}