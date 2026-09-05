# Tiktoko - WordPress Theme Toko Online ala TikTok Shop

![Tiktoko Banner](screenshot.png)

**Tiktoko** (v1.6.6) adalah tema WordPress premium yang dirancang khusus untuk membuat toko online dengan tampilan dan pengalaman pengguna (UX) yang menyerupai **TikTok Shop**. Tema ini dioptimalkan untuk perangkat mobile (mobile-first), memiliki performa yang sangat cepat, dan dilengkapi dengan alur checkout mandiri tanpa memerlukan plugin e-commerce berat seperti WooCommerce.

---

## 🚀 Fitur Utama

### 📱 1. Tampilan Mobile-First & Interaktif
* **UI/UX Mirip TikTok Shop:** Desain modern, bersih, dan dioptimalkan untuk navigasi satu tangan pada smartphone.
* **Galeri Produk Dinamis:** Mendukung video dan gambar produk dengan transisi yang halus menggunakan AlpineJS.
* **Toko Online Ringan:** Berjalan sangat cepat karena tidak membebani server dengan query database WooCommerce yang kompleks.

### 🛒 2. Sistem Cart & Checkout Mandiri
* **Independent Checkout:** Menggunakan halaman checkout bawaan ([page-cart.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/page-cart.php), [page-checkout.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/page-checkout.php), dan [page-thank.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/page-thank.php)).
* **Manajemen Order Kustom:** Order dicatat langsung ke Custom Post Type `tikstore-order` yang dapat dikelola langsung dari dashboard admin WordPress.
* **Variasi Produk Fleksibel:** Mendukung variasi warna dan variasi kustom lainnya yang mudah diatur dari halaman edit produk.

### 🚚 3. Integrasi Kurir & RajaOngkir API
* **Perhitungan Ongkir Otomatis:** Integrasi dengan API RajaOngkir (tipe akun Pro) untuk menghitung tarif pengiriman hingga tingkat kecamatan di seluruh Indonesia secara real-time.
* **Free Shipping Option:** Pilihan pengiriman gratis untuk promosi toko Anda.
* **Database Kecamatan Lokal:** Menyediakan data pemetaan kecamatan langsung dari file [rajaongkir-subdistrict.json](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/data/rajaongkir-subdistrict.json).

### 💳 4. Metode Pembayaran Lokal (Indonesia)
Mendukung berbagai opsi pembayaran yang sering digunakan di Indonesia:
* **Cash on Delivery (COD)** (Bayar di Tempat)
* **Transfer Bank Manual** (Dengan instruksi pembayaran otomatis) untuk bank-bank utama:
  | Bank | File Class |
  | --- | --- |
  | **BCA** | [transfer-bank-bca.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/classes/payment-methods/transfer-bank-bca.php) |
  | **Mandiri** | [transfer-bank-mandiri.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/classes/payment-methods/transfer-bank-mandiri.php) |
  | **BRI** | [transfer-bank-bri.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/classes/payment-methods/transfer-bank-bri.php) |
  | **BNI** | [transfer-bank-bni.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/classes/payment-methods/transfer-bank-bni.php) |
  | **BSI** | [transfer-bank-bsi.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/classes/payment-methods/transfer-bank-bsi.php) |
  | **Permata** | [transfer-bank-permata.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/classes/payment-methods/transfer-bank-permata.php) |
  | **CIMB Niaga** | [transfer-bank-cimbniaga.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/classes/payment-methods/transfer-bank-cimbniaga.php) |
  | **SeaBank** | [transfer-bank-seabank.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/classes/payment-methods/transfer-bank-seabank.php) |

### 💬 5. Notifikasi WhatsApp Otomatis (Responic)
* **Integrasi Gateway Responic:** Mengirimkan pesan WhatsApp otomatis ke pelanggan ketika ada order baru (`new_order`), order COD (`new_order_cod`), perubahan status pembayaran, atau penginputan nomor resi pengiriman.
* **Kustomisasi Pesan:** Mendukung format template pesan menggunakan berbagai shortcode seperti:
  * `[order_number]` — Nomor Order
  * `[customer_name]` — Nama Pelanggan
  * `[customer_phone]` — Nomor WhatsApp/Telepon Pelanggan
  * `[items]` — Detail Produk yang Dipesan
  * `[customer_address]` — Alamat Pengiriman Lengkap
  * `[shipping]` — Kurir & Layanan Pengiriman
  * `[summary]` — Rincian Tagihan & Biaya Ongkir
  * `[payment]` — Detail Instruksi Rekening Pembayaran
  * `[total]` — Total Tagihan Akhir
  * `[shipping_tracking]` — Nomor Resi Pengiriman

### 📊 6. Facebook & TikTok Pixel Integration
* Memudahkan pelacakan konversi iklan langsung di dalam tema dengan file template khusus:
  * [tracking-facebook-pixel.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/template-parts/tracking-facebook-pixel.php)
  * [tracking-tiktok-pixel.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/template-parts/tracking-tiktok-pixel.php)

---

## 🛠️ Persyaratan Sistem

