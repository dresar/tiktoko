<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php if (get_site_icon_url()) : ?>
        <link rel="icon" type="image/x-icon" href="<?php echo get_site_icon_url(); ?>">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    </link>
    <style>
        :root {
            --color-primary: #162447;
            --color-secondary: #1f4068;
            --color-tertinary: #e33e5a;
            --color-quaternary: #26a639;
        }
    </style>
    <script type='text/javascript'>
        const TIKSTORE = <?php echo tikstore_base(); ?>
    </script>
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-white text-primary antialiased font-nunito'); ?> x-data>

    <div id="page" class="min-h-screen flex flex-col max-w-xl w-full mx-auto">
        <header class="relative w-full h-12">
            <div class="fixed left-0 w-full h-12 bg-white z-30 <?php echo current_user_can('administrator') ? 'top-8' : ''; ?>">
                <div class="relative border-b border-gray-100 max-w-xl w-full mx-auto h-full">
                    <div class="flex space-x-2 items-center justify-between h-full">
                        <div class="flex items-center py-2 pl-1">
                            <a href="<?php echo get_bloginfo('url'); ?>" class="font-bold text-sm flex space-x-2 items-center">
                                <?php if (is_singular()) : ?>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                                        </svg>
                                    </span>
                                <?php endif; ?>
                                <span><?php echo get_bloginfo('name'); ?></span>
                            </a>
                        </div>
                        <div class="flex-grow">
                            <?php get_search_form(); ?>
                        </div>
                        <div class="flex justify-end items-center h-full space-x-3">
                            <a href="<?php echo site_url(); ?>/cart/" class="cursor-pointer relative">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <div class="absolute top-0 -right-2 w-5 h-5 rounded-full bg-tertinary text-white flex items-center justify-center" style="font-size: 10px">
                                    <span x-text="$store.cart.items.length"></span>
                                </div>
                            </a>
                            <nav class="cursor-pointer relative" x-data="{show : false}" @click.outside="show=false">
                                <span @click="show=!show">
                                    <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                    </svg>
                                </span>
                                <template x-if="show">
                                    <?php
                                    wp_nav_menu(
                                        array(
                                            'theme_location'  => 'primary',
                                            'menu_id'         => false,
                                            'container_class' => 'absolute right-2 w-52 pt-5',
                                            'container_id'    => 'nav-menu',
                                            'menu_id'         => 'menu-header',
                                            'menu_class'      => 'w-full shadow bg-white rounded-sm text-sm font-bold text-tertinary'
                                        )
                                    );
                                    ?>
                                </template>
                            </nav>
                        </div>
                    </div>
                    <?php if (is_singular('tikstore-product')) : ?>
                        <div class="h-6 bg-white w-full hidden" x-data="productnav" x-showscroll>
                            <div class="flex  space-x-5 h-6 w-full text-sm text-zinc-400">
                                <div class="flex-1 flex justify-center items-center">
                                    <a href="#summary" class="px-3 inline-block h-6" @click="set('summary')" :class="current == 'summary' ? 'border-b border-zinc-600 text-zinc-600':''"><?php _e('Summary', 'tikstore'); ?></a>
                                </div>
                                <div class="flex-1 flex justify-center items-center">
                                    <a href="#description" class="px-3 inline-block h-6" @click="set('description')" :class="current == 'description' ? 'border-b border-zinc-600 text-zinc-600':''"><?php _e('Description', 'tikstore'); ?></a>
                                </div>
                                <div class="flex-1 flex justify-center items-center">
                                    <a href="#related" class="px-3 inline-block h-6" @click="set('related')" :class="current == 'related' ? 'border-b border-zinc-600 text-zinc-600':''"><?php _e('Recomendations', 'tikstore'); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <div id="content" class="flex-grow">
            <?php if (tikstore_heading_on()) : ?>
                <div class="w-full pt-5 flex flex-col space-y-5">
                    <div class="flex items-center justify-center">
                        <div class="avatar w-24 h-24 rounded-full border border-secondary box-border overflow-hidden flex items-center justify-center" x-data>
                            <img x-src="<?php echo tikstore_options('custom_logo'); ?>" />
                        </div>
                    </div>
                    <div class="flex space-x-2 items-center justify-center">
                        <div class="font-bold text-base">
                            <?php echo get_bloginfo('name'); ?>
                        </div>
                        <div class="bg-blue-400 w-5 h-5 rounded-full text-white">
                            <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>

                        </div>
                    </div>
                    <?php if (tikstore_marketplaces_links()) : ?>
                        <div class="flex items-center justify-center space-x-2">
                            <?php foreach (tikstore_marketplaces_links() as $key => $value) : ?>
                                <a href="<?php echo $value['link']; ?>" class="border inline-flex text-xs rounded-sm border-gray-200 normal-case text-primary space-x-1 p-2" target="__blank" x-data>
                                    <img x-src="<?php echo $value['image']; ?>" class="w-3 h-3" />
                                    <span><?php echo $value['label']; ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <main>