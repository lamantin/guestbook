<?php
print "Kérlek nyiss meg böngészőben : http://localhost:8000".PHP_EOL;
exec('php install/install.php');
exec('php install/demo_data.php');
exec('php -S localhost:8000');

