<?php

namespace Demo\Config;

use CodeIgniter\Config\BaseConfig;
use Demo\Models\Demo_settings_model;

class Demo extends BaseConfig {

    public $app_settings_array = array(
        "demo_file_path" => PLUGIN_URL_PATH . "Demo/files/demo_files/"
    );

    public function __construct() {
        $demo_settings_model = new Demo_settings_model();

        $settings = $demo_settings_model->get_all_settings()->getResult();
        foreach ($settings as $setting) {
            $this->app_settings_array[$setting->setting_name] = $setting->setting_value;
        }
    }

}
