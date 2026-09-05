<?php get_header(); ?>

<div class="mx-auto my-8 bg-gray-50">
    <?php get_template_part('template-parts/item-navigations'); ?>

    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $query = new WP_Query([
        'post_type' => 'post',
        'paged'          => $paged,
        'posts_per_page' => 8,
        's' => get_search_query()
    ]);
    ?>

    <?php if ($query->have_posts()) : ?>
        <div id="products" class="relative grid grid-cols-2 gap-4 p-3">
            <?php
            while ($query->have_posts()) :
                $query->the_post();
            ?>
                <?php get_template_part('template-parts/content'); ?>
            <?php endwhile; ?>
        </div>
        <div class="mt-5 flex space-x-2 items-center justify-center">
            <?php
            foreach (pagination($paged, $query->max_num_pages) as $n) {
            ?>
                <div class="w-10 h-10 bg-white border border-gray-100 flex items-center justify-center text-sm"><span class="font-bold"><?php echo $n; ?></span></div>
            <?php
            }
            ?>
        </div>


    <?php else : ?>
        <div class="w-full h-60 flex items-center justify-center">
            <p class="text-primary"><?php echo __('No posts found', 'tikstore'); ?></p>
        </div>
    <?php endif; ?>

</div>

<?php
get_footer();
