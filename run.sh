#!/bin/sh
php install/install.php;
php install/demo_data.php;
open -a "/Applications/Google Chrome.app" 'http://localhost:8000' |php -S localhost:8000