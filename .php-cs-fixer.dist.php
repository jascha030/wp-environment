<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

/**
 * Retrieve custom directories.
 */
$custom_options = __DIR__ . '/config/php-cs-fixer.php';

/**
 * Load custom options from bootstrap file.
 */
if (! file_exists($custom_options)) {
    throw new \RuntimeException("Add file: \"{$custom_options}\", returning an array of with keys, `'dirs' => [],` (directories relative to public/app/ to add directories to the `composer run format` command.) and `'rules' => [],` to override any of the default rules.");
}

$options = include $custom_options;

/**
 * Load custom directories.
 */
$directories = [];

if (! empty($options['dirs']) && is_array($options['dirs'])) {
    $directories = $options['dirs'];
}

/**
 * Prepend all dirs with path to app folder.
 */
$directories = preg_filter('/^/', __DIR__ . '/public/app/', $directories);

if (empty($directories)) {
    exit('Nothing to fix...');
}

/**
 * Create Finder object.
 */
$dirs = Finder::create()->exclude('vendor')->in($directories);

/**
 * Load custom rules.
 */
$custom_rules = [];

if (! empty($options['rules']) && is_array($options['rules'])) {
    $custom_rules = $options['rules'];
}

/**
 * Defaults.
 */
$rules = [
    'align_multiline_comment'      => true,
    'array_indentation'            => true,
    'array_syntax'                 => ['syntax' => 'short'],
    'binary_operator_spaces'       => ['default' => 'align'],
    'blank_line_after_namespace'   => true,
    'blank_line_after_opening_tag' => false, // False due to nature of WordPress templating.
    'blank_line_before_statement'  => [
        'statements' => [
            'break',
            'case',
            'continue',
            'declare',
            'default',
            'exit',
            'goto',
            'include',
            'include_once',
            'require',
            'require_once',
            'return',
            'switch',
            'throw',
            'try',
        ],
    ],
    'braces' => [
        'allow_single_line_anonymous_class_with_empty_body' => true,
        'allow_single_line_closure'                         => true,
    ],
    'cast_spaces'                            => true,
    'class_attributes_separation'            => ['elements' => ['method' => 'one']],
    'class_definition'                       => ['single_line' => true],
    'clean_namespace'                        => true,
    'combine_consecutive_issets'             => true,
    'combine_consecutive_unsets'             => true,
    'combine_nested_dirname'                 => true,
    'compact_nullable_typehint'              => true,
    'concat_space'                           => ['spacing' => 'one'],
    'constant_case'                          => true,
    'declare_equal_normalize'                => true,
    'dir_constant'                           => true,
    'echo_tag_syntax'                        => true,
    'elseif'                                 => true,
    'encoding'                               => true,
    'ereg_to_preg'                           => true,
    'error_suppression'                      => true,
    'escape_implicit_backslashes'            => true,
    'explicit_indirect_variable'             => true,
    'explicit_string_variable'               => true,
    'fopen_flag_order'                       => true,
    'fopen_flags'                            => ['b_mode' => false],
    'full_opening_tag'                       => true,
    'fully_qualified_strict_types'           => true,
    'function_declaration'                   => true,
    'function_to_constant'                   => true,
    'function_typehint_space'                => true,
    'general_phpdoc_tag_rename'              => ['replacements' => ['inheritDocs' => 'inheritDoc']],
    'heredoc_to_nowdoc'                      => true,
    'implode_call'                           => true,
    'include'                                => true,
    'increment_style'                        => true,
    'indentation_type'                       => true,
    'is_null'                                => true,
    'lambda_not_used_import'                 => true,
    'line_ending'                            => true,
    'logical_operators'                      => true,
    'lowercase_cast'                         => true,
    'lowercase_keywords'                     => true,
    'lowercase_static_reference'             => true,
    'magic_constant_casing'                  => true,
    'magic_method_casing'                    => true,
    'method_argument_space'                  => ['on_multiline' => 'ensure_fully_multiline'],
    'method_chaining_indentation'            => true,
    'modernize_types_casting'                => true,
    'multiline_comment_opening_closing'      => true,
    'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
    'native_constant_invocation'             => true,
    'native_function_casing'                 => true,
    'native_function_invocation'             => [
        'include' => ['@compiler_optimized'],
        'scope'   => 'namespaced',
        'strict'  => true,
    ],
    'native_function_type_declaration_casing' => true,
    'new_with_braces'                         => true,
    'no_alias_functions'                      => true,
    'no_alias_language_construct_call'        => true,
    'no_alternative_syntax'                   => false, // False due to nature of WordPress templating.
    'no_binary_string'                        => true,
    'no_blank_lines_after_class_opening'      => true,
    'no_break_comment'                        => true,
    'no_closing_tag'                          => true,
    'no_empty_comment'                        => true,
    'no_empty_phpdoc'                         => true,
    'no_empty_statement'                      => true,
    'no_extra_blank_lines'                    => [
        'tokens' => [
            'break',
            'case',
            'continue',
            'curly_brace_block',
            'default',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'switch',
            'throw',
            'use',
            'use_trait',
        ],
    ],
    'no_homoglyph_names'                          => true,
    'no_leading_import_slash'                     => true,
    'no_leading_namespace_whitespace'             => true,
    'no_mixed_echo_print'                         => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_null_property_initialization'             => true,
    'no_php4_constructor'                         => true,
    'no_short_bool_cast'                          => true,
    'no_singleline_whitespace_before_semicolons'  => true,
    'no_spaces_after_function_name'               => true,
    'no_spaces_around_offset'                     => true,
    'no_spaces_inside_parenthesis'                => true,
    'no_superfluous_elseif'                       => true,
    'no_superfluous_phpdoc_tags'                  => ['allow_mixed' => true, 'allow_unused_params' => true],
    'no_trailing_comma_in_list_call'              => true,
    'no_trailing_comma_in_singleline_array'       => true,
    'no_trailing_whitespace'                      => true,
    'no_trailing_whitespace_in_comment'           => true,
    'no_trailing_whitespace_in_string'            => true,
    'no_unneeded_control_parentheses'             => [
        'statements' => [
            'break',
            'clone',
            'continue',
            'echo_print',
            'return',
            'switch_case',
            'yield',
            'yield_from',
        ],
    ],
    'no_unneeded_curly_braces'                      => ['namespaces' => true],
    'no_unneeded_final_method'                      => true,
    'no_unreachable_default_argument_value'         => true,
    'no_unused_imports'                             => true,
    'no_useless_else'                               => true,
    'no_useless_return'                             => true,
    'no_useless_sprintf'                            => true,
    'no_whitespace_before_comma_in_array'           => true,
    'no_whitespace_in_blank_line'                   => true,
    'non_printable_character'                       => true,
    'normalize_index_brace'                         => true,
    'object_operator_without_whitespace'            => true,
    'operator_linebreak'                            => ['position' => 'beginning'],
    'ordered_class_elements'                        => true,
    'ordered_imports'                               => true,
    'phpdoc_add_missing_param_annotation'           => true,
    'phpdoc_align'                                  => true,
    'phpdoc_annotation_without_dot'                 => true,
    'phpdoc_indent'                                 => true,
    'phpdoc_inline_tag_normalizer'                  => true,
    'phpdoc_no_access'                              => true,
    'phpdoc_no_alias_tag'                           => true,
    'phpdoc_no_empty_return'                        => true,
    'phpdoc_no_package'                             => true,
    'phpdoc_no_useless_inheritdoc'                  => true,
    'phpdoc_order'                                  => true,
    'phpdoc_order_by_value'                         => true,
    'phpdoc_return_self_reference'                  => true,
    'phpdoc_scalar'                                 => true,
    'phpdoc_separation'                             => true,
    'phpdoc_single_line_var_spacing'                => true,
    'phpdoc_summary'                                => true,
    'phpdoc_tag_type'                               => ['tags' => ['inheritDoc' => 'inline']],
    'phpdoc_to_comment'                             => true,
    'phpdoc_trim'                                   => true,
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'phpdoc_types'                                  => true,
    'phpdoc_types_order'                            => true,
    'phpdoc_var_annotation_correct_order'           => true,
    'phpdoc_var_without_name'                       => true,
    'pow_to_exponentiation'                         => true,
    'protected_to_private'                          => true,
    'psr_autoloading'                               => true,
    'return_assignment'                             => true,
    'return_type_declaration'                       => true,
    'self_accessor'                                 => true,
    'semicolon_after_instruction'                   => true,
    'set_type_to_cast'                              => true,
    'short_scalar_cast'                             => true,
    'simple_to_complex_string_variable'             => true,
    'single_blank_line_at_eof'                      => true,
    'single_blank_line_before_namespace'            => true,
    'single_class_element_per_statement'            => true,
    'single_import_per_statement'                   => true,
    'single_line_after_imports'                     => true,
    'single_line_comment_style'                     => true,
    'single_line_throw'                             => true,
    'single_quote'                                  => true,
    'single_space_after_construct'                  => true,
    'single_trait_insert_per_statement'             => true,
    'space_after_semicolon'                         => ['remove_in_empty_for_expressions' => true],
    'standardize_increment'                         => true,
    'standardize_not_equals'                        => true,
    'string_line_ending'                            => true,
    'switch_case_semicolon_to_colon'                => true,
    'switch_case_space'                             => true,
    'switch_continue_to_break'                      => true,
    'ternary_operator_spaces'                       => true,
    'ternary_to_elvis_operator'                     => true,
    'trailing_comma_in_multiline'                   => true,
    'trim_array_spaces'                             => true,
    'unary_operator_spaces'                         => true,
    'visibility_required'                           => true,
    'whitespace_after_comma_in_array'               => true,
    'yoda_style'                                    => true,
];

$rules = array_merge($rules, $custom_rules);

/**
 * Create config.
 */
return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setFinder($dirs);
