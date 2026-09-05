<?php
global $wp;

$url = home_url('/');
if (tikstore_options('homepage') == 'product' && is_home() || is_post_type_archive('tikstore-product') || is_singular('tikstore-product')) {
    $url = home_url('/product/');
}

$url = apply_filters('tikstore_search_action_url', $url);
?>
<form role="search" method="get" class="w-full border border-gray-100 rounded-sm flex h-8 relative overflow-hidden" action="<?php echo $url; ?>">
    <input type="search" class="flex-grow bg-gray-50 px-3 text-sm focus:!ring-0 focus:outline-none" placeholder="<?php echo esc_attr_x('Search …', 'placeholder') ?>" value="<?php echo get_search_query() ?>" name="s" />
    <button type="submit" class="h-8 w-8 flex items-center justify-center border-l border-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </button>
</form>