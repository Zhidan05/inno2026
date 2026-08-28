# InnoElectrica 2026 --- Project Objectives & Implementation Checklist

Dokumen ini menjadi acuan objective pengembangan aplikasi InnoElectrica
2026. Setiap item memiliki checkbox agar coding agent dapat menandai
objective yang sudah selesai dikerjakan.

> Aturan pengisian: ubah `[x]` menjadi `[x]` hanya setelah fitur
> benar-benar diimplementasikan dan berfungsi.

------------------------------------------------------------------------

## 1. Role & Hak Akses

### 1.1 Super Admin

-   [x] Membuat role `super_admin` sebagai role dengan akses penuh ke
    panel admin.
-   [x] Super Admin dapat mengelola kompetisi.
-   [x] Super Admin dapat melihat dan mengelola seluruh data peserta dan
    pendaftaran.
-   [x] Super Admin dapat melakukan atau mengubah verifikasi pendaftaran
    bila diperlukan.
-   [x] Super Admin dapat mengelola judge.
-   [x] Super Admin dapat mengelola penilaian dan hasil kompetisi.
-   [x] Super Admin dapat mengelola galeri.
-   [x] Super Admin dapat mengelola sponsor.
-   [x] Super Admin dapat mengelola media partner.
-   [x] Super Admin dapat melakukan export data ke PDF dan Excel sesuai
    resource yang tersedia.
-   [x] Super Admin dapat mengakses seluruh menu admin.

### 1.2 Moderator

-   [x] Membuat role statis `moderator`.
-   [x] Moderator dapat melihat data pendaftaran kompetisi.
-   [x] Moderator dapat melihat data peserta dan anggota tim.
-   [x] Moderator dapat melihat bukti pembayaran.
-   [x] Moderator dapat memverifikasi pendaftaran.
-   [x] Moderator dapat menyetujui pendaftaran.
-   [x] Moderator dapat menolak pendaftaran.
-   [x] Moderator dapat meminta revisi dan memberikan catatan.
-   [x] Moderator tidak dapat mengelola role.
-   [x] Moderator tidak dapat mengelola user.
-   [x] Moderator tidak dapat mengelola konfigurasi kompetisi.
-   [x] Moderator tidak dapat memberikan atau mengubah nilai.
-   [x] Moderator tidak dapat mengakses fitur yang hanya ditujukan untuk
    Super Admin.

### 1.3 Judge

-   [x] Menambahkan role statis `judge`.
-   [x] Judge dapat melihat kompetisi yang ditugaskan kepadanya.
-   [x] Judge dapat melihat submission peserta untuk kompetisi yang
    ditugaskan.
-   [x] Judge dapat memberikan nilai sesuai mekanisme kompetisi.
-   [x] Judge dapat mengubah nilai sebelum hasil dikunci atau
    dipublikasikan, sesuai aturan sistem.
-   [x] Judge tidak dapat memverifikasi pembayaran.
-   [x] Judge tidak dapat mengelola user atau role.
-   [x] Judge tidak dapat mengubah konfigurasi kompetisi.
-   [x] Judge tidak dapat mengakses submission kompetisi yang tidak
    ditugaskan kepadanya.
-   [x] Ranking akhir tetap dihitung otomatis oleh sistem berdasarkan
    nilai, bukan diinput manual oleh judge.

### 1.4 Participant

-   [x] Membuat role statis `participant`.
-   [x] Participant dapat membuat akun melalui halaman register.
-   [x] Participant otomatis mendapatkan role `participant` setelah
    registrasi akun.
-   [x] Participant dapat login ke dashboard peserta.
-   [x] Participant dapat melihat kompetisi yang tersedia.
-   [x] Participant dapat mendaftar ke kompetisi yang dibuka.
-   [x] Participant dapat mengelola data pendaftaran yang masih
    diizinkan untuk diubah.
-   [x] Participant dapat mengirim submission saat periode kompetisi
    berlangsung.
-   [x] Participant dapat melihat status verifikasi.
-   [x] Participant dapat melihat ticket setelah pendaftaran disetujui.
-   [x] Participant dapat melihat nilai dan ranking setelah hasil
    dipublikasikan.
-   [x] Participant tidak dapat mengakses panel `/admin`.

------------------------------------------------------------------------

## 2. Role Statis

-   [x] Menghapus atau menonaktifkan form/menu untuk menambah role baru.
-   [x] Menghapus kemampuan CRUD role dari panel admin jika tidak
    diperlukan.
-   [x] Role yang digunakan sistem bersifat statis:
    -   [x] `super_admin`
    -   [x] `moderator`
    -   [x] `judge`
    -   [x] `participant`
