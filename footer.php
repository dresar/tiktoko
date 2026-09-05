</main>

<?php do_action('tikstore_content_end'); ?>

</div>

<?php do_action('tikstore_content_after'); ?>
<div class="w-full flex items-start space-x-5 p-3">
    <?php if (tikstore_footer_widget_payments()) : ?>
        <div class="flex-1">
            <div class="text-sm font-bold"><?php _e('Payment', 'tikstore'); ?></div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-5" x-data>
                <?php foreach (tikstore_footer_widget_payments() as $icon_url) : ?>
                    <div class="shadow p-2 flex items-center justify-center rounded-sm">
                        <img x-src="<?php echo $icon_url; ?>" />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (tikstore_footer_widget_shippings()) : ?>
        <div class="flex-1">
            <div class="text-sm font-bold"><?php _e('Shipping', 'tikstore'); ?></div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-5" x-data>
                <?php foreach (tikstore_footer_widget_shippings() as $icon_url) : ?>
                    <div class="shadow p-2 flex items-center justify-center rounded-sm">
                        <img x-src="<?php echo $icon_url; ?>" />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<footer id="colophon" class="pt-1 <?php if (is_singular('tikstore-product')) {
                                        echo 'pb-20';
                                    } ?>" role="contentinfo">
    <?php do_action('tikstore_footer'); ?>

    <div class="container mx-auto text-center text-gray-500 pt-10">
        &copy; <?php echo date_i18n('Y'); ?> - <?php echo get_bloginfo('name'); ?>
    </div>
</footer>

</div>

<?php wp_footer(); ?>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('review', () => ({
            rating: 0,
            hoverRating: 0,
            ratings: [{
                'amount': 1,
                'label': 'Terrible'
            }, {
                'amount': 2,
                'label': 'Bad'
            }, {
                'amount': 3,
                'label': 'Okay'
            }, {
                'amount': 4,
                'label': 'Good'
            }, {
                'amount': 5,
                'label': 'Great'
            }],
            rate(amount) {
                if (this.rating == amount) {
                    this.rating = 0;
                } else this.rating = amount;
            },
            currentLabel() {
                let r = this.rating;
                if (this.hoverRating != this.rating) r = this.hoverRating;
                let i = this.ratings.findIndex(e => e.amount == r);
                if (i >= 0) {
                    return this.ratings[i].label;
                } else {
                    return ''
                };
            },
            submit() {
                if (this.rating < 1) {
                    console.log(window)
                    toast$1.error('Please select a rating');
                }

            }
        }));
    });
</script>
</body>

</html>