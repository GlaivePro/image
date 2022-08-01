<?php

$parameter = str_replace('\{options\}', '([0-9a-zA-Z\(\),\-/._]+?)?', preg_quote(config('gpimage.url_parameter')));
$pattern = str_replace('{parameters}', $parameter, config('gpimage.url_pattern'));

Route::pattern('gpimage_pattern', $pattern);
Route::get('{gpimage_pattern}', fn () => '123')->name('gpimage');