-   [x] Role dapat dibuat melalui seeder atau konfigurasi sistem.
-   [x] Jika perubahan assignment role tetap diperlukan, hanya Super
    Admin yang dapat melakukannya.
-   [x] Tidak ada user yang dapat menentukan role melalui form register
    publik.

------------------------------------------------------------------------

## 3. Super Admin Seed

-   [x] Membuat seeder untuk menghasilkan 1 akun Super Admin awal.
-   [x] Seeder menggunakan email dan password yang dapat dikonfigurasi
    melalui environment variable atau konfigurasi aman.
-   [x] Password tidak ditulis sebagai plain text di database.
-   [x] Akun Super Admin awal otomatis memiliki role `super_admin`.
-   [x] Seeder tidak membuat duplikasi akun ketika dijalankan lebih dari
    sekali.
-   [x] Kredensial default tidak ditampilkan di UI aplikasi.

------------------------------------------------------------------------

## 4. Alur Pendaftaran & Kompetisi

### 4.1 Registrasi Akun

-   [x] Peserta membuat akun terlebih dahulu.
-   [x] Form register minimal berisi nama, email, password, dan
    konfirmasi password.
-   [x] Semua field wajib diberi tanda `*` yang jelas pada label.
-   [x] Tanda `*` konsisten pada seluruh field yang wajib diisi.
-   [x] Validasi wajib dilakukan di backend.
-   [x] User yang berhasil register otomatis memiliki role
    `participant`.

### 4.2 Memilih Kompetisi

-   [x] Participant dapat melihat daftar kompetisi yang tersedia.
-   [x] Hanya kompetisi dengan status pendaftaran terbuka yang dapat
    didaftarkan.
-   [x] Sistem memvalidasi waktu buka dan tutup pendaftaran di backend.
-   [x] Detail kompetisi menampilkan aturan pendaftaran dan kebutuhan
    submission jika tersedia.

### 4.3 Pendaftaran Kompetisi

-   [x] Participant memilih kompetisi.
-   [x] Participant memilih mode solo atau tim jika kompetisi
    mengizinkan keduanya.
-   [x] Sistem mengikuti konfigurasi kompetisi: individual, team, atau
    individual_or_team.
-   [x] Untuk tim, participant mengisi nama tim.
-   [x] Jumlah anggota mengikuti batas maksimal yang ditentukan admin.
-   [x] Account owner / team leader dihitung sebagai satu anggota.
-   [x] Anggota tambahan tidak wajib memiliki akun.
-   [x] Data anggota tambahan minimal berisi nama dan NIM.
-   [x] Nama tim unik dalam kompetisi yang sama.
-   [x] Participant mengunggah bukti pembayaran.
-   [x] Format bukti pembayaran yang didukung: PDF, JPG, JPEG, PNG.
-   [x] Ukuran maksimal bukti pembayaran: 2 MB.
-   [x] Validasi tipe dan ukuran file dilakukan di backend.

### 4.4 Verifikasi Pendaftaran

-   [x] Pendaftaran baru memiliki status `pending`.
-   [x] Moderator dapat memeriksa data pendaftaran.
-   [x] Moderator dapat melihat bukti pembayaran.
-   [x] Moderator dapat memilih status `verified`, `revision_required`,
    atau `rejected`.
-   [x] Moderator dapat memberikan catatan verifikasi.
-   [x] Participant dapat melihat status dan catatan verifikasi.
-   [x] Setelah status `verified`, ticket hanya dibuat satu kali dan
    tidak duplikat.
-   [x] Ticket memiliki identifier unik dan QR code yang aman.

### 4.5 Waktu Kompetisi & Submission

-   [x] Admin dapat menentukan waktu mulai dan berakhir kompetisi.
-   [x] Participant hanya dapat mengirim submission sesuai periode yang
    ditentukan.
-   [x] Sistem mendukung kebutuhan submission yang dapat dikonfigurasi
    per kompetisi.
-   [x] Admin dapat menentukan jenis submission yang diperlukan: file,
    link, atau keduanya.
-   [x] Jika submission file diaktifkan, validasi format dan ukuran file
    mengikuti konfigurasi kompetisi.
-   [x] Jika submission link diaktifkan, sistem memvalidasi format URL.
-   [x] Participant dapat melihat status submission.
-   [x] Participant dapat memperbarui submission selama periode
    pengumpulan masih terbuka, jika aturan kompetisi mengizinkan.
-   [x] Sistem menyimpan waktu submission untuk audit.

### 4.6 Penilaian oleh Judge

