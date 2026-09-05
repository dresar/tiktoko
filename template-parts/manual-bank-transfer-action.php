<div>
    <div class="text-sm mb-5 text-center">
        <span><?php echo $args['instruction']; ?></span>
    </div>
    <div class="py-8 px-5 rounded border border-lime-700 border-dashed flex items-center space-x-5">
        <div class="w-20">
            <img src="<?php echo $args['icon']; ?>" class="w-full h-auto" />
        </div>
        <div class="text-primary flex-grow">
            <div class="border-b border-gray-100 border-dashed text-xl font-bold text-center flex itemc-center justify-center space-x-3">
                <span><?php echo $args['account_number']; ?></span>
                <span class="cursor-pointer flex items-center justify-center space-x-1 text-xs" @click="$clipboard('<?php echo $args['account_number']; ?>')">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                        </svg>
                    </span>
                    <span>Copy</span>
                </span>
            </div>
            <div class="text-center text-sm"><span><?php echo $args['account_name']; ?></span></div>
        </div>
    </div>
</div>