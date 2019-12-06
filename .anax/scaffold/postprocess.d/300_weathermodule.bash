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

# Check if api.php is present in the project
# If not make one out of the sample
# And if it exist just echo and dont overwrite.
FILE="config/api.php"
if test -f "$FILE"; then
    echo "$FILE exist"
else
    cp config/api_sample.php config/api.php
fi