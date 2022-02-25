<?php

/**
 * get the defined config value by a key
 * @param string $key
 * @return config value
 */
if (!function_exists('get_demo_setting')) {

    function get_demo_setting($key = "") {
        $config = new Demo\Config\Demo();

        $setting_value = get_array_value($config->app_settings_array, $key);
        if ($setting_value !== NULL) {
            return $setting_value;
        } else {
            return "";
        }
    }

}

/**
 * link the css files 
 * 
 * @param array $array
 * @return print css links
 */
if (!function_exists('demo_load_css')) {

    function demo_load_css(array $array) {
        $version = get_setting("app_version");

        foreach ($array as $uri) {
            echo "<link rel='stylesheet' type='text/css' href='" . base_url(PLUGIN_URL_PATH . "Demo/$uri") . "?v=$version' />";
        }
    }

}

if (!function_exists('demo_get_source_url')) {

    function demo_get_source_url($demo_file = "") {
        if (!$demo_file) {
            return "";
        }

        try {
            $file = unserialize($demo_file);
            if (is_array($file)) {
                return get_source_url_of_file($file, get_demo_setting("demo_file_path"), "thumbnail", false, false, true);
            }
        } catch (\Exception $ex) {
            
        }
    }

}