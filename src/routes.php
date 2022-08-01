<?php

use GlaivePro\Image\Controller;

Route::pattern('gpimage_pattern', app('gpimage')->pattern());
Route::get('{gpimage_pattern}', Controller::class)->name('gpimage');
