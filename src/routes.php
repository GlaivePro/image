<?php

Route::pattern('gpimage_pattern', config('gpimage.url_pattern'));
Route::get('{gpimage_pattern}', fn () => '123')->name('gpimage');
