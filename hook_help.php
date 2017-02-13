<?php

$project_name = $argv[1];

$project_path = "/tmp/$project_name/";

$project = glob($project_path . '*.module');
$errors_file = 'errors.log';

if (empty($project)) {
  exit;
}

$project_main_file = reset($project);

if (!file_exists($project_main_file)) {
  exit; 
}

require $project_main_file;

if (!function_exists($project_name . '_help')) {
  file_put_contents($errors_file, '[ERROR] There is no hook_menu: ' . $project_name . PHP_EOL, FILE_APPEND);
}
