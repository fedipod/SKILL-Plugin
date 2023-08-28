/*
Plugin Name: SKILL Plugin
Plugin URI: http://your_plugin_uri_here
Description: Control and receive notifications for Ubi-House Smart Home Devices.
Author: Tao Zhou
Author URI: http://your_author_uri_here
Version: 1.0
*/

// 创建插件菜单项
function skill_plugin_menu() {
    add_menu_page('SKILL Control Panel', 'SKILL Control', 'manage_options', 'skill-main', 'skill_plugin_main_page');
    add_submenu_page('skill-main', 'Ubi-House Device Settings', 'Device Settings', 'manage_options', 'ubi-house-device-settings', 'ubi_house_device_settings_page');
    add_submenu_page('skill-main', 'Add Linkage', 'Add Linkage', 'manage_options', 'skill-add-linkage', 'skill_add_linkage_page');
}
add_action('admin_menu', 'skill_plugin_menu');

// 插件主页
function skill_plugin_main_page() {
    echo '<h1>Welcome to SKILL Control Panel</h1>';
    // 可以显示统计或其他信息
}

// Ubi-House设备设置页面
function ubi_house_device_settings_page() {
    ?>
    <div class="wrap">
        <h1>Ubi-House Smart Home Device Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('ubi_house_device_settings_group');
            do_settings_sections('ubi-house-device-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php

// 添加联动页面
function skill_add_linkage_page() {
    ?>
    <div class="wrap">
        <h1>Add Linkage</h1>
        <!-- 这里可以添加一个表单，用于定义联动规则，例如：当哪个传感器的读数达到某个值时，触发哪个设备的哪个动作 -->
    </div>
    <?php
}

// 注册插件设置
function skill_plugin_settings_init() {
    register_setting('ubi_house_device_settings_group', 'mastodon_api_url');
    register_setting('ubi_house_device_settings_group', 'mastodon_token');

    add_settings_section(
        'ubi_house_device_settings_mastodon_section',
        'Mastodon Settings',
        null,
        'ubi-house-device-settings'
    );

    add_settings_field(
        'mastodon_api_url',
        'Mastodon API URL',
        'skill_plugin_mastodon_api_url_callback',
        'ubi-house-device-settings',
        'ubi_house_device_settings_mastodon_section'
    );

    add_settings_field(
        'mastodon_token',
        'Mastodon Token',
        'skill_plugin_mastodon_token_callback',
        'ubi-house-device-settings',
        'ubi_house_device_settings_mastodon_section'
    );
}
add_action('admin_init', 'skill_plugin_settings_init');

function skill_plugin_mastodon_api_url_callback() {
    $mastodon_api_url = get_option('mastodon_api_url', '');
    echo "<input type='text' name='mastodon_api_url' value='{$mastodon_api_url}' />";
}

function skill_plugin_mastodon_token_callback() {
    $mastodon_token = get_option('mastodon_token', '');
    echo "<input type='password' name='mastodon_token' value='{$mastodon_token}' />";
}