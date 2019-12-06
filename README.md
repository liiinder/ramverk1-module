Weather Module for ANAX framework
=================================

Install with composer `composer require liiinder/ramverk1-module`

#### Manual installation
Then you need to move these specific folders from the module to the framework

    rsync -av vendor/liiinder/ramverk1-module/view/ view/
    rsync -av vendor/liiinder/ramverk1-module/config/ config/
    rsync -av vendor/liiinder/ramverk1-module/content/ content/

They contain view files for the module

Last step, change the name of api_sample.php to api.php and replace \[xxxxx\] with your api-keys.

#### Scaffold installation
bash vendor/liiinder/ramverk1-module/.anax/scaffold/postprocess.d/300_weathermodule.bash

If its a fresh installation you need to add your api keys in `config/api.php`.

#### Weather map
The Weather map is hardcoded to have a height of 500px but its easily changed in `view/weather/main.php row 24`.
Just delete the style property and add the map id with the prefered style to the projects css.