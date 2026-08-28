# Skenario Pengujian (Test Scenarios) InnoElectrica Expo 2026 ⚡

Dokumen ini berisi panduan skenario pengujian komprehensif *End-to-End* (E2E) untuk memastikan seluruh sistem berjalan sesuai dengan alur bisnis yang diharapkan.

---

## 1. Pengujian Landing Page & Konten Publik
**Tujuan:** Memastikan pengunjung dapat melihat informasi dengan benar.

- [ ] **Skenario 1.1:** Buka `http://localhost:8000/`. Pastikan UI Landing Page tampil sempurna tanpa error CSS.
- [ ] **Skenario 1.2:** Pastikan logo "IEE 2026" beserta icon lingkaran dan teks tampil di Navbar.
- [ ] **Skenario 1.3:** Scroll ke bagian **Gallery**, **Sponsors**, dan **Media Partners**. Pastikan gambar/logo yang di-upload oleh admin tampil dengan resolusi yang baik (dan otomatis telah dikonversi menjadi format `.webp`).
- [ ] **Skenario 1.4:** Periksa informasi statis di bagian Footer/About (Contact Person, Organizer, Location).

---

## 2. Pengujian Autentikasi & Keamanan Akses (Role-Based Access)
**Tujuan:** Memastikan setiap role hanya bisa mengakses halaman yang diizinkan.

- [ ] **Skenario 2.1 (Akses Peserta):** Daftarkan akun baru di `http://localhost:8000/register`. Setelah registrasi berhasil, pastikan Anda diarahkan ke `/dashboard` peserta.
- [ ] **Skenario 2.2 (Akses Admin):** Login menggunakan kredensial Super Admin. Anda harus otomatis diarahkan ke panel `/admin`. Jika mencoba mengakses `/dashboard`, sistem harus melempar (redirect) kembali ke `/admin`.
- [ ] **Skenario 2.3 (Akses Judge/Moderator):** Login sebagai Judge. Pastikan tidak bisa mengakses `/dashboard` dan hanya melihat menu "Assessments" di dalam panel `/admin`.

---

## 3. Pengujian Pendaftaran Kompetisi (Oleh Peserta)
**Tujuan:** Memastikan peserta bisa mendaftar lomba sesuai mode yang ditentukan (Solo/Team).

- [ ] **Skenario 3.1 (Pendaftaran Individu):**
  1. Sebagai Peserta, klik pendaftaran untuk kompetisi berjenis *Individual*.
  2. Pastikan form input nama tim **tidak muncul** atau tidak diwajibkan.
  3. Upload bukti pembayaran asli (.pdf / .png / .jpg).
  4. Submit dan pastikan status pendaftaran menjadi `pending`.
- [ ] **Skenario 3.2 (Pendaftaran Tim):**
  1. Sebagai Peserta, pilih kompetisi berjenis *Team*.
  2. Form harus mewajibkan "Team Name".
  3. Coba masukkan jumlah anggota melebihi batas maksimal (Max Team Members). Sistem harus menolak (Validasi Error).
  4. Isi data anggota dengan benar, upload bukti pembayaran, lalu Submit.

---

## 4. Pengujian Verifikasi Pembayaran (Oleh Admin / Moderator)
**Tujuan:** Memastikan Admin dapat mengecek dan memvalidasi pendaftaran.

- [ ] **Skenario 4.1 (Verifikasi Ditolak):**
  1. Login sebagai Moderator/Super Admin.
  2. Masuk ke menu **Registrations**. Buka pendaftaran yang baru saja dibuat oleh peserta.
  3. Lihat gambar `Proof of Payment`. Ubah status menjadi `rejected`.
  4. Login kembali sebagai Peserta, pastikan status pendaftarannya berubah menjadi Ditolak.
- [ ] **Skenario 4.2 (Verifikasi Diterima):**
  1. Login sebagai Admin/Moderator, ubah status pendaftaran menjadi `verified`.
  2. Pastikan Peserta kini mendapatkan akses untuk mengumpulkan karya (Submission).

---

## 5. Pengujian Pengumpulan Karya (Submission)
**Tujuan:** Memastikan peserta yang sudah divalidasi bisa mengirim karya sesuai jadwal kompetisi.

- [ ] **Skenario 5.1:** Sebagai Peserta dengan status `verified`, masuk ke halaman kompetisi.
- [ ] **Skenario 5.2:** Upload dokumen karya atau berikan Link Karya (sesuai aturan `submission_type` di kompetisi). Klik tombol Submit.
- [ ] **Skenario 5.3:** Cobalah submit setelah `submission_close_at` berlalu. Sistem harus menolak dengan pesan "Submission deadline has passed".

---

## 6. Pengujian Penilaian (Oleh Judge)
**Tujuan:** Memastikan Juri dapat menilai dengan kriteria yang akurat dan sistem menghitung total secara otomatis.

- [ ] **Skenario 6.1:** Sebagai Admin, tugaskan seorang Judge ke dalam kompetisi (assign judge).
- [ ] **Skenario 6.2:** Login sebagai Judge yang ditugaskan. Masuk ke menu **Assessments**.
- [ ] **Skenario 6.3:** Buka karya peserta yang sudah mengumpulkan file.
- [ ] **Skenario 6.4:** Isi nilai (0-100) untuk setiap kriteria yang ada (misal: Inovasi, Desain, Presentasi). 
- [ ] **Skenario 6.5:** Simpan penilaian. Pastikan skor total dihitung secara proporsional sesuai dengan bobot (weight) masing-masing kriteria.

---

## 7. Pengujian Hasil Akhir & Laporan (Ekspor)
**Tujuan:** Memastikan perhitungan akhir dan ekspor data berjalan lancar.

- [ ] **Skenario 7.1 (Leaderboard):** Sebagai Super Admin, buka halaman hasil akhir kompetisi. Pastikan peserta dengan skor tertinggi otomatis berada di peringkat atas.
- [ ] **Skenario 7.2 (Ekspor Data CSV/Excel):** Di dalam menu Registrations atau Competitions, pilih beberapa data, dan gunakan fitur Export Filament. Pastikan browser langsung mengunduh file `.csv` secara langsung (Direct Stream Download), bukan dilarikan ke background notification.
- [ ] **Skenario 7.3 (Ekspor PDF):** Klik tombol Export PDF pada halaman hasil kompetisi dan pastikan laporannya terbuat dengan rapi.

---

## 8. Pengujian Konversi WebP (Admin Asset)
**Tujuan:** Memastikan optimasi gambar otomatis berjalan.

- [ ] **Skenario 8.1:** Login sebagai Admin, masuk ke menu **Media Partners** atau **Sponsors**.
- [ ] **Skenario 8.2:** Upload logo dalam format `.png` dengan *background transparan* atau ukuran `.jpg` besar.
- [ ] **Skenario 8.3:** Simpan data. Buka halaman utama (Landing Page).
- [ ] **Skenario 8.4:** Klik kanan pada gambar sponsor/logo yang baru diupload -> Pilih "Open image in new tab". Pastikan ekstensi gambar adalah `.webp` dan transparansinya tidak bocor (tidak berubah menjadi background hitam).

---
*Pengujian Selesai.* - **Codename: LenFrogg**
