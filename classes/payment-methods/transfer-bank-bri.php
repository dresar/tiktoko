<?php

namespace Tikstore\PaymentMethods;

use Yano;

class TransferBankBri extends Base
{
    use ManualBankTransfer;

    private $default = [];

    /**
     * constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->default = [
            'name'                      => 'Transfer Bank BRI',
            'description'               => __('Manual transfer to bank BRI via Mobile, ATM or Teller', 'tikstore'),
            'instruction'               => __('Transfer your payment to one of he followng bank accounts', 'tikstore'),
            'use_unique_number_pricing' => true
        ];

        $this->id                        = 'transfer_bank_bri';
        $this->is_enable                 = get_theme_mod('_tikstore_payment_method_' . $this->id, false);
        $this->name                      = get_theme_mod('_tikstore_payment_method_' . $this->id . '_name', $this->default['name']);
        $this->description               = get_theme_mod('_tikstore_payment_method_' . $this->id . '_description', $this->default['description']);
        $this->icon                      = TIKSTORE_URL . '/img/payments/bri.png';
        $this->use_unique_number_pricing = true;
        $this->instruction               = get_theme_mod('_tikstore_payment_method_' . $this->id . '_instruction', $this->default['instruction']);
    }
}
