<?php /* Template Name: Page Payment */
global $order;
?>
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
                        <div class="text-sm font-bold text-primary"><?php echo $order->title; ?></div>
                    </div>
                </div>
            </div>
        </header>
        <div id="content" class="flex-grow">
            <main class="relative w-full pb-28 text-primary">
                <div class="mt-5 mb-2 flex flex-col space-y-2 p-3" x-data="{total: <?php echo $order->total; ?>}">
                    <?php if ($order->status == 'new_order') : ?>
                        <div class="flex space-x-2 items-center">
                            <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <span class="font-bold text-sm">
                                <?php _e('Your order waiting for payment', 'tikstore'); ?>
                            </span>
                        </div>
                        <div class="flex space-x-2 items-center  justify-center p-5 border border-gray-100 rounded-lg bg-gray-100">
                            <span><?php _e('Total : ', 'tikstore'); ?></span>
                            <span class="font-bold text-sm" x-money:<?php echo tikstore_options('currency'); ?>="total"></span>
                            <span class="text-tertinary cursor-pointer" @click="$clipboard('<?php echo $order->total; ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                </svg>
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if ($order->status == 'on_hold') : ?>
                        <div class="flex space-x-2 items-center">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                </svg>
                            </span>
                            <span class="font-bold text-sm">
                                <?php _e('Your order is being packed', 'tikstore'); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if ($order->status == 'on_shipping') : ?>
                        <div class="flex space-x-2 items-center">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                </svg>
                            </span>
                            <span class="font-bold text-sm">
                                <?php _e('Your order is on delivery', 'tikstore'); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if ($order->status == 'completed') : ?>
                        <div class="flex space-x-2 items-center">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                </svg>
                            </span>
                            <span class="font-bold text-sm">
                                <?php _e('Your order has been completed', 'tikstore'); ?>
                            </span>
                        </div>
                        <div class="flex space-x-2 items-center  justify-center p-5 border border-gray-100 rounded-lg bg-white">
                            <span class="text-sm"><?php _e('Thank you for shopping in our shop.', 'tikstore'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mt-5 mb-2 p-3 flex flex-col space-y-10 bg-white border-t border-gray-100">
                    <?php if ($order->status == 'new_order') : ?>
                        <?php $order->payment()->action(); ?>
                    <?php endif; ?>
                    <div class="flex flex-col space-y-2">
                        <div class="w-full">
                            <span><?php echo _e('Need help?', 'tikstore'); ?></span>
                        </div>
                        <div class="w-full">
                            <a target="_blank" href="<?php echo tikstore_get_link_wa_admin(); ?>" class="flex items-center space-x-2 justify-center w-full text-center text-white text-sm font-bold py-3 rounded-md shadow hover:shadow-none cursor-pointer" style="background: #09A784">
                                <span><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 39 39">
                                        <path fill="#00E676" d="M10.7 32.8l.6.3c2.5 1.5 5.3 2.2 8.1 2.2 8.8 0 16-7.2 16-16 0-4.2-1.7-8.3-4.7-11.3s-7-4.7-11.3-4.7c-8.8 0-16 7.2-15.9 16.1 0 3 .9 5.9 2.4 8.4l.4.6-1.6 5.9 6-1.5z"></path>
                                        <path fill="#FFF" d="M32.4 6.4C29 2.9 24.3 1 19.5 1 9.3 1 1.1 9.3 1.2 19.4c0 3.2.9 6.3 2.4 9.1L1 38l9.7-2.5c2.7 1.5 5.7 2.2 8.7 2.2 10.1 0 18.3-8.3 18.3-18.4 0-4.9-1.9-9.5-5.3-12.9zM19.5 34.6c-2.7 0-5.4-.7-7.7-2.1l-.6-.3-5.8 1.5L6.9 28l-.4-.6c-4.4-7.1-2.3-16.5 4.9-20.9s16.5-2.3 20.9 4.9 2.3 16.5-4.9 20.9c-2.3 1.5-5.1 2.3-7.9 2.3zm8.8-11.1l-1.1-.5s-1.6-.7-2.6-1.2c-.1 0-.2-.1-.3-.1-.3 0-.5.1-.7.2 0 0-.1.1-1.5 1.7-.1.2-.3.3-.5.3h-.1c-.1 0-.3-.1-.4-.2l-.5-.2c-1.1-.5-2.1-1.1-2.9-1.9-.2-.2-.5-.4-.7-.6-.7-.7-1.4-1.5-1.9-2.4l-.1-.2c-.1-.1-.1-.2-.2-.4 0-.2 0-.4.1-.5 0 0 .4-.5.7-.8.2-.2.3-.5.5-.7.2-.3.3-.7.2-1-.1-.5-1.3-3.2-1.6-3.8-.2-.3-.4-.4-.7-.5h-1.1c-.2 0-.4.1-.6.1l-.1.1c-.2.1-.4.3-.6.4-.2.2-.3.4-.5.6-.7.9-1.1 2-1.1 3.1 0 .8.2 1.6.5 2.3l.1.3c.9 1.9 2.1 3.6 3.7 5.1l.4.4c.3.3.6.5.8.8 2.1 1.8 4.5 3.1 7.2 3.8.3.1.7.1 1 .2h1c.5 0 1.1-.2 1.5-.4.3-.2.5-.2.7-.4l.2-.2c.2-.2.4-.3.6-.5s.4-.4.5-.6c.2-.4.3-.9.4-1.4v-.7s-.1-.1-.3-.2z"></path>
                                    </svg>
                                </span>
                                <span><?php _e('Contact admin', 'tikstore');  ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <footer id="colophon" class="site-footer py-1" role="contentinfo">
            <?php do_action('tikstore_footer'); ?>

            <div class="container mx-auto text-center text-gray-500">
                &copy; <?php echo date_i18n('Y'); ?> - <?php echo get_bloginfo('name'); ?>
            </div>
        </footer>
    </div>
    <?php wp_footer(); ?>

</body>

</html>