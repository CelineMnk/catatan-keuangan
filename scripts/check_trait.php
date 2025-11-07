<?php
require __DIR__ . '/../vendor/autoload.php';

echo trait_exists('Illuminate\\Foundation\\Testing\\CreatesApplication') ? '1' : '0';
