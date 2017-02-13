<?php

$project_name = $argv[1];
$module_path = "/tmp/$project_name/";

$module = glob($module_path . '*.module');
$info = glob($module_path . '*.info');
$errors_file = 'errors.log';

if (empty($module) || empty($info)) {
  exit;
}
$module = reset($module);
$info = reset($info);
$info_content = file_get_contents($info);

function t($text) {
  return 'fake text';
}

function module_load_include() {}
function ctools_include() {}
function variable_get() {}
function module_exists() {}
function drupal_get_path() {}
function libraries_get_path() {}
function drupal_static() {}
function file_scan_directory() {}

if (!file_exists($module)) {
  exit;
}

require $module;

if (!function_exists($project_name . '_menu')) {
  exit;
}

$hook_menu = call_user_func($project_name . '_menu');

foreach ($hook_menu as $menu_path => $menu_item) {
  if ($menu_item['title'] === 'fake text') {
    file_put_contents($errors_file, '[ERROR] t function called in title of hook_menu item for module: ' . $project_name . PHP_EOL, FILE_APPEND);
  }

  if (preg_match('#^admin/config/#', $menu_path) && !preg_match('#configure#', $info_content)) {
    file_put_contents($errors_file, '[ERROR] There is admin path but not configure attribute in .info: ' . $project_name . PHP_EOL, FILE_APPEND);
  }
}
