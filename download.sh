#!/bin/bash

# ensure that folder "modules" exists
mkdir -p modules

for PROJECT in $(php list.php); do
  drush dl "$PROJECT-7.x" --destination=modules --yes --quiet --dev
  php hook_menu.php $PROJECT
  rm -rf modules/$PROJECT
done
