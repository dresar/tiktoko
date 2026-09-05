<template x-for="item in $store.checkout.items">
    <div class="w-full bg-white border-t border-b border-gray-50">
        <div class="px-3 pb-1 pt-3 flex items-start space-x-3 mb-2">
            <div class="border border-gray-100 w-24 h-24 rounded-sm overflow-hidden flex items-center">
                <img :src="item.thumbnail" class="w-full h-auto rounded-sm" />
            </div>
            <div class="flex-grow h-24">
                <div class="flex flex-col w-full h-full space-y-1">
                    <div class="flex-grow">
                        <div class="flex h-full flex-col justify-between">
                            <div class="text-zinc-600 text-sm" x-text="item.title"></div>
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
                            <div class="font-bold text-base" x-money:<?php echo tikstore_options('currency'); ?>="item.price"></div>
                        </div>
                        <div class="">
                            <div class="flex items-center text-sm">
                                <span class="">x</span><span class="" x-text="item.quantity"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-10 border-t border-gray-50 px-3 flex items-center justify-end space-x-3 text-sm text-zinc-500">
            <span><?php _e('Sub total:', 'tikstore'); ?> <span class="text-sm text-primary font-bold" x-money:<?php echo tikstore_options('currency'); ?>="item.price*item.quantity"></span></span>
        </div>
    </div>
</template>