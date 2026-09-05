<div class="w-full bg-white text-sm">
    <div class="w-full flex items-center p-3 border-b border-gray-100">
        <div class="flex-1">
            <span class="font-bold"><?php _e('Summary', 'tikstore'); ?></span>
        </div>
    </div>
    <template x-for="summary in $store.checkout.summaries">
        <div class="w-full px-3 py-1 flex items-center space-x-3 cursor-pointer" :class="summary.operation == '+' ? 'text-zinc-500' : 'text-green-500'">
            <div class="flex-grow">
                <span class="" x-text="summary.label"></span>
            </div>
            <div class="w-24 text-right">
                <span class="" x-money:<?php echo tikstore_options('currency'); ?>="summary.value"></span>
            </div>
        </div>
    </template>
    <div class="w-full p-3 mt-2 flex items-center space-x-3 cursor-pointer">
        <div class="flex-grow">
            <span class=""><?php _e('Total', 'tikstore'); ?></span>
        </div>
        <div class="w-24 text-right">
            <span class="font-bold text-sm" x-money:<?php echo tikstore_options('currency'); ?>="$store.checkout.total"></span>
        </div>
    </div>
</div>