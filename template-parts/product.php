<article id="post-<?php the_ID(); ?>" <?php post_class('relative border border-gray-100 bg-white mb-3 w-full'); ?> x-data>
    <a href="<?php echo esc_url(get_the_permalink()); ?>" class="w-full">
        <div class="w-full flex justify-center items-center overflow-hidden" x-data>
            <img x-thumbnail src="<?php echo tiktstore_product_thumbnail_url(); ?>" class="w-full h-auto" alt="<?php echo get_the_title(); ?>" />
        </div>
        <div class="p-3">
            <?php the_title('<h2 class="h-10 text-base font-normal leading-tight line-clamp-2">', '</h2>'); ?>
            <?php if (tikstore_product_promo_text() && is_array(tikstore_product_promo_text())) : ?>
                <div class="flex items-center space-x-3">
                    <?php foreach (tikstore_product_promo_text() as $text) : ?>
                        <span class="text-tertinary bg-red-100 px-1 text-xs font-semibold"> <?php echo $text; ?> </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="flex items-center space-x-3 mt-2">
                <div class="font-bold text-base"><?php echo tikstore_product_formated_price(); ?></div>
                <?php if (tikstore_product_formated_price_strik()) : ?>
                    <div class="text-sm font-normal text-gray-400 line-through"><?php echo tikstore_product_formated_price_strik(); ?></div>
                <?php endif; ?>
            </div>
            <?php do_action('tikstore_single_product_before_title'); ?>
        </div>
    </a>
</article>