<?php

namespace Muvitomatic\View;

use Muvitomatic\Utils;

class Setting
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
        if (isset($_POST['submit']) && $_POST['submit'] === 'Save') {
            $option = $_POST['muvitomatic'];
            update_option('muvitomatic_option', $option);
        }
        $option = get_option('muvitomatic_option');
        ?>
        <div class="wrap">
            <h2><?php _e('Muvitomatic Settings', 'muvitomatic-core'); ?></h2>
            <div class="muvitomatic-container">
                <div class="muvitomatic-auto panel">
                    <h2 class="muvitomatic-title">Muvitomatic Settings</h2>
                    <form action="" method="post">
                        <div class="form-control">
                            <label for="st" class="muvitomatic-label">Status</label>
                            <select name="muvitomatic[status]" id="st">
                                <?php
                                $SZ = array('enable', 'disable');
                                foreach ($SZ as $ss) {
                                    if ($ss == $option['status']) $s = "selected"; else $s = "";
                                    echo "<option value='$ss' $s>$ss</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="interval" class="muvitomatic-label">Post Interval</label>
                            <select name="muvitomatic[interval]" id="interval">
                                <?php
                                $SZ = wp_get_schedules();
                                foreach ($SZ as $sz => $ss) {
                                    if ($sz == $option['interval']) $s = "selected"; else $s = "";
                                    echo "<option value='$sz' $s>$ss[display]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="interval" class="muvitomatic-label">Include Full Movie</label>
                            <select name="muvitomatic[include_full_movie]" id="include_full_movie">
                                <?php
                                $fullMovie = array('enable', 'disable');
                                foreach ($fullMovie as $fmuvi) {
                                    if ($fmuvi == $option['include_full_movie']) $sel = "selected"; else $sel = "";
                                    echo "<option value='$fmuvi' $sel>$fmuvi</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="keyword_generator" class="muvitomatic-label">Inject Keyword</label>
                            <select name="muvitomatic[keyword_generator]" id="keyword_generator">
                                <?php
                                $fullMovie = array('enable', 'disable');
                                foreach ($fullMovie as $fmuvi) {
                                    if ($fmuvi == $option['keyword_generator']) $sel = "selected"; else $sel = "";
                                    echo "<option value='$fmuvi' $sel>$fmuvi</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="muvitomatic_tags" class="muvitomatic-label">Movie Tags</label>
                            <textarea type="text" name="muvitomatic[muvitomatic_tags]" id="muvitomatic_tags" rows="5"
                                      ><?= $option['muvitomatic_tags'] ?></textarea>
                        </div>
                        <small style="margin-top:10px;"><strong>*example :</strong> <code>lk21, indoxxi, imdb movie,
                                layar kaca</code></small>
                        <br/>
                        <small style="margin-top:10px;"><strong>*example :</strong> <code>Download %postname%
                                Terbaru, Nonton %postname% gratis.</code></small>
                        <br/>
                        <br/>
                        <p>%postname% adalah Post Title / Judul Movie</p>
                        <br/>
                        <div class="form-submit">
                            <input type="submit" name="submit" class="button-primary" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }

}