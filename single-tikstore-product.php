<?php get_header(); ?>

<div class="mx-auto mb-10" x-data="product(<?php echo tikstore_product_json_data(); ?>)">

    <?php if (have_posts()) : ?>
        <?php
        while (have_posts()) :
            the_post();
        ?>
            <?php get_template_part('template-parts/content', 'product'); ?>

            <div class="fixed w-full h-0 bottom-0 left-0 z-40 transition-all ease-in-out duration-300 overflow-hidden" style="background: rgba(0,0,0,.4)" x-show="$store.cart.showConfirmModal" x-collapse>
                <div class="max-w-xl w-full mx-auto h-screen flex items-end">
                    <div class="w-full h-auto shadow bg-white rounded-t-lg px-3 pt-3 relative">
                        <div class="flex items-start space-x-3 mb-2">
                            <div class="border border-gray-100 w-24 h-28 rounded-sm overflow-hidden">
                                <img x-src="<?php echo tiktstore_product_thumbnail_url(); ?>" class="w-full h-auto" />
                            </div>
                            <div class="flex-grow flex flex-col space-y-1">
                                <div class="font-bold text-xl" x-money:<?php echo tikstore_options('currency'); ?>="item.price"></div>
                                <?php if (tikstore_product_formated_price_strik()) : ?>
                                    <div class="text-base font-normal text-gray-400 line-through"><?php echo tikstore_product_formated_price_strik(); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="w-6 h-6 cursor-pointer" @click="$store.cart.showConfirmModal=false">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>
                        <?php get_template_part('template-parts/component-product-summary'); ?>
                        <div class="w-full h-16 flex items-start text-sm mt-5">
                            <button class="h-10 flex-1 border border-tertinary bg-tertinary text-white rounded-sm flex items-center justify-center cursor-pointer" @click="$store.cart.addItem(item)">
                                <?php _e('Confirm', 'tikstore'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php do_action('tikstore_product_after_content'); ?>
        <?php endwhile; ?>
    <?php endif; ?>

    <?php if ($query = tikstore_product_related(get_the_ID())) : ?>
        <div id="related" class="pt-8">
            <div class="px-3 mb-2 font-bold text-primary"><?php _e('You may also like', 'tikstore'); ?></div>
            <div class="relative grid grid-cols-2 gap-4 p-3 bg-gray-50 rounded-sm text-clip">
                <?php
                while ($query->have_posts()) :
                    $query->the_post();
                ?>
                    <?php get_template_part('template-parts/product'); ?>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="fixed w-full left-0 bottom-0 h-16 pb-4 bg-white border-t z-30">
        <div class="max-w-xl w-full mx-auto h-12 flex items-center px-3">
            <a href="<?php echo site_url(); ?>" class="h-12 w-10 flex items-center justify-start mx-auto text-primary cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                </svg>
            </a>
            <div class="flex-grow h-full">
                <template x-if="item.stock">
                    <div class="h-full flex space-x-2 items-center text-sm">
                        <button id="addToCart" class="h-10 flex-1 border border-tertinary text-tertinary rounded-sm flex items-center justify-center cursor-pointer" @click="$store.cart.confirmAddItem('addToCart')">
                            <span><?php _e('Add to cart', 'tikstore'); ?></span>
                        </button>
                        <button id="buyNow" class="h-10 flex-1 border border-tertinary bg-tertinary text-white rounded-sm flex items-center justify-center cursor-pointer" @click="$store.cart.confirmAddItem(item.cart_id)">
                            <?php _e('Buy Now', 'tikstore'); ?>
                        </button>
                    </div>
                </template>
                <template x-if="!item.stock">
                    <div class="h-full flex space-x-2 items-center text-sm">
                        <div class="h-9 flex-1 border border-gray-400 bg-gray-300 text-gray-500 rounded-sm flex items-center justify-center">
                            <span><?php _e('Out of stock', 'tikstore'); ?></span>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
