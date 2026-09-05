<template x-for="item in $store.cart.items">
    <div class="w-full bg-white border-t border-b border-gray-50">
        <div class="px-1 pt-3 pb-1 xs:px-3 flex items-start space-x-2 xs:space-x-3 mb-2">
            <div class="w-6 h-24 flex items-center">
                <input type="checkbox" class="checkbox checkbox-xs checkbox-error text-white" x-model="item.is_checked" />
            </div>
            <div class="border border-gray-100 w-24 h-24 rounded-sm overflow-hidden flex items-center">
                <img :src="item.thumbnail" class="w-full h-auto" />
            </div>
            <div class="flex-grow h-24">
                <div class="flex flex-col w-full h-full space-y-1">
                    <div class="flex-grow">
                        <div class="flex h-full flex-col justify-between">
                            <div class="text-zinc-500 text-xs xs:text-sm" x-text="item.title"></div>
                            <div class="flex space-x-2 items-start mt-1">
                                <template x-if="item.color_variant">
                                    <span x-text="item.color_variant" class="inline-block px-2 bg-gray-100 text-xs text-zinc-500 rounded-sm"></span>
                                </template>
                                <template x-if="item.custom_variant">
                                    <span x-text="item.custom_variant" class="inline-block px-2 bg-gray-100 text-xs text-zinc-500 rounded-sm"></span>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-end justify-between">
                        <div class="">
                            <div class="font-bold text-sm xs:text-base" x-money:<?php echo tikstore_options('currency'); ?>="item.price"></div>
                            <template x-if="item.price_strik">
                                <div class="text-xs font-normal">
                                    <span class="text-gray-400 line-through" x-money:<?php echo tikstore_options('currency'); ?>="item.price_strik"></span>
                                    <template x-if="item.price_strik">
                                        <span class="ml-2 text-xs xs:text-sm font-normal text-tertinary" x-text="$discountinpercent(item.price, item.price_strik)">
                                        </span>
                                    </template>
                                </div>
                            </template>
                        </div>
                        <div class="">
                            <div class="flex items-center text-xs">
                                <div class="w-7 h-7 border flex items-center justify-center cursor-pointer" @click="if(item.quantity > 1){item.quantity--}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                    </svg>
                                </div>
                                <div class="w-12 h-7 text-center leading-7 border-t border-b" x-text="item.quantity"></div>
                                <div class="w-7 h-7 border flex items-center justify-center cursor-pointer" @click="if(item.quantity < item.stock){item.quantity++}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-10 border-t border-gray-50 px-3 flex items-center space-x-3 text-xs text-zinc-500">
            <span><?php _e('Sub total:', 'tikstore'); ?> <span class="text-xs text-primary font-bold" x-money:<?php echo tikstore_options('currency'); ?>="item.price*item.quantity"></span></span>
            <template x-if="item.price_strik">
                <span><?php _e('You save:', 'tikstore'); ?> <span class="text-xs text-tertinary" x-money:<?php echo tikstore_options('currency'); ?>="item.price_strik*item.quantity-item.price*item.quantity"></span></span>
            </template>
        </div>
    </div>
</template>