-   [x] Super Admin dapat menetapkan judge ke kompetisi tertentu.
-   [x] Judge hanya melihat submission dari kompetisi yang ditugaskan.
-   [x] Judge dapat memberikan nilai numerik.
-   [x] Sistem menyimpan judge yang memberikan atau terakhir mengubah
    nilai.
-   [x] Sistem menghitung ranking secara otomatis.
-   [x] Ranking dihitung terpisah untuk setiap kompetisi.
-   [x] Skor lebih tinggi menghasilkan ranking lebih baik.
-   [x] Sistem menangani nilai yang sama secara konsisten.
-   [x] Hasil hanya terlihat oleh participant setelah Super Admin
    mempublikasikan hasil.

------------------------------------------------------------------------

## 5. Dashboard

### 5.1 Dashboard Admin

-   [x] Dashboard menampilkan statistik yang relevan.
-   [x] Total Users ditampilkan.
-   [x] Total Participants ditampilkan.
-   [x] Total Competition Registrations ditampilkan.
-   [x] Pending Verifications ditampilkan.
-   [x] Verified Registrations ditampilkan.
-   [x] Recent Registrations ditampilkan.
-   [x] Dashboard berbeda sesuai hak akses role.
-   [x] Moderator hanya melihat informasi yang relevan dengan
    verifikasi.
-   [x] Judge hanya melihat kompetisi dan pekerjaan penilaian yang
    ditugaskan.

### 5.2 Dashboard Participant

-   [x] Tampilan dashboard participant mengikuti bahasa desain dan
    struktur visual dashboard admin.
-   [x] Dashboard participant tidak lagi berupa tampilan generik yang
    kosong.
-   [x] Desain tetap mobile-first.
-   [x] Menampilkan status pendaftaran kompetisi.
-   [x] Menampilkan aksi yang perlu dilakukan participant.
-   [x] Menampilkan ticket setelah verifikasi berhasil.
-   [x] Menampilkan countdown atau status waktu kompetisi.
-   [x] Menampilkan status submission saat periode kompetisi.
-   [x] Menampilkan nilai dan ranking setelah hasil dipublikasikan.
-   [x] Mendukung participant yang mengikuti lebih dari satu kompetisi.

### 5.3 Login & Register

-   [x] Halaman login mengikuti UI dan visual language halaman register.
-   [x] Halaman register dan login memiliki konsistensi spacing, card,
    input, tombol, warna, dan responsivitas.
-   [x] Semua field wajib pada register memiliki tanda `*`.
-   [x] Tanda wajib tidak hanya bergantung pada placeholder.
-   [x] Error validasi ditampilkan dengan jelas.
-   [x] Form nyaman digunakan di mobile.

------------------------------------------------------------------------

## 6. Users & Participants Management

### 6.1 Users

-   [x] Membuat menu/resource Users.
-   [x] Menampilkan seluruh user dalam sistem.
-   [x] Menampilkan nama.
-   [x] Menampilkan email.
-   [x] Menampilkan role.
-   [x] Menampilkan jumlah pendaftaran kompetisi.
-   [x] Menampilkan tanggal akun dibuat.
-   [x] Mendukung search, sorting, dan filter role.
-   [x] Hanya Super Admin yang dapat mengelola user dan assignment role.

### 6.2 Participants

-   [x] Membuat menu/resource Participants.
-   [x] Resource berbasis Competition Registration agar satu participant
    dapat muncul pada setiap kompetisi yang diikutinya.
-   [x] Menampilkan participant.
-   [x] Menampilkan kompetisi.
-   [x] Menampilkan mode solo atau team.
-   [x] Menampilkan nama tim.
-   [x] Menampilkan total anggota.
-   [x] Menampilkan status pendaftaran.
-   [x] Menampilkan status bukti pembayaran.
-   [x] Menampilkan ticket.
-   [x] Menampilkan score dan rank jika tersedia.
-   [x] Mendukung filter kompetisi.
-   [x] Mendukung filter status pendaftaran.
-   [x] Mendukung pencarian berdasarkan nama participant, email, nama
    tim, nama anggota, dan NIM anggota.

------------------------------------------------------------------------

## 7. Export PDF & Excel

-   [x] Menambahkan fitur export data ke Excel.
-   [x] Menambahkan fitur export data ke PDF.
-   [x] Export tersedia pada resource yang membutuhkan laporan, minimal
    Participants dan Verifications.
-   [x] Export mengikuti filter yang sedang aktif jika memungkinkan.
-   [x] Export Excel menggunakan format kolom yang rapi dan mudah
    diolah.
-   [x] Export PDF memiliki heading, tanggal export, dan tabel yang
    mudah dibaca.
-   [x] Data sensitif tidak ikut diexport tanpa otorisasi.
-   [x] Export hanya dapat dilakukan oleh role yang berwenang.

