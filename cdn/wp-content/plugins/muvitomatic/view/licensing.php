<?php

namespace Muvitomatic\View;

use Muvitomatic\Utils;
use Muvitomatic\Licensing as License;

class Licensing
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
        ?>
        <div class="wrap">
            <h2><?php _e('Muvitomatic License Options', 'muvitomatic-core'); ?></h2>
            <div class="clonesia-license">
                <div class="clonesia-license__brand">
                    <img src="<?= MUVITOMATIC_ASSETS_URL?>img/clonesia_logo.png" alt="Clonesia"/>
                </div>
                <div class="clonesia-license__form">
                    <form method="post" action="options.php">
                        <?php settings_fields('muvitomatic_core_license'); ?>
                        <table class="form-table">
                            <tbody>
                            <tr valign="top">
                                <th scope="row" valign="top">
                                    <?php _e('License Key', 'muvitomatic-core'); ?>
                                </th>
                                <td>
                                    <input id="muvitomatic_core_license_key" name="muvitomatic_core_license_key"
                                           type="text"
                                           placeholder="XXXXX_xxxxxxxxxxxxxxx" class="regular-text"/><br/>
                                    <label class="description"
                                           for="muvitomatic_core_license_key"><?php _e('Enter your license key here', 'muvitomatic-core'); ?></label>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row" valign="top">
                                    <?php _e('Activate License', 'muvitomatic-core'); ?>
                                </th>

                                <td>
                                    <?php License::instance()->getLicense(); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
}