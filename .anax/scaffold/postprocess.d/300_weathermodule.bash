#!/usr/bin/env bash
#
# anax/remserver
#
# Integrate the REM server onto an existing anax installation.
#

# Copy the configuration files
rsync -av vendor/liiinder/ramverk1-module/config/ config/

# Copy the view files
rsync -av vendor/liiinder/ramverk1-module/view/ view/

# Copy the content files (adds the api document route)
rsync -av vendor/liiinder/ramverk1-module/content/ content/

# Change name of api_sample
mv config/api_sample.php config/api.php