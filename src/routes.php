<?php

use GlaivePro\Image\Controller;

Route::pattern('gpimage_pattern', GPImage::pattern());
Route::get('{gpimage_pattern}', Controller::class)->name('gpimage');
