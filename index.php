<?php

// Functional Test

$loader = require_once './vendor/autoload.php';

$app = G2Design\G2App::init($loader);

$app->add_route('runs', function(){
	return '<h1>The Library Runs!!</h1>';
});

$app->start();