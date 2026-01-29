<?php

/**
 * Vercel Serverless Entry Point for Laravel
 */

// Load Laravel bootstrap
require __DIR__ . '/../vendor/autoload.php';

// Bind Laravel paths for Vercel environment
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

// Handle the request
$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);

