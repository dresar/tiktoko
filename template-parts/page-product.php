<?php get_header(); ?>

<div class="mx-auto my-8 bg-gray-50">
    <?php get_template_part('template-parts/item-navigations'); ?>

    <?php if (have_posts()) : ?>
        <div id="products" class="relative grid grid-cols-2 gap-4 p-3">
            <?php
            while (have_posts()) :
                the_post();
            ?>
                <?php get_template_part('template-parts/product'); ?>
            <?php endwhile; ?>
        </div>
        <?php

        ob_start();
        posts_nav_link(' ', __('Previous Page', 'tikstore'), __('Next Page', 'tikstore'));
        $nav_link = ob_get_contents();
        ob_end_clean();

        ?>

        <?php if (strlen($nav_link) > 0) : ?>

            <div class="hidden">
                <div class="posts-navigation">
                    <?php echo $nav_link;  ?>
                </div>

                <noscript>
                    <div class="posts-navigation">
                        <?php echo $nav_link;  ?>
                    </div>
                </noscript>
            </div>

        <?php endif; ?>
    <?php else : ?>
        <div class="w-full h-60 flex items-center justify-center">
            <p class="text-primary"><?php echo __('No products found', 'tikstore'); ?></p>
        </div>
    <?php endif; ?>

</div>

<?php
get_footer();
