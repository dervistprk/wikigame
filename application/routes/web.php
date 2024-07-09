<?php

use Illuminate\Support\Facades\Route;

/**
 * Maintenance Route
 */
Route::middleware('prevent_access')->get('bakimdayiz', function() {
    return view('frontend.errors.maintenance');
});

/**
 * Backend Routes
 */
foreach (config('backend.routes') as $name => $route) {
    Route::prefix($route['prefix'])->name($route['group_name'])->middleware($route['middleware'])->{$route['method']}($route['uri'], [$route['controller'], $route['function']])->name($name);
}

/**
 * Frontend Routes
 */
foreach (config('frontend.routes') as $name => $route) {
    Route::middleware($route['middleware'])->{$route['method']}($route['uri'], [$route['controller'], $route['function']])->name($name);
}