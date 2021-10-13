<?php


use Illuminate\Support\Facades\Route;





Route::get('/get-slug-from-title/{title?}', function (string $title = '') {
   return \Illuminate\Support\Str::slug($title);
});