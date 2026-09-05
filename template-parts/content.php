<article id="post-<?php the_ID(); ?>" <?php post_class('relative border border-gray-100 bg-white mb-3 w-full'); ?> x-data>
    <a href="<?php echo esc_url(get_the_permalink()); ?>" class="w-full">
        <div class="w-full flex justify-center items-center overflow-hidden" x-data>
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="aspect-video" alt="<?php echo get_the_title(); ?>" />
        </div>
        <div class="p-3">
            <?php the_title('<h2 class="h-11 text-base font-normal leading-tight line-clamp-2">', '</h2>'); ?>
        </div>
    </a>
</article>