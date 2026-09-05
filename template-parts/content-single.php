<article id="post-<?php the_ID(); ?>" <?php post_class('relative'); ?>>

    <header class="entry-header mb-4">
        <div class="w-full flex justify-center items-center overflow-hidden mb-5" x-data>
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="aspect-video" alt="<?php echo get_the_title(); ?>" />
        </div>
        <?php the_title(sprintf('<h1 class="entry-title text-3xl font-bold leading-tight mb-1"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h1>'); ?>
        <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished" class="text-sm text-gray-700"><?php echo get_the_date(); ?></time>
    </header>

    <div class="entry-content prose text-primary">
        <?php the_content(); ?>
    </div>

</article>