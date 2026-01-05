# Laporan Tugas 2: Inspira OOTD Microservice
**Mata Kuliah: II3160 Teknologi Sistem Terintegrasi**

---

### 1. Deskripsi Proyek
**Inspira** adalah layanan mikro galeri fashion OOTD yang menyediakan data katalog pakaian, manajemen pengguna, dan penyimpanan koleksi papan (board). Sistem ini dirancang untuk memudahkan pengguna mencari inspirasi gaya pakaian secara publik dan menyimpan favorit mereka ke koleksi pribadi.

* **URL Layanan:** https://inspira-container.otwdochub.my.id/
---

### 2. Arsitektur & Infrastruktur
Layanan ini dideploy menggunakan **Docker Container** di atas perangkat **Set Top Box (STB) Armbian**. Penggunaan Docker memastikan sistem berjalan secara terisolasi, sehingga tidak membebani sistem operasi utama pada perangkat STB dan menjamin stabilitas layanan.

**Bukti Kontainer Aktif:**
> <img width="1919" height="701" alt="image" src="https://github.com/user-attachments/assets/463fbac8-c114-4b0a-a7d5-1efba5c2d2b5" />


---

### 3. Implementasi Keamanan 
Sistem menerapkan prosedur **Authentication & Authorization** berbasis token untuk melindungi data sensitif pengguna.

* **Authentication**: Pengguna wajib melakukan registrasi dan login untuk mendapatkan token akses unik.
* **Authorization**: Akses ke fitur koleksi (Boards) dilindungi oleh AuthFilter. Sistem menggunakan metode **Literal Token Matching** pada HTTP Header Authorization.

> **Catatan Pengujian:** Untuk mengakses endpoint terproteksi, masukkan token **langsung** pada Header Authorization

---

### 4. Dokumentasi API Endpoints 

| Fitur | Method | Endpoint | Akses | Keterangan |
| :--- | :--- | :--- | :--- | :--- |
| Gallery | GET | /api/looks | Publik | Melihat 15 data inspirasi OOTD. |
| Register | POST | /api/register | Publik | Mendaftarkan akun user baru. |
| Login | POST | /api/login | Publik | Mendapatkan token akses unik. |
| Add Pin | POST | /api/boards/1/looks | Token | Menambah OOTD ke board (Protected). |

---

### 5. Panduan Pengujian Sistem (Menggunakan POSTMAN)

1. **Inisialisasi Data**: Akses /database/init dan /database/seed di browser untuk memuat data awal.
2. **Registrasi**: Gunakan POST /api/register untuk membuat akun baru.
3. **Login**: Gunakan POST /api/login untuk mendapatkan token.
4. **Uji Otorisasi**:
    * Kirim request ke POST /api/boards/1/looks tanpa header (Muncul 401 Unauthorized).
    * Tambahkan Header Authorization berisi token (Muncul 200 OK / Success).