Untuk menjalankan tema Tiktoko dengan lancar, pastikan server Anda memenuhi spesifikasi berikut:
* **WordPress:** Versi 5.8 atau lebih baru.
* **PHP:** Versi 7.4, 8.0, 8.1, atau lebih baru.
* **Ekstensi PHP:** `curl` (untuk sinkronisasi API RajaOngkir & Notifikasi WhatsApp) dan `openssl`.

---

## 📥 Panduan Instalasi & Aktivasi

1. **Upload Tema:**
   * Masuk ke Admin Dashboard WordPress -> **Appearance** -> **Themes** -> **Add New** -> **Upload Theme**.
   * Pilih file zip tema `tiktoko` dan klik **Install Now**.
   * Setelah proses upload selesai, klik **Activate**.
2. **Install Plugin Wajib:**
   * Setelah aktivasi tema, Anda akan melihat notifikasi untuk menginstal plugin yang diperlukan.
   * Tema ini membutuhkan plugin **CMB2** dan **CMB2 Conditionals** (disediakan di folder [data/cmb2-conditionals.zip](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/data/cmb2-conditionals.zip)).
   * Ikuti petunjuk di layar untuk menginstal dan mengaktifkannya secara otomatis.
3. **Aktivasi Lisensi:**
   * Buka menu **Tiktoko** di panel admin.
   * Masukkan kode lisensi Tiktoko Anda untuk mengaktifkan fitur Custom Post Type Produk (`tikstore-product`) dan Order (`tikstore-order`).

---

## ⚙️ Panduan Konfigurasi

Semua pengaturan utama tema dapat diakses melalui **WordPress Customizer** (**Appearance** -> **Customize**):

1. **Pengaturan Umum & Toko:**
   * Tentukan mata uang, simbol, dan informasi dasar toko Anda.
   * Atur link Marketplace eksternal jika Anda ingin mengarahkan pelanggan ke Tokopedia, Shopee, Bukalapak, atau akun TikTok resmi Anda (diatur di [misc.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/functions/misc.php)).
2. **Pengaturan Ongkos Kirim (RajaOngkir):**
   * Masukkan API Key RajaOngkir Anda.
   * Pilih lokasi asal pengiriman (Origin) hingga tingkat kecamatan.
3. **Pengaturan Pembayaran:**
   * Aktifkan metode pembayaran yang diinginkan (COD atau Bank Transfer).
   * Masukkan nomor rekening dan nama pemilik rekening untuk bank transfer yang aktif.
4. **Pengaturan Notifikasi WhatsApp:**
   * Masukkan token API Responic Anda.
   * Ubah isi template pesan sesuai dengan gaya bahasa brand Anda menggunakan shortcode yang tersedia di menu Customizer.

---

## 📁 Struktur Folder & File Penting

Berikut adalah beberapa file penting dalam struktur tema Tiktoko:
* [functions.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/functions.php) — File inisialisasi utama tema yang memuat semua library, class, dan fungsi.
* [style.css](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/style.css) — File informasi metadata tema WordPress.
* `/classes/` — Direktori pengolah logika orientasi objek (OOP):
  * [classes/product.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/classes/product.php) — Logika tipe data produk, metadata gambar, atribut, dan variasi.
  * [classes/order.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/classes/order.php) — Logika pemesanan, status pesanan, dan rekap detail customer.
  * `/classes/shippings/` — Logika kalkulasi ongkir (RajaOngkir & Free Shipping).
  * `/classes/payment-methods/` — Logika metode pembayaran bank lokal & COD.
  * `/classes/notifications/` — Kelas integrasi notifikasi via Responic WhatsApp Gateway.
* `/functions/` — Kumpulan file utilitas dan handler event:
  * [functions/setup.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/functions/setup.php) — Pembuatan halaman otomatis (Cart, Checkout, Thank You, Blog) dan inisialisasi tabel custom.
  * [functions/register.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/functions/register.php) — Pendaftaran Post Type Produk & Order serta inisialisasi form metabox CMB2.
  * [functions/notification.php](file:///c:/Users/NCN0C/Downloads/tiktoko-v1.6.6/tiktoko/functions/notification.php) — Handler pengiriman notifikasi WhatsApp & pencatatan log notifikasi.
* `/template-parts/` — Komponen antarmuka pengguna (UI) modular untuk halaman detail produk, cart, checkout, dan tracking pixel.

---

## 🛠️ Database Custom Tables
Tema ini secara otomatis membuat dua tabel tambahan di database WordPress Anda saat diaktifkan untuk performa optimal:
1. `wp_tikstore_shipping_cost` — Menyimpan data cache perhitungan ongkos kirim agar loading checkout lebih cepat.
2. `wp_tikstore_notification` — Mencatat log status pengiriman notifikasi WhatsApp (sukses/gagal beserta respon API).

---

## 👨‍💻 Kontributor & Dukungan
* **Developer/Author:** Tiktoko Team & Labs ID Team (<admin@labs.id>)
* **Official Website:** [tematoko.com](https://tematoko.com)

---
*Catatan: Tema ini dilindungi hak cipta dan lisensi komersial. Dilarang mendistribusikan ulang tema ini tanpa izin tertulis dari pihak tematoko.com.*
