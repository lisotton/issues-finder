<?php

$projects = json_decode(file_get_contents('projectsd7.json'), TRUE);

print implode(PHP_EOL, array_column($projects, 'project'));
