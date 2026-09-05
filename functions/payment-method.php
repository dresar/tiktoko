<?php

function tikstore_payment_methods($active_only = false)
{
    $classes_name = [
        'Tikstore\PaymentMethods\TransferBankMandiri',
        'Tikstore\PaymentMethods\TransferBankBca',
        'Tikstore\PaymentMethods\TransferBankBri',
        'Tikstore\PaymentMethods\TransferBankBni',
        'Tikstore\PaymentMethods\TransferBankBsi',
        'Tikstore\PaymentMethods\TransferBankCimbNiaga',
        'Tikstore\PaymentMethods\TransferBankPermata',
        'Tikstore\PaymentMethods\TransferBankSeabank',
        'Tikstore\PaymentMethods\Cod'
    ];

    $classes_name = apply_filters('tikstore_payment_methods_classes', $classes_name);

    $classes = [];
    foreach ($classes_name as $class_name) {
        $class = new $class_name;
        if ($active_only) {
            if ($class->is_enable()) {
                $classes[] = $class;
            }
        } else {
            $classes[] = $class;
        }
    }

    return $classes;
}

/**
 * tikstore_payment_method
 * 
 * gget payment method by id otherwise get the first payment method from array classes
 *
 * @param  mixed $id
 * @return void
 */
function tikstore_payment_method($id = false)
{
    $methods = tikstore_payment_methods();

    if (!is_array($methods) || count($methods) < 1) return null;

    if ($id) {
        foreach ($methods as $class) {
            if ($class->id() == $id) {
                return $class;
                break;
            }
        }
    }

    return $methods[0];
}


function tikstore_checkout_payment_methods()
{
    $payment_methods = [];
    foreach (tikstore_payment_methods(true) as $payment_method) {
        $payment_methods[] = [
            'id'          => $payment_method->id(),
            'name'        => $payment_method->name(),
            'icon'        => $payment_method->icon(),
            'description' => $payment_method->description()
        ];
    }

    return tikstore_json($payment_methods);
}
