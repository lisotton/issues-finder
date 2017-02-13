#!/bin/bash

for PROJECT in $(php list.php); do
  drush dl "$PROJECT-7.x" --destination=/tmp --yes --quiet --dev
  php hook_menu.php $PROJECT
  php hook_help.php $PROJECT
  rm -rf /tmp/$PROJECT
done
