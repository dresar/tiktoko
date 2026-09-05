<div class="flex flex-col space-y-1 py-1 bg-gray-50 text-sm text-secondary">
    <?php if (get_post_meta(get_the_ID(), 'colors', true)) : ?>
        <div class="bg-white pt-3 pb-1 px-3">
            <div class="mb-2 text-gray-500"><?php _e('Color', 'tikstore'); ?></div>
            <div class="flex items-center justify-start flex-wrap">
                <?php foreach (get_post_meta(get_the_ID(), 'colors', true) as $color) : ?>
                    <button class="px-3 py-1 border rounded-sm text-xs mr-3 mb-3 cursor-pointer" :class="item.color_variant == '<?php echo $color; ?>'? 'border-tertinary text-tertinary':'border-gray-200'" @click="setColorVariant('<?php echo $color; ?>')"><?php echo $color; ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (tikstore_product_custom_variations(get_the_ID())) : ?>
        <div class="bg-white pt-3 pb-1 px-3">
            <div class="mb-2 text-gray-500" x-text="item.custom_variant_title"></div>
            <div class="flex items-center justify-start flex-wrap">
                <?php foreach (tikstore_product_custom_variations(get_the_ID()) as $name => $price) : ?>
                    <div class="px-3 py-1 border rounded-sm text-xs mr-3 mb-3 cursor-pointer" :class="item.custom_variant == '<?php echo $name; ?>'? 'border-tertinary text-tertinary':'border-gray-200'" @click="setCustomVariant('<?php echo $name; ?>','<?php echo $price; ?>');"><?php echo $name; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="bg-white py-5 px-3 flex items-center justify-between">
        <div class="mb-2 text-gray-500"><?php _e('Quantity', 'tikstore'); ?></div>
        <div class="flex items-center text-xs">
            <div class="w-7 h-7 border flex items-center justify-center cursor-pointer" @click="quantity('-')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                </svg>
            </div>
            <div class="w-12 h-7 text-center leading-7 border-t border-b" x-text="item.quantity"></div>
            <div class="w-7 h-7 border flex items-center justify-center cursor-pointer" @click="quantity('+')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
        </div>
    </div>
</div>