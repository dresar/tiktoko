<style>
    .tikstore-license {
        min-height: calc(100vh - 150px);
        height: auto;
        width: 400px;
        margin: 0 auto;
        padding: 20px 0 0 0;
    }
</style>
<div class="wrap" style="position:relative">
    <div class="tikstore-license">
        <div style="width: 100px;height:100px;border-radius: 100%;overflow:hidden;box-shadow:0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); margin:0 auto 30px">
            <img src="<?php echo TIKSTORE_URL . '/img/logo.png'; ?>" style="width: 100px ;height:100px">
        </div>
        <div style="background: white;border-radius: 5px; width:100%;box-shadow:0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);padding: 50px 20px 50px 20px">
            <div style="text-align:center;width:100%;margin-bottom: 20px;">
                <span style="font-size: 18px;">Terimakasih sudah memilih TikToko</span>
            </div>
        </div>
    </div>
</div>
<script>
    (function($) {
        'use strict';

        $(document).ready(function() {
            $('#activate').on('click', function() {
                this.value = 'Activating .....';
                this.disabled = true;
                const code = $('#code').val();
                const nonce = $('#nonce').val();
                $.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    dataType: "json",
                    data: {
                        code: code,
                        action: '<?php echo $args['activate_action']; ?>',
                        nonce: nonce
                    }
                }).done(function(res) {
                    console.log(res)
                    window.location.href = window.location;
                })
            });

            $('#deactivate').on('click', function() {
                this.value = 'Deactivating .....';
                this.disabled = true;
                const nonce = $('#nonce').val();
                let c = confirm('Are you sure?');
                if (c) {
                    $.ajax({
                        url: ajaxurl,
                        method: 'POST',
                        dataType: "json",
                        data: {
                            action: '<?php echo $args['deactivate_action']; ?>',
                            nonce: nonce
                        }
                    }).done(function(res) {
                        console.log(res)
                        window.location.href = window.location;
                    })
                }
            });
        });


    })(jQuery);
</script>