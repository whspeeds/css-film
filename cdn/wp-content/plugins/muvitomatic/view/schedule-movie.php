<?php

namespace Muvitomatic\View;

use Muvitomatic\Utils;

class ScheduleMovie
{

    public static $instance = null;

    public static function instance()
    {
        if (NULL === self::$instance)
            self::$instance = new self;

        return self::$instance;
    }
    function mycode_table_column_exists( $table_name, $column_name ) {
        global $wpdb;
        $column = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ",
            DB_NAME, $table_name, $column_name
        ) );
        if ( ! empty( $column ) ) {
            return true;
        }
        return false;
    }
    public function page()
    {
        global $wpdb;
        if (isset($_POST['submit']) && $_POST['submit'] == 'Save') {
            $option = $_POST['muvitomatic'];
            update_option('muvitomatic_option', $option);
        } ?>
        <div class="wrap">
            <h2><?= __('Movie Schedule', Utils::TEXT_DOMAIN); ?>
                <button class="button button-primary" id="post_all_schedule"><?= __('Post All', Utils::TEXT_DOMAIN)?></button>
                <button class="button button" id="delete_all_schedule"><?= __('Delete All', Utils::TEXT_DOMAIN)?></button>
            </h2>
            <div class="muvitomatic-table">
                <style>
                    #muvi_lists td {
                        padding: 5px 5px;
                    }
                </style>
                <table id="muvi_lists" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Date Added</th>
                        <th>Muvi ID</th>
                        <th width="100">Title</th>
                        <th>Date Published</th>
                        <th>Post Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody><?php Utils::getMovieSchedule();?></tbody>
                </table>
            </div>
        </div>
        <?php
        Utils::instance()->set_footer_inline_script();
    }

}