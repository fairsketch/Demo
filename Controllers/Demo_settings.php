<?php

namespace Demo\Controllers;

use App\Controllers\Security_Controller;

class Demo_settings extends Security_Controller {

    protected $Demo_settings_model;

    function __construct() {
        parent::__construct();
        $this->access_only_admin_or_settings_admin();
        $this->Demo_settings_model = new \Demo\Models\Demo_settings_model();
    }

    function index() {
        return $this->template->rander("Demo\Views\settings\index");
    }

    function save() {
        $this->Demo_settings_model->save_setting("setting_demo", $this->request->getPost("setting_demo"));

        //save file
        $files_data = move_files_from_temp_dir_to_permanent_dir(get_demo_setting("demo_file_path"), "demo");
        $unserialize_files_data = unserialize($files_data);
        $demo_file = get_array_value($unserialize_files_data, 0);
        if ($demo_file) {
            if (get_demo_setting("file_demo")) {
                //delete old file if exists
                $this->delete_demo_file(get_demo_setting("file_demo"));
            }

            $this->Demo_settings_model->save_setting("file_demo", serialize($demo_file));
        }

        echo json_encode(array("success" => true, 'message' => app_lang('settings_updated')));
    }

    private function delete_demo_file($demo_file) {
        try {
            $demo_file = unserialize($demo_file);
        } catch (\Exception $ex) {
            echo json_encode(array("success" => false, 'message' => $ex->getMessage()));
            exit();
        }

        delete_app_files(get_demo_setting("demo_file_path"), array($demo_file));
    }

    /* upload a file */

    function upload_file() {
        upload_file_to_temp();
    }

    /* check valid file */

    function validate_demo_file() {
        return validate_post_file($this->request->getPost("file_name"));
    }

}
