<?php /* Template Name: Page Cart */ ?>
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

<body <?php body_class('bg-gray-50 text-primary antialiased font-nunito'); ?> x-data>

    <div id="page" class="min-h-screen flex flex-col max-w-xl w-full mx-auto bg-gray-50">
        <header class="relative w-full h-12">
            <div class="fixed left-0 w-full h-12 bg-white z-30 <?php echo current_user_can('administrator') ? 'top-8' : ''; ?>">
                <div class="relative border-b border-gray-100 max-w-xl w-full mx-auto h-12">
                    <div class="absolute top-0 left-0 h-12 w-12">
                        <div class="w-full h-full flex items-center">
                            <a href="<?php echo get_bloginfo('url'); ?>" class="font-bold text-sm flex space-x-2 items-center">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center justify-center h-full w-full">
                        <div class="text-sm font-bold text-primary"><?php _e('Cart', 'tiktok'); ?> (<span x-text="$store.cart.items.length"></span>)</div>
                    </div>
                    <div class="absolute top-0 right-0 h-12 w-12">
                        <template x-if="$store.cart.items.length>0">
                            <div class="w-full h-full flex items-center justify-end cursor-pointer" @click="$store.cart.toggleEdit()">
                                <template x-if="!$store.cart.edit">
                                    <span class="text-sm mr-2"><?php _e('Edit', 'tikstore'); ?></span>
                                </template>
                                <template x-if="$store.cart.edit">
                                    <span class="text-sm mr-2"><?php _e('Done', 'tikstore'); ?></span>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <div id="content" class="flex-grow">
            <main class="relative w-full">
                <div class="mt-1 mb-20 flex flex-col space-y-2">
                    <?php get_template_part('template-parts/cart-items'); ?>
                    <?php get_template_part('template-parts/cart-item-empty'); ?>
                </div>
                <template x-if="$store.cart.items.length>0">
                    <div class="fixed w-full left-0 bottom-0 h-16 pb-4 bg-white border-t z-30">
                        <div class="max-w-xl w-full mx-auto h-12 flex items-center px-1 xs:px-3">
                            <div class="h-12 flex items-center">
                                <label class="flex items-center space-x-1 cursor-pointer">
                                    <input type="checkbox" class="checkbox checkbox-xs checkbox-error text-white" x-model="$store.cart.allChecked" @click="$store.cart.toggleCheckAll()" />
                                    <span class="text-xs xs:text-sm"><?php _e('Check all', 'tikstore'); ?></span>
                                </label>
                            </div>
                            <div class="flex-grow h-full">
                                <template x-if="!$store.cart.edit">
                                    <div class="h-full flex space-x-2 items-center text-sm">
                                        <div class="h-10 flex-grow flex flex-col justify-center">
                                            <span class="block text-right w-full leading-5 text-sm xs:text-base font-bold" x-money:<?php echo tikstore_options('currency'); ?>="$store.cart.total"></span>
                                            <span class="block text-right w-full leading-3 text-tertinary text-xs"><span><?php _e('Discount', 'tikstore'); ?> </span><span x-money:<?php echo tikstore_options('currency'); ?>="$store.cart.discount"></span></span>
                                        </div>
                                        <a href="<?php echo get_bloginfo('url'); ?>/checkout/" class="h-10 px-3 xs:px-8 border border-tertinary bg-tertinary text-white rounded-sm flex items-center justify-center cursor-pointer">
                                            <span><?php _e('Check out', 'tikstore'); ?></span> (<span x-text="$store.cart.count"></span>)
                                        </a>
                                    </div>
                                </template>
                                <template x-if="$store.cart.edit">
                                    <div class="h-full flex space-x-2 items-center text-sm">
                                        <div class="h-full flex-grow flex justify-end items-center space-x-1 cursor-pointer" @click="$store.cart.delete()">
                                            <span class="text-right text-base font-bold text-tertinary"><?php _e('Delete', 'tikstore'); ?></span><span class="text-right text-base font-bold"><?php _e('selected item', 'tikstore'); ?></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </main>
        </div>
    </div>

    <?php wp_footer(); ?>

</body>

</html>