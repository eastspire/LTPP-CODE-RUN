<?php

use Webman\Route;
use app\controller\Base;
use Webman\Http\Request;

Route::fallback(function (Request $request) {
    $path = $request->path();
    return Base::notFoundPage($path);
});
