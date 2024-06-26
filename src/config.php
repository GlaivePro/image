<?php

return [
	/*
	 * {options} is where the manipulation options will go.
	 */
	'url_parameter' => '-image({options})',

	/*
	 * {parameters} will get replaced by url_parameter, e.g. -image({options})
	 * producing something that matches URIs like 'img/flag-image(200x300).jpg'.
	 */
	'url_pattern' => '^(.*){parameters}\.(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$',

	/*
	 * If the $path doesn't exist in the public_path, but asset($path) is
	 * accessible, set this to `true`.
	 */
	'web_files' => false,
];
