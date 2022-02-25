<?php

namespace Demo\Models;

use App\Models\Crud_model;

class Demo_settings_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'demo_settings';
        parent::__construct($this->table);
    }

    function get_setting($setting_name) {
        $result = $this->db_builder->getWhere(array('setting_name' => $setting_name), 1);
        if (count($result->getResult()) == 1) {
            return $result->getRow()->setting_value;
        }
    }

    function save_setting($setting_name, $setting_value, $type = "app") {
        $fields = array(
            'setting_name' => $setting_name,
            'setting_value' => $setting_value
        );

        $exists = $this->get_setting($setting_name);
        if ($exists === NULL) {
            $fields["type"] = $type; //type can't be updated

            return $this->db_builder->insert($fields);
        } else {
            $this->db_builder->where('setting_name', $setting_name);
            $this->db_builder->update($fields);
        }
    }

    //find all settings 
    function get_all_settings() {
        $settings_table = $this->db->prefixTable('demo_settings');
        $sql = "SELECT $settings_table.setting_name,  $settings_table.setting_value
        FROM $settings_table
        WHERE $settings_table.deleted=0";
        return $this->db->query($sql);
    }

}
