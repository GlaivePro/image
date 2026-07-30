<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        'src',
        'tests',
    ]);

return (new PhpCsFixer\Config)->setFinder($finder)
	->setRiskyAllowed(true)
	->setLineEnding("\n")
    /**
     * No style rules, just some cleanliness.
     */
	->setRules([
		'@PHP8x5Migration:risky' => true,
		'@PHP8x5Migration' => true,

		// Overrides `@PHP8x5Migration:risky`
		'declare_strict_types' => false,
        'void_return' => false,

		// Overrides `@PHP8x5Migration`
        'method_argument_space' => false,

		// Additional
        'combine_consecutive_issets' => true,
        'modernize_types_casting' => true,
        'native_function_casing' => true,
        'no_alias_functions' => true,
        'no_empty_statement' => true,
        'no_superfluous_elseif' => true,
        'no_unreachable_default_argument_value' => true,
        'no_unneeded_import_alias' => true,
        'no_unused_imports' => true,
        'no_useless_concat_operator' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_useless_sprintf' => true,
	]);
