<div class="w-full bg-white text-sm">
    <div class="w-full flex items-center p-3 border-b border-gray-100">
        <div class="flex-1">
            <span class="font-bold"><?php _e('Payment method', 'tikstore'); ?></span>
        </div>
    </div>
    <template x-if="$store.checkout.payment.check()">
        <div class="relative border-b border-gray-100 p-3 text-sm hover:text-tertinarytext-zinc-500" @click="$store.checkout.payment.open=true">
            <div class="flex space-x-3 items-center cursor-pointer">
                <div class="w-16 text-right">
                    <img :src="$store.checkout.payment.method.icon" class="w-16 h-auto" />
                </div>
                <div class="flex-grow">
                    <div><span class="text-xs font-bold" x-text="$store.checkout.payment.method.name"></span></div>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs italic" x-text="$store.checkout.payment.method.description"></span>
                    </div>
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
        </div>
    </template>
    <template x-if="!$store.checkout.payment.check()">
        <div class="w-full p-3 border-b border-gray-100 flex items-center space-x-3 text-tertinary cursor-pointer" @click="$store.checkout.payment.open=true">
            <div class="w-5 h-5">
                <span class="">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                </span>
            </div>
            <div class="flex-grow">
                <span class=""><?php _e('Choose payment method', 'tikstore'); ?></span>
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
    <div class="fixed w-full h-0 bottom-0 left-0 z-40 transition-all ease-in-out duration-300 overflow-hidden" style="background: rgba(0,0,0,.4)" x-show="$store.checkout.payment.open" x-collapse>
        <div class="max-w-xl w-full mx-auto h-screen flex items-end">
            <div class="w-full h-auto shadow bg-gray-50 rounded-t-lg relative overflow-y-auto">
                <div class="mb-2 p-3 scrollbar-thin scrollbar-thumb-gray-900 scrollbar-track-gray-100" style="max-height: calc(100vh - 150px)">
                    <div class="bg-white border border-gray-100 text-sm font-normal rounded-t-lg overflow-hidden">
                        <div class="flex flex-col">
                            <template x-for="method in <?php echo tikstore_checkout_payment_methods(); ?>">
                                <div class="relative border-b border-gray-100 p-3 text-sm hover:text-tertinary" :class="$store.checkout.payment.check() && $store.checkout.payment.method.id == method.id ? 'text-tertinary': 'text-zinc-500'" @click="$store.checkout.payment.choose(method)">
                                    <div class="flex space-x-3 items-center cursor-pointer min-h-16">
                                        <div class="w-16 text-right">
                                            <img :src="method.icon" class="w-16 h-auto" />
                                        </div>
                                        <div class="flex-grow">
                                            <div><span class="text-xs font-bold" x-text="method.name"></span></div>
                                            <div class="flex items-center space-x-2">
                                                <span class="text-xs italic" x-text="method.description"></span>
                                            </div>
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
                    <button class="h-10 flex-1 border border-red-100 bg-tertinary text-white rounded-sm flex items-center justify-center cursor-pointer" @click="$store.checkout.payment.open = false">
                        <?php _e('Confirm', 'tikstore'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>