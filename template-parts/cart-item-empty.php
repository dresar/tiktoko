<template x-if="$store.cart.items.length<1">
    <div class="w-full py-20">
        <div class="w-full flex justify-center text-zinc-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width=".5" stroke="currentColor" class="w-32 h-32">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
        </div>
        <div class="w-full flex justify-center text-zinc-500 mt-2">
            <span class="font-bold text-zinc-600"><?php _e('No product on your cart', 'tikstore');  ?></span>
        </div>
        <div class="w-full flex justify-center text-zinc-500 mt-3">
            <a :href="TIKSTORE.site" class="font-bold border border-tertinary bg-tertinary text-white px-8 py-2 rounded-sm shadow-lg"><?php _e('Shop now', 'tikstore');  ?></a>
        </div>
    </div>
</template>