<?php

namespace Tikstore\Notifications;

class ResponicDefaultMessage
{
    public static function customer_new_order()
    {
        $message = 'Halo [customer_name] terima kasih atas pesananmu,
Berikut ringkasan pesanannya
Nomor order :
*[order_number]*
Items :
[items]

[summary]
Methode Pengiriman :
*[shipping]*

Harap segera lakukan pembayaran pada rekening di bawah ini agar bisa kami proses
[payment]';

        return $message;
    }

    public static function customer_new_order_cod()
    {
        $message = 'Halo [customer_name] terima kasih atas pesananmu,
Berikut ringkasan pesanannya
Nomor order :
*[order_number]*
Items :
[items]

[summary]
Methode Pengiriman :
*[shipping]*

Pesananmu menggunaka pembayaran COD,
Harap siapkan dana sebesar [total] dan bayarkan ke kurir';

        return $message;
    }

    public static function admin_new_order()
    {
        $message = 'Ada pesanan baru min
Nomor order [order_number]';

        return $message;
    }

    public static function customer_on_hold()
    {
        $message = 'Terima kasih [customer_name]
atas pembayaran yang Anda lakukan,
Paketmu akan sesegra mungkin
kami kirimkan ke alamatmu';

        return $message;
    }

    public static function customer_on_shipping()
    {
        $message = 'Hi [customer_name],
Pesananmu dengan nomor order
*[order_number]*
sudah dalam pengiriman

Kurir
[shipping]

Nomor Resi :
*[shipping_tracking]*';

        return $message;
    }

    public static function customer_completed()
    {
        $message = 'Halo [customer_name]
terima kasih sudah belanja,

Mudah mudahan suka dengan produknya';

        return $message;
    }

    public static function customer_canceled()
    {
        $message = 'Halo [customer_name]
Mohon maaf pesananmu telah kami batalkan';

        return $message;
    }

    /**
     * customer refunded
     *
     * @return string
     */
    public static function customer_refunded()
    {
        $message = 'Hi [customer_name]
Kami telah melakukan refund atas pembayaran
pesananmu dengan nomor order [order_number]

Terima kasih';

        return $message;
    }
}
