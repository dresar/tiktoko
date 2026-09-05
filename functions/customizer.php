<?php

/**
 * load custmoizer 
 */
function tikstore_init_customizer()
{
    Tikstore\Customizer::init();
}
add_action('init', 'tikstore_init_customizer');


function tikstore_options($key)
{
    $customizer = new Tikstore\Customizer();
    return $customizer->get($key);
}
