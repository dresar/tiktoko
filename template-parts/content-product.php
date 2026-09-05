<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white'); ?>>
    <div class="w-full">
        <section class="splide w-full" x-splide>
            <div class="splide__track">
                <ul class="splide__list">
                    <?php foreach (tiktstore_product_images() as $image) : ?>
                        <li class="splide__slide"><img src="" data-splide-lazy="<?php echo $image['source']; ?>" class="w-full h-auto" alt="<?php echo get_the_title(); ?>" /></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
        <div id="summary" class="p-3 flex flex-col space-y-2">
            <div class="flex items-center space-x-3">
                <div class="font-bold text-xl" x-money:<?php echo tikstore_options('currency'); ?>="item.price"></div>
                <?php if (tikstore_product_formated_price_strik()) : ?>
                    <div class="text-base font-normal text-gray-400 line-through"><?php echo tikstore_product_formated_price_strik(); ?></div>
                <?php endif; ?>
            </div>
            <?php do_action('tikstore_single_product_before_title'); ?>
            <h2 class="h-11 text-lg font-normal leading-tight line-clamp-2" x-text="item.title"></h2>
            <?php if (tikstore_product_promo_text() && is_array(tikstore_product_promo_text())) : ?>
                <div class="flex items-center space-x-3">
                    <?php foreach (tikstore_product_promo_text() as $text) : ?>
                        <span class="text-tertinary bg-red-100 px-1 text-xs font-semibold"> <?php echo $text; ?> </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php get_template_part('template-parts/component-product-summary'); ?>
        <?php if (tikstore_shipping() != null) : ?>
            <div class="p-3">
                <div class="mb-2 font-bold text-primary"><?php _e('Shipping', 'tikstore'); ?></div>
                <div class="prose prose-sm text-primary" x-data>
                    <?php printf(__('Ship from: %s', 'tikstore'), tikstore_shipping()->origin_name()); ?>
                </div>
            </div>
        <?php endif; ?>
        <div id="description" class="p-3 border-t border-gray-100">
            <div class="mb-2 font-bold text-primary"><?php _e('Product description', 'tikstore'); ?></div>
            <div class="prose prose-sm text-primary" x-data>
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</article>