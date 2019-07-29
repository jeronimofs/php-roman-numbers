<?php
require_once 'vendor/autoload.php';
use \Jeronimofagundes\Numbers\Roman\Helper;
echo Helper::fromArabic(2019) . PHP_EOL; // prints MMXIX
echo Helper::toArabic('MMXIX') . PHP_EOL; // prints 2019
