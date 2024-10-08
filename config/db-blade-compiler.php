<?php

return [
    /*
     * This property will be added to model being compiled with DbView
     * to keep track of which field in the model is being compiled
     */

    'model_property' => '__db_blade_compiler_content_field',

    /*
     * The default model field to be compiled when not explicitly specified
     * with DbView::field()
     */

    'model_default_field' => 'template',

    'cache' => env('BLADE_DB_COMPILER_CACHE', false),
];