------------------------------------------------------------------------

## 8. Gallery Management

-   [x] Menambahkan menu/panel Gallery di admin.
-   [x] Super Admin dapat menambah item galeri.
-   [x] Admin dapat mengedit item galeri.
-   [x] Admin dapat menghapus item galeri.
-   [x] Setiap item dapat memiliki gambar.
-   [x] Setiap item dapat memiliki judul atau caption.
-   [x] Mendukung pengaturan urutan tampilan jika diperlukan.
-   [x] Gallery publik menggunakan data dari database, bukan dummy data.

------------------------------------------------------------------------

## 9. Sponsor Management

-   [x] Menambahkan menu/panel Sponsors di admin.
-   [x] Super Admin dapat menambah sponsor.
-   [x] Admin dapat mengedit sponsor.
-   [x] Admin dapat menghapus sponsor.
-   [x] Sponsor dapat memiliki nama.
-   [x] Sponsor dapat memiliki logo.
-   [x] Sponsor dapat memiliki link website atau URL opsional.
-   [x] Mendukung urutan tampilan.
-   [x] Data sponsor publik berasal dari database.

------------------------------------------------------------------------

## 10. Media Partner Management

-   [x] Menambahkan menu/panel Media Partners di admin.
-   [x] Super Admin dapat menambah media partner.
-   [x] Admin dapat mengedit media partner.
-   [x] Admin dapat menghapus media partner.
-   [x] Media partner dapat memiliki nama.
-   [x] Media partner dapat memiliki logo.
-   [x] Media partner dapat memiliki link opsional.
-   [x] Mendukung urutan tampilan.
-   [x] Data media partner publik berasal dari database.

------------------------------------------------------------------------

## 11. Static Public Information

Bagian berikut tidak memerlukan panel CRUD admin dan dapat di-hardcode
pada aplikasi.

### 11.1 Organizer

-   [x] Organizer ditampilkan sebagai:
    `IEEE Student Branch Universitas Riau`.
-   [x] Informasi organizer digunakan secara konsisten pada halaman
    Contact dan bagian terkait.

### 11.2 Contact

-   [x] Informasi Contact dibuat statis/hardcode.
-   [x] Tidak dibuat panel admin untuk mengubah Contact.
-   [x] Informasi Contact ditampilkan konsisten pada halaman publik.

### 11.3 Location

-   [x] Informasi Location dibuat statis/hardcode.
-   [x] Tidak dibuat panel admin untuk mengubah Location.
-   [x] Informasi Location ditampilkan pada halaman publik yang relevan.

------------------------------------------------------------------------

## 12. Authorization & Security

-   [x] Akses menu bukan satu-satunya mekanisme keamanan.
-   [x] Authorization diterapkan di backend menggunakan policy,
    middleware, permission, atau mekanisme yang sesuai.
-   [x] Participant tidak dapat mengakses `/admin`.
-   [x] Moderator tidak dapat mengakses manajemen user dan role.
-   [x] Judge tidak dapat mengakses data kompetisi di luar assignment.
-   [x] Judge tidak dapat mengakses verifikasi pembayaran.
-   [x] Role tidak dapat dimanipulasi melalui request publik.
-   [x] Upload file divalidasi di backend.
-   [x] Deadline pendaftaran dan submission divalidasi di backend.
-   [x] Sistem menghindari N+1 query pada tabel admin utama.

------------------------------------------------------------------------

## 13. Final Review

-   [x] Seluruh role statis berfungsi sesuai objective.
-   [x] Alur register akun dan daftar kompetisi terpisah dengan jelas.
-   [x] Verifikasi dilakukan pada pendaftaran kompetisi, bukan akun
    user.
-   [x] Submission hanya tersedia sesuai waktu dan konfigurasi
    kompetisi.
-   [x] Judge hanya dapat menilai kompetisi yang ditugaskan.
-   [x] Ranking dihitung otomatis.
-   [x] Hasil tidak terlihat sebelum dipublikasikan.
-   [x] Export PDF berfungsi.
-   [x] Export Excel berfungsi.
-   [x] Dashboard participant konsisten dengan dashboard admin.
-   [x] Login konsisten dengan UI register.
-   [x] Field wajib pada register memiliki tanda `*`.
-   [x] Seeder menghasilkan satu Super Admin awal tanpa duplikasi.
-   [x] Gallery management berfungsi.
-   [x] Sponsor management berfungsi.
-   [x] Media Partner management berfungsi.
-   [x] Contact, Organizer, dan Location menggunakan konfigurasi statis
    sesuai objective.
-   [x] Seluruh fitur diuji menggunakan data nyata, bukan hanya dummy
    UI.
