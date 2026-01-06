# Escrow System Project Guide

Selamat datang di proyek **Escrow System**. Dokumen ini berisi panduan lengkap untuk menginstal dan menjalankan aplikasi di lingkungan lokal.

## 📋 Prasyarat

Sebelum memulai, pastikan laptop/PC Anda sudah terinstall:

*   **PHP** (versi 8.2 atau lebih baru)
*   **Composer** (untuk manajemen package PHP)
*   **Node.js & NPM** (untuk build asset frontend)
*   **MySQL Database** (XAMPP / Laragon / Docker)

---

## 🚀 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project ini dari awal:

1.  **Clone Project** (Jika belum)
    ```bash
    git clone https://github.com/username/escrow-system.git
    cd escrow-system
    ```

2.  **Install PHP Dependencies**
    ```bash
    composer install
    ```

3.  **Install Node.js  Dependencies**
    ```bash
    npm install
    ```

4.  **Siapkan Environment**
    Salin file `.env.example` ke `.env`:
    ```bash
    cp .env.example .env
    ```

5.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan pengaturan database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=new_escrow  # Pastikan database ini sudah dibuat di phpMyAdmin/MySQL
    DB_USERNAME=root
    DB_PASSWORD=            # Kosongkan jika pakai XAMPP default
    ```

    *⚠️ Pastikan IP App untuk akses dari Network/HP:*
    ```env
    APP_URL=http://IP_LOCAL_LAPTOP_KAMU:8000
    ```

6.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

7.  **Migrate & Seed Database**
    Jalankan perintah ini untuk membuat tabel dan data pengguna bawaan (Admin, Buyer, Seller):
    ```bash
    php artisan migrate:fresh --seed
    ```

---

## 🏃‍♂️ Cara Menjalankan Aplikasi

Anda perlu menjalankan dua perintah terminal secara bersamaan (di tab/terminal terpisah):

1.  **Jalankan Backend Server (Laravel)**
    Agar bisa diakses dari HP/Jaringan luar, gunakan host 0.0.0.0:
    ```bash
    php artisan serve --host=0.0.0.0 --port=8000
    ```

2.  **Jalankan Frontend Build (Vite)**
    ```bash
    npm run dev
    ```

Sekarang aplikasi bisa diakses melalui:
*   **Laptop:** `http://localhost:8000`
*   **HP / Network:** `http://IP_LAPTOP_KAMU:8000`

---

## 🔑 Akun Login Default

Gunakan kredensial berikut untuk masuk dan menguji berbagai role:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@test.com` | `password` |
| **Buyer** | `buyer@test.com` | `password` |
| **Seller** | `seller@test.com` | `password` |
| *Arbiter* | `arbiter@test.com` | `password` |

---

## 🛠 Fitur Utama

*   **Role Management**: Logika berbeda untuk Admin, Buyer, Seller, dan Arbiter.
*   **Escrow Flow**: Created -> Funded -> Shipping -> Delivered -> Completed.
*   **Admin Panel**:
    *   Dashboard Analisis (Chart 6 bulan terakhir).
    *   Manage Users (Hapus user dengan validasi integritas).
    *   Manage Escrows (Force cancel dengan proteksi status).
    *   **Export Data CSV**.
*   **Fitur Unik**:
    *   QR Code Payment (Otomatis menyesuaikan IP).
    *   Bukti Upload saat Dispute.

---

Jika ada kendala "Vite manifest not found" atau tampilan berantakan, pastikan `npm run dev` sedang berjalan.
Selamat mencoba! 🚀
