<?php

defined('PLUGINPATH') or exit('No direct script access allowed');

/*
  Plugin Name: Demo
  Description: It's a demo plugin.
  Version: 1.0
  Requires at least: 3.0
  Author: Author Name
  Author URL: https://author_url.demo
 */

//add menu item to left menu
app_hooks()->add_filter('app_filter_staff_left_menu', function ($sidebar_menu) {
    $sidebar_menu["demo"] = array(
        "name" => "demo",
        "url" => "demo",
        "class" => "hash",
        "position" => 3,
    );

    return $sidebar_menu;
});

//add admin setting menu item
app_hooks()->add_filter('app_filter_admin_settings_menu', function ($settings_menu) {
    $settings_menu["plugins"][] = array("name" => "demo", "url" => "demo_settings");
    return $settings_menu;
});

//install dependencies
register_installation_hook("Demo", function ($item_purchase_code) {
    /*
     * you can verify the item puchase code from here if you want. 
     * you'll get the inputted puchase code with $item_purchase_code variable
     * use exit(); here if there is anything doesn't meet it's requirements
     */

    $this_is_required = true;
    if (!$this_is_required) {
        echo json_encode(array("success" => false, "message" => "This is required!"));
        exit();
    }

    //run installation sql
    $db = db_connect('default');
    $dbprefix = get_db_prefix();

    $sql_query = "CREATE TABLE IF NOT EXISTS `" . $dbprefix . "demo_settings` (
        `setting_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        `setting_value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
        `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'app',
        `deleted` tinyint(1) NOT NULL DEFAULT '0',
        UNIQUE KEY `setting_name` (`setting_name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $db->query($sql_query);

    $sql_query = "INSERT INTO `" . $dbprefix . "demo_settings` (`setting_name`, `setting_value`, `deleted`) VALUES
                ('file_demo', '" . 'a:4:{s:9:"file_name";s:31:"demo_file61b4cfad0a1ec-Demo.png";s:9:"file_size";s:4:"6233";s:7:"file_id";N;s:12:"service_type";N;}' . "', 0),
                ('setting_demo', 'Some value here', 0);";
    $db->query($sql_query);
});

//add setting link to the plugin setting
app_hooks()->add_filter('app_filter_action_links_of_Demo', function () {
    $action_links_array = array(
        anchor(get_uri("demo"), "Demo"),
        anchor(get_uri("demo_settings"), "Demo settings"),
    );

    return $action_links_array;
});

//update plugin
register_update_hook("Demo", function () {
    echo "Please follow this instructions to update:";
    echo "<br />";
    echo "Your logic to update...";
});

//uninstallation: remove data from database
register_uninstallation_hook("Demo", function () {
    $dbprefix = get_db_prefix();
    $db = db_connect('default');

    $sql_query = "DROP TABLE IF EXISTS `" . $dbprefix . "demo_settings`;";
    $db->query($sql_query);
});
