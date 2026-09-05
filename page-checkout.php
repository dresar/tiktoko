<?php /* Template Name: Page Checkout */ ?>
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

<body <?php body_class('bg-gray-50 text-primary antialiased font-nunito'); ?> x-data x-init="$store.checkout.checkItems()">

    <div id="page" class="min-h-screen flex flex-col max-w-xl w-full mx-auto bg-gray-50 overflow-y-auto">
        <header class="relative w-full h-12">
            <div class="fixed left-0 w-full border-b border-gray-100 h-12 bg-white z-30 <?php echo current_user_can('administrator') ? 'top-8' : ''; ?>">
                <div class="relative max-w-xl w-full mx-auto h-12">
                    <div class="absolute top-0 left-0 h-12 w-12">
                        <div class="w-full h-full flex items-center">
                            <a href="<?php echo get_bloginfo('url'); ?>/cart/" class="font-bold text-sm flex space-x-2 items-center">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center justify-center h-full w-full">
                        <div class="text-sm font-bold text-primary"><?php _e('Order Summary', 'tiktok'); ?></div>
                    </div>
                </div>
            </div>
        </header>
        <div id="content" class="flex-grow">
            <main class="relative w-full pb-28">
                <?php get_template_part('template-parts/checkout-customer'); ?>
                <div class="mt-1 mb-2 flex flex-col space-y-2">
                    <?php get_template_part('template-parts/checkout-items'); ?>
                </div>
                <?php if (tikstore_shipping() != null) : ?>
                    <div class="mt-1 mb-2 flex flex-col space-y-2">
                        <?php get_template_part('template-parts/checkout-shipping'); ?>
                    </div>
                <?php endif; ?>
                <div class="mt-1 mb-2 flex flex-col space-y-2">
                    <?php get_template_part('template-parts/checkout-summary'); ?>
                </div>
                <div class="mt-1 mb-2 flex flex-col space-y-2">
                    <?php get_template_part('template-parts/checkout-payment-method'); ?>
                </div>
                <template x-if="$store.checkout.processing">
                    <div class="fixed w-full h-full left-0 bottom-0 px-3 bg-transparen z-20">
                    </div>
                </template>
                <template x-if="$store.checkout.items.length>0">
                    <div class="fixed w-full left-0 bottom-0 px-3 pb-6 bg-white border-t border-gray-100 z-30">
                        <div class="max-w-xl w-full mx-auto h-auto">
                            <div class="h-8 flex-grow flex items-center justify-between">
                                <div class="text-xs text-primary">
                                    <span class="font-bold"><?php _e('Total', 'tikstore'); ?></span>
                                    (<span class="" x-text="$store.checkout.items.length"></span> <?php _e('Items', 'tikstore'); ?>)
                                </div>
                                <div class="text-sm">
                                    <span class="font-bold" x-money:<?php echo tikstore_options('currency'); ?>="$store.checkout.total"></span>
                                </div>
                            </div>
                            <div class="w-full">
                                <button class="h-12 w-full border border-tertinary bg-tertinary text-white rounded-sm text-sm font-bold tracking-wider" @click="$store.checkout.order()" x-bind:disabled="$store.checkout.processing">
                                    <template x-if=" !$store.checkout.processing">
                                        <span><?php _e('Place Order', 'tikstore'); ?></span>
                                    </template>
                                    <template x-if="$store.checkout.processing">
                                        <span class="flex items-center justify-center">
                                            <span>
                                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="animation: spin .3s linear infinite;">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </span>
                                            <span><?php _e('Processing ...', 'tikstore'); ?></span>
                                        </span>
                                    </template>
                                </button>
                            </div>
                        </div>
                </template>
                <template x-if="$store.checkout.loading">
                    <div class="fixed w-full h-full left-0 bottom-0 px-3 pb-6 bg-white border-t border-gray-100 z-30">
                        <div class="w-full h-full flex items-center justify-center">
                            <div class="">
                                Redirecting .......
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