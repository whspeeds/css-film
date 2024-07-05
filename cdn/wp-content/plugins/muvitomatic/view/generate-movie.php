<?php

namespace Muvitomatic\View;

use Muvitomatic\Utils;

class GenerateMovie
{

    public static $instance = null;
    public static function instance()
    {
        if (NULL === self::$instance)
            self::$instance = new self;

        return self::$instance;
    }
    public function page()
    { ?>

        <div class="wrap">
            <h2>Generate Movie</h2>
            <textarea name="muvitomatic[bulk]" id="muvi_bulk" cols="60" rows="8" style="display: none;"></textarea>
            <div class="muvitomatic-auto panel">

                <div class="muvitomatic-setting">
                    <label for="muvi_server">Pilih Server : </label>
                    <select name="muvitomatic[server]" id="muvi_server">
                        <option value="">Pilih Server</option>
                        <option value="server.imdb">IMDB</option>
                        <option value="server.gdp">Gdriveplayer.us</option>
                    </select>
                    <span id="server_gdp" style="display: none">
                <select name="muvitomatic[gdp_movie]" id="gdp_movie">
                    <option value="gdpmovie.movie">Movie</option>
                    <option value="gdpmovie.series">Series</option>
                    <option value="gdpmovie.anime">Anime</option>
                </select>
            </span>
                    <span id="server_imdb" style="display: none">
                <input type="number" id="muvi_year" name="muvitomatic[year]" placeholder="year" value="2019"/>
                <select name="muvitomatic[popular]" id="muvi_popularity">
                    <option value="popularity.desc">Popularity DESC</option>
                    <option value="popularity.asc">Popularity ASC</option>
                </select>
                <select name="muvitomatic[genre]" class="muvi-genre" id="muvi_genre">
                    <?php
                    $getGenre = Utils::instance()->genres_movie();
                    foreach ($getGenre as $gKey => $genre) {
                        echo "<option value='$gKey'>$genre</option>";
                    }
                    ?>
                </select>

                <input type="number" id="muvi_page" name="muvitomatic[page]" placeholder="page" value="1"/>
            </span>
                    <input type="submit" id="muvi_filter" name="muvitomatic[submit]" class="button-secondary"
                           value="Filter"/>
                    <div id="add_all_movie"></div>
                </div>


                <div class="muvitomatic-search">
                    <input type="text" name="muvitomatic[search]" id="muvi_search" placeholder="Search a Movie"/>
                    <input type="submit" name="muvitomatic[search_submit]" id="btn_muvi_search" value="Search"
                           class="button-secondary"/>
                </div>
            </div>
            <div class="muvitomatic-pages">
                <ul id="pagination"></ul>
            </div>
            <div id="message"></div>
            <div id="muvilist"></div>
        </div>
        <?php
        Utils::instance()->set_footer_inline_script();
    }
}
