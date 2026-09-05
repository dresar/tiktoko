<div class="h-full bg-gradient-to-r from-blue-200 via-primary to-tertinary pb-1">
    <template x-if="!$store.checkout.customer.isCompleted()">
        <div class=" py-5 px-3 bg-white">
            <div class="flex items-center space-x-2 cursor-pointer" @click="$store.checkout.customer.updateMode = true">
                <div class="w-5 h-5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div class="flex-grow">
                    <?php if (tikstore_shipping() == null) : ?>
                        <span class="text-sm font-bold"><?php _e('Complete Your information', 'tikstore'); ?></span>
                    <?php else : ?>
                        <span class="text-sm font-bold"><?php _e('Complete the shipping address', 'tikstore'); ?></span>
                    <?php endif; ?>
                </div>
                <div class="w-5 h-5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
        </div>
    </template>
    <template x-if="$store.checkout.customer.isCompleted()">
        <div class=" py-5 px-3 bg-white">
            <div class="flex items-start space-x-2 cursor-pointer" @click="$store.checkout.customer.updateMode = true">
                <div class="w-4 h-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                </div>
                <div class="flex-grow">
                    <div class="flex h-4 items-center space-x-3">
                        <span class="text-sm font-bold leading-none" x-text="$store.checkout.customer.name"></span><span class="text-sm font-bold leading-none">(<span x-text="$store.checkout.customer.phoneCode"></span>)<span x-text="$store.checkout.customer.phone"></span></span>
                    </div>
                    <?php if (tikstore_shipping() != null) : ?>
                        <div class="text-zinc-500 flex flex-col mt-2">
                            <span class="text-sm leading-4" x-text="$store.checkout.customer.address"></span>
                            <span class="text-sm leading-4" x-text="$store.checkout.customer.subdistrict.name"></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="w-4 h-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>

                </div>
            </div>
        </div>
    </template>
    <div class="fixed w-full h-0 bottom-0 left-0 z-40 transition-all ease-in-out duration-300 overflow-hidden" style="background: rgba(0,0,0,.4)" x-show="$store.checkout.customer.updateMode" x-collapse>
        <div class="max-w-xl w-full mx-auto h-screen flex items-end">
            <div class="w-full h-full flex flex-col shadow bg-gray-50 rounded-t-lg relative overflow-hidden">
                <div class="relative w-full <?php echo current_user_can('administrator') ? 'h-20' : 'h-12'; ?>">
                    <div class="w-full h-12 bg-white z-30 <?php echo current_user_can('administrator') ? 'mt-8' : ''; ?>">
                        <div class="relative border-b border-gray-100 max-w-xl w-full mx-auto h-12">
                            <template x-if="$store.checkout.customer.isCompleted()">
                                <div class="absolute top-0 left-0 h-12 w-12">
                                    <div class="w-full h-full flex items-center justify-center cursor-pointer" @click="$store.checkout.customer.updateMode = false">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </template>
                            <div class="flex items-center justify-center h-full w-full">
                                <?php if (tikstore_shipping() == null) : ?>
                                    <div class="text-sm font-bold text-primary"><?php _e('Contact information', 'tiktok'); ?></div>
                                <?php else : ?>
                                    <div class="text-sm font-bold text-primary"><?php _e('Shipping information', 'tiktok'); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="absolute top-0 right-0 h-12 w-12">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-grow mb-2 p-3">
                    <div class="flex flex-col space-y-0">
                        <div class="px-3">
                            <span class="text-xs text-zinc-500"><?php _e('Contact Information', 'tikstore'); ?></span>
                        </div>
                        <div class="bg-white border border-gray-100 p-3 text-sm font-normal">
                            <div class="flex flex-col space-y-5">
                                <div class="">
                                    <div class="relative border-b pb-2" :class="$store.checkout.customer.error.name ? 'border-red-100':'border-gray-100'">
                                        <template x-if="$store.checkout.customer.name">
                                            <span class="text-zinc-400 italic text-xs leading-none"><?php _e('Full Name', 'tikstore'); ?></span>
                                        </template>
                                        <input type="text" placeholder="<?php _e('Your full name', 'tikstore'); ?>" class="bg-white w-full focus:!ring-0 focus:outline-none shadow-none border-none bg-transparent py-1 px-0" x-model="$store.checkout.customer.name" />
                                    </div>
                                    <template x-if="$store.checkout.customer.error.name">
                                        <div class="flex items-center space-x-2 mt-1 text-tertinary">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-3 h-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>
                                            </span>
                                            <span class="text-tertinary italic text-[11px] leading-none" x-text="TIKSTORE.message.input.error"></span>
                                        </div>
                                    </template>
                                </div>
                                <div class="">
                                    <div class="relative border-b pb-2" :class="$store.checkout.customer.error.phone ? 'border-red-100':'border-gray-100'">
                                        <template x-if="$store.checkout.customer.phone">
                                            <span class="text-zinc-400 italic text-xs leading-none"><?php _e('Phone Number', 'tikstore'); ?></span>
                                        </template>
                                        <div class="flex space-x-1 items-center">
                                            <select class="bg-white w-[87px] focus:!ring-0 focus:outline-none shadow-none border-none bg-transparent py-1 px-0" x-model="$store.checkout.customer.phoneCode">
                                                <template x-for="phoneCode in $store.checkout._phoneCodes" :key="phoneCode.code">
                                                    <option :value="phoneCode.dial_code" x-text="phoneCode.code +' '+ phoneCode.dial_code" :selected="phoneCode.dial_code == $store.checkout.customer.phoneCode"></option>
                                                </template>
                                            </select>
                                            <input type="text" placeholder="<?php _e('Your phone number', 'tikstore'); ?>" class="bg-white flex-grow focus:!ring-0 focus:outline-none shadow-none border-none bg-transparent py-1 px-0" x-model="$store.checkout.customer.phone" x-mask:dynamic="$store.checkout.customer.validate.phone" />
                                        </div>
                                    </div>
                                    <template x-if="$store.checkout.customer.error.phone">
                                        <div class="flex items-center space-x-2 mt-1 text-tertinary">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-3 h-3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                </svg>
                                            </span>
                                            <span class="text-tertinary italic text-[11px] leading-none" x-text="TIKSTORE.message.input.error"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (tikstore_shipping() != null) : ?>
                        <div class="flex flex-col space-y-0 mt-3">
                            <div class="px-3">
                                <span class="text-xs text-zinc-500"><?php _e('Address Information', 'tikstore'); ?></span>
                            </div>
                            <div class="bg-white border border-gray-100 px-3 text-sm font-normal">
                                <div class="pt-3">
                                    <template x-if="TIKSTORE.shipping.provider == 'rajaongkir'">
                                        <div class="mb-5">
                                            <div class=" relative border-b pb-3" :class="$store.checkout.customer.error.subdistrict ? 'border-red-100':'border-gray-100'" x-data="rajaongkir" @click.outside="_searching=false">
                                                <template x-if="$store.checkout.customer.subdistrict.name">
                                                    <span class="text-zinc-400 italic text-xs leading-none"><?php _e('Subdistrict', 'tikstore'); ?></span>
                                                </template>
                                                <div class="relative">
                                                    <input type="text" placeholder="<?php _e('Subdisctrict', 'tikstore'); ?>" class="bg-white w-full focus:!ring-0 focus:outline-none shadow-none border-none bg-transparent py-1 px-0" x-on:focus="searching()" x-model="$store.checkout.customer.subdistrict.name" readonly />
                                                    <template x-if="_searching">
                                                        <div class="absolute top-8 left-0 w-full h-auto max-h-72 shadow-lg border border-gray-100 z-20 bg-white rounded-b-md">
                                                            <div class="px-3 mt-3">
                                                                <input type="text" placeholder="<?php _e('Type your subdisctrict', 'tikstore'); ?>" class="bg-white w-full focus:!ring-0 focus:outline-none shadow-none bg-transparent py-3 px-2 border rounded-lg" x-model="keyword" />
                                                                <template x-if="keyword.trim().length<=3">
                                                                    <span class="px-3 text-tertinary italic text-xs"><?php _e('Type 3 characters or more', 'tikstore'); ?></span>
                                                                </template>
                                                            </div>
                                                            <template x-if="subdistricts.length < 1">
                                                                <div class="w-full h-12 flex items-center justify-center">
                                                                    <span class="italic text-zinc-500"><?php _e('Not found', 'tikstore'); ?></span>
                                                                </div>
                                                            </template>
                                                            <template x-if="_loading">
                                                                <div class="w-full h-12 flex items-center justify-center">
                                                                    <span class="italic text-zinc-500"><?php _e('Loading...', 'tikstore'); ?></span>
                                                                </div>
                                                            </template>
                                                            <template x-if="subdistricts.length > 0">
                                                                <div class="w-full h-auto max-h-52 overflow-y-auto flex flex-col space-y-1 p-3 text-zinc-500 scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-100 scrollbar-thumb-rounded-md">
                                                                    <template x-for="subdistrict in subdistricts" :key="subdistrict.id">
                                                                        <label class="border w-full px-3 py-1 cursor-pointer rounded-lg flex items-center" @click="choose(subdistrict.id, subdistrict.full_name)">
                                                                            <div class="flex-grow">
                                                                                <span class="block" x-text="subdistrict.subdistrict_name + ', ' + subdistrict.city"></span>
                                                                                <span class="block text-xs text-zinc-400 italic" x-text="subdistrict.province"></span>
                                                                            </div>
                                                                            <div class="w-4 h-4">
                                                                                <input type="radio" name="subdistricts" class="radio radio-xs radio-error" />
                                                                            </div>
                                                                        </label>
                                                                    </template>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </template>
                                                    <template x-if="$store.checkout.customer.subdistrict.name">
                                                        <div class="absolute top-[5px] right-3 h-4 w-4 cursor-pointer text-tertinary" @click="clear()">
                                                            <svg xmlns=" http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                            <template x-if="$store.checkout.customer.error.subdistrict">
                                                <div class="flex items-center space-x-2 mt-1 text-tertinary">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-3 h-3">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                        </svg>
                                                    </span>
                                                    <span class="text-tertinary italic text-[11px] leading-none" x-text="TIKSTORE.message.input.error"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                    <div>
                                        <div class="relative border-b pb-3" :class="$store.checkout.customer.error.address ? 'border-red-100':'border-gray-100'">
                                            <template x-if="$store.checkout.customer.address">
                                                <span class="text-zinc-400 italic text-xs leading-none"><?php _e('Address', 'tikstore'); ?></span>
                                            </template>
                                            <textarea type="text" placeholder="<?php _e('Your Address', 'tikstore'); ?>" class="bg-white w-full focus:!ring-0 focus:outline-none shadow-none border-none bg-transparent py-1 px-0" x-model="$store.checkout.customer.address"></textarea>
                                        </div>
                                        <template x-if="$store.checkout.customer.error.address">
                                            <div class="flex items-center space-x-2 mt-1 text-tertinary">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-3 h-3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                                    </svg>
                                                </span>
                                                <span class="text-tertinary italic text-[11px] leading-none" x-text="TIKSTORE.message.input.error"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="w-full h-16 flex items-start text-sm px-3">
                    <button class="h-10 flex-1 border border-red-100 bg-tertinary text-white rounded-sm flex items-center justify-center cursor-pointer" @click="$store.checkout.customer.update()">
                        <?php _e('Save', 'tikstore'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>