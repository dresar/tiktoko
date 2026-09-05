<?php

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area my-8">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            printf(
                _nx('One comment', '%1$s comments', get_comments_number(), 'comments title', 'tikstore'),
                number_format_i18n(get_comments_number()),
                get_the_title()
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 56,
                )
            );
            ?>
        </ol>

    <?php endif; ?>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>

        <nav class="comment-navigation" id="comment-nav-above">

            <h1 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'tikstore'); ?></h1>

            <?php if (get_previous_comments_link()) { ?>
                <div class="nav-previous">
                    <?php previous_comments_link(__('&larr; Older Comments', 'tikstore')); ?>
                </div>
            <?php } ?>

            <?php if (get_next_comments_link()) { ?>
                <div class="nav-next">
                    <?php next_comments_link(__('Newer Comments &rarr;', 'tikstore')); ?>
                </div>
            <?php } ?>

        </nav><!-- #comment-nav-above -->

    <?php endif; ?>

    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    $author = esc_attr($commenter['comment_author']);
    $email = esc_attr($commenter['comment_author_email']);

    $author_field = '<div class="w-full flex space-x-5 items-center text-sm mt-1"><div class="flex-1"><input class="focus:!ring-0 focus:outline-none border p-3 rounded w-full bg-zinc-50" id="author" placeholder="' . ($req ? '* Full Name' : '') . '" name="author" type="text" value="' . $author . '" ' . $aria_req . ' required></div>';

    $email_field = '<div class="flex-1"><input class="focus:!ring-0 focus:outline-none border p-3 rounded w-full bg-zinc-50" id="email" placeholder="' . ($req ? '* Email' : '') . '" name="email" type="text" value="' . $email . '" ' . $aria_req . ' required></div></div>';

    comment_form(
        array(
            'class_submit'  => 'bg-primary text-white cursor-pointer rounded font-bold py-2 px-4',
            'comment_field' => '<textarea id="comment" name="comment" class="bg-gray-200 w-full py-2 px-3 test" aria-required="true"></textarea>',
            //'title_reply' => __('Replies', 'tikstore'),
            'logged_in_as' => '',
            'fields' => [
                'author' => $author_field,
                'email'  => $email_field,
                'url'    => '', //$web_field,
                'cookies' => '',
            ],
            'label_submit'         => __('Send Comment', 'tikstore'),
            'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" value="%4$s" class="mt-2 border px-10 py-3 rounded cursor-pointer bg-zinc-800 text-zinc-100 text-sm" />',
            'submit_field'         => '<div>%1$s %2$s</div>',
        )
    );
    ?>

</div>