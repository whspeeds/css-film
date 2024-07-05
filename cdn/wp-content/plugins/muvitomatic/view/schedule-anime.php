<?php

namespace Muvitomatic\View;

use Muvitomatic\Plugin;
use Muvitomatic\Utils;

class ScheduleAnime
{

    public static $instance = null;

    public static function instance()
    {
        if (NULL === self::$instance)
            self::$instance = new self;

        return self::$instance;
    }

    public function page()
    {
        if (isset($_POST['submit']) && $_POST['submit'] == 'Save') {
            $option = $_POST['muvitomatic'];
            update_option('muvitomatic_option', $option);
        }
        ?>
        <div class="wrap">
            <h2><?= __('Anime Schedule Posts', Utils::TEXT_DOMAIN); ?>
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
                        <th>GDP ID</th>
                        <th width="100">Title</th>
                        <th style="min-width: 70px !important;">Total Eps</th>
                        <th>Date Published</th>
                        <th width="30" style="min-width: 20px !important;">Post Status</th>
                        <th width="250" style="min-width: 250px !important;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php Utils::getAnimeSchedule();?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        Utils::instance()->set_footer_inline_script();
    }

}