<div class="w-full bg-white text-sm">
    <div class="w-full flex items-center p-3 border-b border-gray-100">
        <div class="flex-1">
            <span class="font-bold"><?php _e('Shipping', 'tikstore'); ?></span>
        </div>
    </div>
    <div class="w-full p-3 border-b border-gray-100 flex items-center space-x-3">
        <div class="w-1/2 flex items-center space-x-2">
            <span class=""><?php _e('From:', 'tikstore'); ?></span> <span class="text-xs text-zinc-400 line-clamp-1"><?php echo tikstore_shipping()->origin_name(); ?></span>
        </div>
        <div class="w-1/2 flex items-center space-x-2">
            <span class=""><?php _e('To:', 'tikstore'); ?></span> <span class="text-xs text-zinc-400 line-clamp-1" x-text="$store.checkout.customer.subdistrict.name"></span>
        </div>
    </div>
    <?php if (get_theme_mod('_tikstore_shipping_provider', 'free') == 'free') : ?>
        <div class="w-full p-3 border-b border-gray-100 text-tertinary cursor-pointer" @click="$store.checkout.shipping.fetch()">
            <div class="flex-grow border border-tertinary p-5 rounded" style="background: rgb(227, 62, 90, .1)">
                <span class=""><?php echo get_theme_mod('_tikstore_shipping_free_message', 'Gratis ongkir untuk pesananmu hari ini'); ?></span>
            </div>
        </div>
    <?php else : ?>
        <template x-if="!$store.checkout.shipping.check()">
            <div class="w-full p-3 border-b border-gray-100 flex items-center space-x-3 text-tertinary cursor-pointer" @click="$store.checkout.shipping.fetch()">
                <div class="w-5 h-5">
                    <span class="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                    </span>
                </div>
                <div class="flex-grow">
                    <span class=""><?php _e('Choose shipping courier', 'tikstore'); ?></span>
                </div>
                <div class="w-5 h-5">
                    <span class="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                </div>
            </div>
        </template>
        <template x-if="$store.checkout.shipping.check()">
            <div class="w-full p-3 border-b border-gray-100 flex items-center space-x-3 cursor-pointer" @click="$store.checkout.shipping.fetch()">
                <div class="flex-grow">
                    <div><span class="text-xs font-bold" x-text="$store.checkout.shipping.method.name"></span></div>
                    <div>
                        <span class="text-sm text-zinc-400" x-text="$store.checkout.shipping.method.service"></span>
                    </div>
                </div>
                <div class="w-14">
                    <span x-money:<?php echo tikstore_options('currency'); ?>="$store.checkout.shipping.method.cost"></span>
                </div>
                <div class="w-24 h-5 flex justify-end items-center text-tertinary">
                    <span class="text-sm"><?php _e('Change', 'tikstore'); ?></span>
                    <span class="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                </div>
            </div>
        </template>
        <div class="fixed w-full h-0 bottom-0 left-0 z-40 transition-all ease-in-out duration-300 overflow-hidden" style="background: rgba(0,0,0,.4)" x-show="$store.checkout.shipping.open" x-collapse>
            <div class="max-w-xl w-full mx-auto h-screen flex items-end">
                <div class="w-full h-auto shadow bg-gray-50 rounded-t-lg relative overflow-y-auto">
                    <div class="mb-2 p-3 scrollbar-thin scrollbar-thumb-gray-900 scrollbar-track-gray-100" style="max-height: calc(100vh - 150px)">
                        <div class="bg-white border border-gray-100 text-sm font-normal rounded-t-lg overflow-hidden">
                            <div class="flex flex-col">
                                <template x-for="method in $store.checkout.shipping.methods">
                                    <div class="relative border-b border-gray-100 p-3 text-sm hover:text-tertinary" :class="$store.checkout.shipping.check() && $store.checkout.shipping.method.id == method.id ? 'text-tertinary': 'text-zinc-500'" @click="$store.checkout.shipping.choose(method)">
                                        <div class="flex space-x-3 items-center cursor-pointer">
                                            <div class="flex-grow">
                                                <div><span class="text-xs font-bold" x-text="method.courier.name"></span></div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-sm" x-text="method.service"></span>
                                                    <template x-if="method.etd">
                                                        <span class="text-xs">(<span x-text="method.etd"></span> <span><?php _e('Days', 'tikstore'); ?></span>)</span>
                                                    </template>
                                                </div>
                                            </div>
                                            <div class="w-24 text-right">
                                                <span x-money:<?php echo tikstore_options('currency'); ?>="method.cost"></span>
                                            </div>
                                            <div class="w-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="w-full h-16 flex items-start text-sm px-3">
                        <button class="h-10 flex-1 border border-red-100 bg-tertinary text-white rounded-sm flex items-center justify-center cursor-pointer" @click="$store.checkout.shipping.confirm()">
                            <?php _e('Confirm', 'tikstore'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>