<?php
if (in_array(tikstore_options('homepage'), ['product', 'blog']) && is_home()) {
    get_template_part('template-parts/page', tikstore_options('homepage'));
}
if (is_search()) {
    get_template_part('template-parts/page', 'blog');
}
do_action('tikstore_homepage');
