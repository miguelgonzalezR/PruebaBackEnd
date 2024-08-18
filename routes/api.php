<?php

use Illuminate\Support\Facades\Route;

$routeFiles = glob(base_path('routes/api/*.php'));

foreach ($routeFiles as $routeFile) {
    require $routeFile;
}

