Weather Module for ANAX framework
=================================

Install with composer `composer require liiinder/ramverk1-module`

Then you need to move these specific files from the module to the framework

    rsync -av vendor/liiinder/ramverk1-module/view/ view/
    rsync -av vendor/liiinder/ramverk1-module/config/ config/
    rsync -av vendor/liiinder/ramverk1-module/content/ content/

Last step, change the name of api_sample.php to api.php and replace \[xxxxx\] with your api-keys.

#### Weather map
The Weather map is hardcoded to have a height of 500px but its easily changed in `view/weather/main.php row 24`.
Just delete the style property and add the map id with the prefered style to the projects css.