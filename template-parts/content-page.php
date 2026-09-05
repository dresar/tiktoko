<article id="post-<?php the_ID(); ?>" <?php post_class('relative'); ?>>

    <header class="entry-header mb-4">
        <?php the_title(sprintf('<h1 class="entry-title text-3xl font-bold leading-tight mb-1"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h1>'); ?>
    </header>

    <div class="entry-content prose text-primary">
        <?php the_content(); ?>
    </div>

</article>