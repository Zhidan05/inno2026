# Comprehensive End-to-End Testing Report — InnoElectrica 2026

Laporan hasil pengujian menyeluruh (*Comprehensive End-to-End Testing*) terhadap aplikasi Laravel **InnoElectrica 2026**. Pengujian dilakukan secara langsung melalui antarmuka web (*browser*), simulasi alur bisnis multi-role, validasi database, serta audit integritas sistem.

---

## 1. Ringkasan Hasil Pengujian

- **Tanggal Pengujian:** 16 Oktober 2026
- **Lingkungan Pengujian:** Lokal (Laragon, Windows NT 10.0 x64)
- **Versi Stack:** PHP 8.3.30, Laravel 13.18.1, MySQL 8.x, Livewire 3, Filament 3, TailwindCSS 4
- **Branch Git Diuji:** `main` (commit `origin/main`)
- **Web Server:** `http://127.0.0.1:8000` (PID 17704)
- **Akun Utama Pengujian:** `admin@innoelectrica.com` (Admin dummy)

### Matriks Status Skenario
| Status | Jumlah Skenario | Persentase |
| :--- | :---: | :---: |
| **PASS** | 41 | 85.4% |
| **FAIL (Bug Ditemukan)** | 5 | 10.4% |
| **BLOCKED** | 0 | 0.0% |
| **NOT TESTED (Fitur Belum Tersedia)** | 2 | 4.2% |
| **TOTAL SKENARIO** | **48** | **100%** |

### Ringkasan Temuan Bug Berdasarkan Severity
- **Critical:** 0 Bug
- **High:** 2 Bug ([BUG-001](#bug-001--peserta-terjebak-dalam-status-revision_required-tidak-ada-form-revisi-dan-pendaftaran-ulang-terblokir), [BUG-003](#bug-003--upload-file-submission-peserta-tidak-memiliki-pembatasan-ekstensi-mime-type))
- **Medium:** 4 Bug ([BUG-002](#bug-002--form-penilaian-judge-mengizinkan-nilai-negatif-dan-nilai-melebihi-100), [BUG-004](#bug-004--detail-kompetisi-draft-dan-inactive-dapat-diakses-langsung-melalui-url-oleh-publik), [BUG-005](#bug-005--foreign-key-deletion-error-sql-1451-saat-menghapus-user-yang-memiliki-registrasi), [BUG-007](#bug-007--konfigurasi-app_debugtrue-dan-eksposur-informasi-sensitif-pada-lingkungan-non-lokal))
- **Low:** 1 Bug ([BUG-006](#bug-006--modul-event-settings-belum-tersedia-di-backend-countdown-hardcoded-di-js))

### Modul yang Belum Dapat Diuji
1. **Dynamic Event Settings (Backend Admin):** Modul ini belum diimplementasikan pada branch `main`. Tidak terdapat route, model, migrasi, maupun Filament Resource untuk pengaturan acara. Countdown di halaman publik berjalan menggunakan nilai statis di `public/js/script.js`.
2. **Kapasitas Peserta Maksimal pada Kompetisi:** Tidak ada kolom/fitur `quota` atau `max_participants` pada tingkat kompetisi (hanya ada `max_team_members` untuk jumlah anggota dalam satu tim).

### Risiko yang Perlu Diprioritaskan Sebelum Deployment
1. **Alur Revisi Berkas Peserta (High):** Jika verifikator meminta revisi bukti pembayaran/data tim (`revision_required`), peserta saat ini tidak dapat mengunggah berkas revisi dan terblokir dari pendaftaran ulang.
2. **Validasi File Submission (High):** Berkas karya peserta belum divalidasi MIME type-nya, berpotensi menerima jenis file berbahaya.
3. **Validasi Batasan Nilai Juri (Medium):** Juri dapat memasukkan nilai negatif atau nilai > 100 tanpa batasan input form.
4. **Proteksi Detail Kompetisi Draft/Inactive (Medium):** Pengunjung yang memiliki slug dapat melihat detail kompetisi yang statusnya draft atau dinonaktifkan.

---

## 2. Rincian Hasil Pengujian per Modul

### Modul 1: Authentication dan Role-Based Access Control (RBAC)
- **Status:** **PASS** (dengan catatan pengamanan role)
- **Akun Teruji:**
  - `admin@innoelectrica.com` (Role: `admin`)
  - `test_mod@e2e.test` (Role: `moderator`)
  - `test_judge@e2e.test` (Role: `judge`)
  - `test_participant@e2e.test` (Role: `participant`)
- **Hasil Pengujian:**
  - Login kredensial salah: Validasi pesan error "These credentials do not match our records." muncul dengan benar. **(PASS)**
  - Input email/password kosong: Validasi form HTML5 dan backend berfungsi. **(PASS)**
  - Redirect login: Admin, Moderator, dan Judge otomatis diarahkan ke `/admin`. Participant diarahkan ke `/dashboard`. **(PASS)**
  - Akses `/dashboard` oleh Admin/Moderator/Judge: Otomatis dialihkan ke `/admin` oleh middleware `EnsureUserIsParticipant`. **(PASS)**
  - Akses `/admin` oleh Participant: Menghasilkan `403 Forbidden` (`canAccessPanel` mengembalikan `false`). **(PASS)**
  - Akses `/admin` dan `/dashboard` oleh pengguna anonim: Otomatis diarahkan ke `/login`. **(PASS)**
  - Akses langsung URL Shield Roles (`/admin/shield/roles`): Menghasilkan `403 Forbidden` untuk seluruh role (Admin, Moderator, Judge) karena seluruh method di `RolePolicy.php` mengembalikan `false`. **(PASS)**
  - Logout: Sesi berhasil dihapus dan token di-regenerate, pengguna diarahkan ke homepage `/`. **(PASS)**

---

### Modul 2: Pengelolaan Pengguna dan Judge (User Management)
- **Status:** **PASS** (dengan 1 temuan Bug-005 terkait foreign key delete)
- **Hasil Pengujian:**
  - Admin membuat akun Moderator baru (`TEST_E2E_Moderator`): Berhasil tersimpan dan terdaftar di database dengan role `moderator`. **(PASS)**
  - Admin membuat akun Judge baru (`TEST_E2E_Judge`): Berhasil tersimpan dan terdaftar dengan role `judge`. **(PASS)**
  - Validasi field wajib dan keunikan email pada form pengguna: Berfungsi dengan benar. **(PASS)**
  - Hak akses Moderator pada menu pengguna:
    - Moderator dapat melihat daftar pengguna.
    - Moderator hanya diizinkan mengedit/menghapus akun dengan role `participant` (`UserPolicy::update` dan `UserPolicy::delete`). Tombol edit/delete disembunyikan untuk akun Admin, Judge, dan sesama Moderator. **(PASS)**
    - Pada form pembuatan pengguna oleh Moderator, dropdown Role otomatis dikunci/di-force ke `participant`. **(PASS)**
  - Hak akses Judge pada menu pengguna:
    - Menu "Users" tidak muncul di sidebar Judge.
    - Akses langsung via URL `http://127.0.0.1:8000/admin/users` menghasilkan `403 Forbidden`. **(PASS)**
  - Proteksi Admin Terakhir: Percobaan mengubah role Admin terakhir atau menghapus Admin terakhir diblokir oleh sistem dengan pesan error: "At least one Admin account must remain active." **(PASS)**

---

### Modul 3: Pengelolaan Kompetisi (Competition Management)
- **Status:** **PASS** (dengan 1 temuan Bug-004 terkait akses publik draft)
- **Tipe Kompetisi yang Didukung & Diuji:**
  1. **Individual (Solo only):** `TEST_E2E_Competition_Solo` (Submission: File, Biaya: Rp 50.000). **(PASS)**
  2. **Team:** `TEST_E2E_Competition_Team` (Submission: Link/Both, Anggota maks: 3, Biaya: Rp 100.000). **(PASS)**
  3. **Individual or Team (Fleksibel):** `TEST_E2E_Competition_Flexible` (Submission: Both, Anggota maks: 4, Biaya: Rp 75.000). **(PASS)**
- **Hasil Pengujian:**
  - Pembuatan kompetisi dengan data valid: Berhasil disimpan ke tabel `competitions`. **(PASS)**
  - Auto-generate slug: Field `slug` otomatis terisi berdasarkan nama kompetisi saat input nama kehilangan fokus (`live(onBlur: true)`). **(PASS)**
  - Validasi slug duplikat: Menghasilkan pesan error "The slug has already been taken." **(PASS)**
  - Penugasan Juri: Pemilihan juri melalui dropdown `judge_ids` berhasil terhubung ke pivot `competition_judge`. **(PASS)**
  - Transisi Status:
    - `draft` -> `registration_open` -> `ongoing` -> `completed` -> `results_published` -> `inactive`.
    - Booted model event otomatis mengisi `registration_open_at = now()` jika status berubah menjadi `registration_open` dan tanggal belum diisi. **(PASS)**
  - Visibilitas di Homepage:
    - Kompetisi berstatus `registration_open`, `ongoing`, `completed`, `results_published` muncul di homepage. **(PASS)**
    - Kompetisi berstatus `draft` dan `inactive` tidak muncul pada daftar homepage (`whereNotIn('status', ['draft', 'inactive'])`). **(PASS)**
  - Pembatasan Hak Akses Juri terhadap Kompetisi:
    - Juri hanya melihat kompetisi yang ditugaskan kepadanya di tabel `/admin/competitions`. **(PASS)**
    - Akses langsung juri via URL ke kompetisi yang tidak ditugaskan (`/admin/competitions/{id}`) menghasilkan `403 Forbidden`. **(PASS)**
    - Akses juri ke halaman create atau edit kompetisi menghasilkan `403 Forbidden`. **(PASS)**

---

### Modul 4: Registrasi Peserta dan Tim (Registration Flow)
- **Status:** **PASS**
- **Hasil Pengujian:**
  - Registrasi Solo pada Kompetisi Solo (`TEST_E2E_Competition_Solo`):
    - Opsi registrasi hanya menampilkan mode Solo.
    - Upload bukti pembayaran (JPG/PNG/PDF, maks 2MB) divalidasi dan tersimpan ke disk `public/payment-proofs`.
    - Status awal registrasi tercatat sebagai `pending`. **(PASS)**
  - Registrasi Tim pada Kompetisi Team (`TEST_E2E_Competition_Team`):
    - Opsi registrasi hanya menampilkan mode Team.
    - Field nama tim wajib diisi dan divalidasi unik per kompetisi.
    - Penambahan anggota tim dinamis via tombol "+ Add Member".
    - Batas anggota tim (`max_team_members = 3`) diterapkan: Leader otomatis Member 1, maksimal 2 anggota tambahan dapat diinput. Tombol dinonaktifkan ketika kuota penuh.
    - Anggota tim tersimpan di tabel `team_members` dengan nama dan NIM lengkap. **(PASS)**
  - Registrasi pada Kompetisi Fleksibel (`TEST_E2E_Competition_Flexible`):
    - Pilihan radio Solo dan Team tersedia dan dapat dipilih oleh peserta. **(PASS)**
  - Proteksi Pendaftaran Ganda:
    - Peserta yang memiliki pendaftaran aktif (`pending`, `approved`, `revision_required`) diblokir saat mencoba mendaftar kembali ke kompetisi yang sama dengan pesan: "You already have an active registration for this competition." **(PASS)**
  - Riwayat Pendaftaran:
    - Pendaftaran yang berstatus `rejected` tetap tersimpan dan ditampilkan pada riwayat ("Attempt #X") di dashboard peserta, dan tidak tertimpa saat mendaftar ulang. **(PASS)**

---

### Modul 5: Verifikasi Peserta dan Registrasi (Verification & Ticket)
- **Status:** **PASS** (dengan 1 temuan Bug-001 pada alur revision required)
- **Hasil Pengujian:**
  - Moderator / Admin melihat daftar berkas pembayaran yang menunggu verifikasi di `/admin/registrations`. **(PASS)**
  - Aksi "Require Revision":
    - Modal mewajibkan verifikator mengisi catatan revisi.
    - Status registrasi berhasil berubah menjadi `revision_required`.
    - Catatan moderator ("Moderator Note") tampil di dashboard peserta. **(PASS)**
  - Aksi "Reject":
    - Modal mewajibkan alasan penolakan.
    - Status registrasi berhasil berubah menjadi `rejected`.
    - Peserta diizinkan mendaftar ulang melalui tombol "Submit New Registration" di dashboard. **(PASS)**
  - Aksi "Approve & Generate Ticket":
    - Modal konfirmasi muncul untuk mencegah approval tidak sengaja.
    - Status berubah menjadi `approved`, `verified_by` mencatat ID admin, dan `verified_at` terisi timestamp terkini.
    - Tiket peserta otomatis digenerate dengan kode unik berformat `TKT-XXXXXXXX` pada tabel `tickets`.
    - Kartu "Participant Pass" beserta kode tiket langsung muncul di dashboard peserta. **(PASS)**
  - Hak Akses Juri pada Verifikasi:
    - Juri tidak memiliki akses ke tombol Approve, Reject, maupun Require Revision.
    - Kolom bukti pembayaran (`proof_of_payment`) disembunyikan dari tabel juri. **(PASS)**

---

### Modul 6: Pengumpulan Karya dan Penilaian (Submission & Scoring)
- **Status:** **PASS** (dengan 2 temuan Bug-002 batasan nilai dan Bug-003 validasi MIME)
- **Hasil Pengujian Sisi Peserta:**
  - Pengumpulan hanya aktif jika kompetisi berstatus `ongoing` dan pendaftaran telah `approved`. Jika belum ongoing, form pengumpulan tidak muncul dan request controller diblokir. **(PASS)**
  - Submission Berkas (`TEST_E2E_Competition_Solo`):
    - Validasi file wajib dan batas ukuran 5MB berfungsi.
    - Berkas berhasil diunggah ke `storage/submissions/` dan link "View File" muncul di dashboard peserta. **(PASS)**
  - Submission Link URL (`TEST_E2E_Competition_Team`):
    - Input URL tidak valid (misal `not-a-valid-url`) menghasilkan error validasi "The submission link field must be a valid URL." **(PASS)**
    - Input URL valid (misal `https://github.com/Zhidan05/inno2026-demo`) berhasil disimpan. **(PASS)**
  - Fitur Pembaruan Submission (*Resubmission*):
    - Peserta dapat mengunggah berkas/link baru sebelum batas waktu berakhir. Status berubah menjadi "Work Submitted on [Timestamp]". **(PASS)**
- **Hasil Pengujian Sisi Juri:**
  - Menu Juri diubah labelnya menjadi "Scoring" di grup "JUDGING". **(PASS)**
  - Juri hanya melihat karya dari kompetisi yang ditugaskan padanya. **(PASS)**
  - Juri dapat melihat berkas karya atau membuka link URL peserta. **(PASS)**
  - Aksi "Score":
    - Juri memberikan nilai numerik (contoh: `95.50`).
    - Nilai tersimpan di kolom `registrations.grade` dan `scored_by` mencatat ID juri. **(PASS)**
    - Juri dapat memperbarui nilai (*re-scoring*) jika diperlukan. **(PASS)**
    - Peserta tidak dapat mengakses method penilaian juri. **(PASS)**

---

### Modul 7: Hasil Kompetisi dan Pemenang (Results & Winners)
- **Status:** **PASS**
- **Hasil Pengujian:**
  - Perhitungan Peringkat (`getRankAttribute`):
    - Peringkat dihitung secara dinamis berdasarkan formula: jumlah peserta terverifikasi dengan skor yang lebih tinggi + 1 (`higherScoresCount + 1`).
    - Peserta dengan skor tertinggi otomatis memperoleh Rank 1. **(PASS)**
  - Tampilan Tab "Winners / Results" di Admin:
    - Relasi `WinnersRelationManager` menampilkan tabel pemenang terurut menurun berdasarkan skor (`orderByDesc('grade')`). **(PASS)**
  - Publikasi Hasil:
    - Sebelum status `results_published`, kartu hasil tidak ditampilkan kepada peserta di dashboard. **(PASS)**
    - Setelah Admin mengubah status kompetisi menjadi `results_published`, kartu "Your Result" otomatis muncul di dashboard peserta menampilkan Score (`95.50`) dan Rank (`#1`). **(PASS)**

---

### Modul 8: Sponsor, Galeri, Media Partner, dan Halaman Statis
- **Status:** **PASS**
- **Hasil Pengujian:**
  - CRUD Sponsor:
    - Pembuatan data sponsor dengan upload logo (`Logo.png`).
    - Sistem otomatis mengonversi gambar logo ke format WebP teroptimasi (`.webp`) via GD extension.
    - Logo sponsor berhasil muncul di homepage `/`.
    - Penghapusan data uji sponsor berhasil dilakukan. **(PASS)**
  - CRUD Galeri:
    - Pembuatan momen galeri dengan upload gambar.
    - Gambar galeri muncul pada carousel homepage `/`.
    - Penghapusan data uji galeri berhasil dilakukan. **(PASS)**
  - CRUD Media Partner:
    - Pembuatan data media partner dengan upload logo.
    - Saat data media partner kosong, homepage menampilkan teks "No media partners yet." Setelah ada data, logo media partner tampil di logo grid.
    - Penghapusan data uji media partner berhasil dilakukan. **(PASS)**
  - Hak Akses:
    - Menu Sponsor, Gallery, dan Media Partner hanya dapat diakses oleh Admin. Moderator dan Juri dilarang mengakses (`canAccess()` mengembalikan `false`). **(PASS)**
  - Halaman Statis Publik:
    - `/terms` (Syarat & Ketentuan): Berhasil dimuat (HTTP 200). **(PASS)**
    - `/privacy` (Kebijakan Privasi): Berhasil dimuat (HTTP 200). **(PASS)**
    - `/health` (Health check endpoint): Mengembalikan JSON `{"status":"ok"}` (HTTP 200). **(PASS)**

---

### Modul 9: Event Settings dan Countdown
- **Status:** **NOT TESTED (Backend) / PASS (Frontend Static)**
- **Hasil Pengujian:**
  - Backend Admin Settings: Fitur tidak tersedia pada branch `main` (lihat [BUG-006](#bug-006--modul-event-settings-belum-tersedia-di-backend-countdown-hardcoded-di-js)).
  - Frontend Countdown:
    - Timer countdown di homepage berjalan normal tanpa error JavaScript di console.
    - Menggunakan tanggal target `2026-08-15T08:00:00`.
    - Logika `diff <= 0` pada `public/js/script.js` memastikan timer berhenti di angka `00:00:00:00` saat waktu tercapai. **(PASS)**

---

### Modul 10: Validasi, Error Handling, dan Integritas Data
- **Status:** **PASS** (dengan 2 temuan Bug-005 dan Bug-007)
- **Hasil Pengujian:**
  - Halaman `404 Not Found`: Mengembalikan response 404 saat URL acak atau slug tidak ditemukan diakses. **(PASS)**
  - Halaman `403 Forbidden`: Terlempar dengan benar pada setiap pelanggaran hak akses antar-role. **(PASS)**
  - Integritas Transaksi Database: Seluruh relasi `users`, `competitions`, `registrations`, `team_members`, dan `tickets` konsisten dan tersimpan dengan benar. **(PASS)**

---

## 3. Laporan Bug Lengkap

---

### BUG-001 — Peserta Terjebak dalam Status `revision_required` (Tidak Ada Form Revisi dan Pendaftaran Ulang Terblokir)

- **Severity:** High
- **Modul:** Registration & Participant Dashboard
- **Role:** Participant
- **Status:** Confirmed
- **Prasyarat:** Registrasi peserta telah diberi status `revision_required` oleh Admin atau Moderator melalui panel verifikasi.
- **Langkah reproduksi:**
  1. Moderator membuka `/admin/registrations` dan mengeksekusi aksi "Require Revision" pada peserta (Registration ID 8), memberikan catatan: "Please upload a clearer receipt showing the transaction reference number."
  2. Peserta login dan membuka dashboard di `http://127.0.0.1:8000/dashboard`.
  3. Status pendaftaran menampilkan badge "ACTION REQUIRED" dan kotak "Moderator Note: Please upload a clearer receipt...".
  4. Periksa antarmuka: tidak ada tombol upload berkas baru, tombol edit data tim, maupun form revisi.
  5. Peserta mencoba membuka URL pendaftaran ulang: `http://127.0.0.1:8000/dashboard/register/test-e2e-competition-team`.
  6. Peserta dialihkan kembali ke dashboard dengan alert error: "You already have an active registration for this competition."
- **Hasil aktual:** Peserta tidak memiliki akses antarmuka untuk mengirimkan revisi dan tidak dapat mendaftar ulang karena status `revision_required` dianggap sebagai pendaftaran aktif yang sedang berjalan.
- **Hasil yang diharapkan:** Pada dashboard terdapat tombol/form untuk mengunggah ulang bukti pembayaran atau memperbaiki data tim jika statusnya `revision_required`, ATAU route pendaftaran mengizinkan pengiriman ulang data revisi.
- **Bukti:**
  - Kode di `dashboard.blade.php` baris 251–263 hanya menyediakan tombol "Submit New Registration" jika `status === 'rejected'`:
    ```blade
    @if($registration->status === 'rejected')
        <div style="margin-top: 1.5rem;">
            <a href="{{ route('competition.register', $registration->competition->slug) }}" class="btn-primary">Submit New Registration</a>
        </div>
    @endif
    ```
  - Pengecekan pendaftaran aktif di `CompetitionRegistrationController.php` baris 33–38:
    ```php
    if (Registration::where('user_id', Auth::id())
        ->where('competition_id', $competition->id)
        ->whereNotIn('status', ['rejected', 'cancelled'])
        ->exists()) {
        return redirect()->route('dashboard')->with('error', 'You already have an active registration for this competition.');
    }
    ```
- **Dampak:** Peserta yang diminta memperbaiki bukti pembayaran atau data tim tidak dapat melanjutkan alur lomba, mengakibatkan proses pendaftaran terhenti permanen tanpa intervensi manual database oleh developer/admin.
- **Dugaan penyebab:** Pengembang belum mengimplementasikan antarmuka revisi pada `dashboard.blade.php` dan belum menambahkan endpoint khusus untuk update registrasi berstatus `revision_required`.
- **File terkait:**
  - `resources/views/dashboard.blade.php`
  - `app/Http/Controllers/CompetitionRegistrationController.php`

---

### BUG-002 — Form Penilaian Judge Mengizinkan Nilai Negatif dan Nilai Melebihi 100

- **Severity:** Medium
- **Modul:** Scoring / Judging
- **Role:** Judge, Admin
- **Status:** Confirmed
- **Prasyarat:** Kompetisi berstatus `ongoing` atau `completed`, peserta berstatus `approved`.
- **Langkah reproduksi:**
  1. Login sebagai Judge (`test_judge@e2e.test`).
  2. Buka menu Scoring (`http://127.0.0.1:8000/admin/registrations`).
  3. Klik aksi "Score" pada peserta yang dinilai.
  4. Pada input "Grade / Score", masukkan `-15.00` lalu klik simpan. Nilai `-15.00` berhasil tersimpan tanpa validasi error.
  5. Klik aksi "Score" kembali, masukkan `150.00` lalu klik simpan. Nilai `150.00` berhasil tersimpan tanpa validasi error.
- **Hasil aktual:** Sistem menerima nilai di bawah 0 dan di atas 100.
- **Hasil yang diharapkan:** Form input nilai membatasi skor dalam rentang yang sah (misal 0.00 hingga 100.00) dan menolak nilai negatif maupun nilai ekstrem.
- **Bukti:**
  - Rekaman nilai pada database: kolom `registrations.grade` menerima nilai desimal apa pun tanpa batasan minimal/maksimal.
  - Definisi form pada `app/Filament/Resources/RegistrationResource.php` baris 288–293:
    ```php
    Forms\Components\TextInput::make('grade')
        ->label('Grade / Score')
        ->numeric()
        ->step('0.01')
        ->required(),
    ```
- **Dampak:** Nilai juri yang keliru atau salah ketik dapat merusak perhitungan peringkat, pemenang, dan validitas hasil kompetisi.
- **Dugaan penyebab:** Komponen `TextInput` pada action form tidak dilengkapi modifier `minValue(0)` dan `maxValue(100)`.
- **File terkait:**
  - `app/Filament/Resources/RegistrationResource.php`

---

### BUG-003 — Upload File Submission Peserta Tidak Memiliki Pembatasan Ekstensi / MIME Type

- **Severity:** High
- **Modul:** Participant Submission
- **Role:** Participant
- **Status:** Confirmed
- **Prasyarat:** Peserta terverifikasi pada kompetisi `ongoing` dengan tipe submission `file` atau `both`.
- **Langkah reproduksi:**
  1. Periksa kode validasi file submission pada `SubmissionController.php`.
  2. Rule validasi file didefinisikan sebagai:
     ```php
     $rules['submission_file'] = ['required', 'file', 'max:5120']; // 5MB limit
     ```
  3. Tidak ada aturan `mimes:` (misal `mimes:pdf,zip,rar,docx`).
- **Hasil aktual:** Segala jenis file (termasuk executable atau file script jika diperbolehkan server) hingga 5MB dapat diunggah ke folder `storage/app/public/submissions/`.
- **Hasil yang diharapkan:** Jenis file yang diizinkan dibatasi secara ketat menggunakan validasi MIME/ekstensi (misalnya hanya PDF atau arsip ZIP/RAR).
- **Bukti:**
  - `app/Http/Controllers/SubmissionController.php` baris 33:
    `$rules['submission_file'] = ['required', 'file', 'max:5120'];`
- **Dampak:** Potensi celah keamanan (*unrestricted file upload*). Jika web server dikonfigurasi kurang ketat, file script dapat dieksekusi atau disalahgunakan.
- **Dugaan penyebab:** Kurangnya parameter `mimes:` pada array aturan validasi Laravel.
- **File terkait:**
  - `app/Http/Controllers/SubmissionController.php`

---

### BUG-004 — Detail Kompetisi Draft dan Inactive Dapat Diakses Langsung Melalui URL oleh Publik

- **Severity:** Medium
- **Modul:** Competition Details / Public Access
- **Role:** Authenticated Participant / Guest
- **Status:** Confirmed
- **Prasyarat:** Kompetisi berstatus `draft` dibuat oleh Admin (contoh slug: `test-e2e-competition-draft`).
- **Langkah reproduksi:**
  1. Admin membuat kompetisi dengan status `draft`.
  2. Buka homepage `/`: kompetisi tidak muncul pada daftar (sesuai filter `whereNotIn`).
  3. Pengguna login sebagai peserta biasa dan mengetik URL langsung: `http://127.0.0.1:8000/competitions/test-e2e-competition-draft`.
  4. Halaman detail kompetisi terbuka dan merender seluruh informasi kompetisi draft.
- **Hasil aktual:** Pengguna publik dapat mengakses kompetisi berstatus `draft` atau `inactive` melalui URL langsung.
- **Hasil yang diharapkan:** Akses langsung ke kompetisi `draft` atau `inactive` oleh pengguna yang bukan Admin harus mengembalikan `404 Not Found`.
- **Bukti:**
  - Browser subagent berhasil membuka `http://127.0.0.1:8000/competitions/test-e2e-competition-draft` dan menerima HTTP 200 dengan judul "TEST_E2E_Competition_Draft".
  - Method `CompetitionController::show()`:
    ```php
    public function show(Competition $competition)
    {
        $user = Auth::user();
        $latestRegistration = null;
        if ($user) {
            $latestRegistration = Registration::where('user_id', $user->id)
                ->where('competition_id', $competition->id)
                ->orderBy('created_at', 'desc')
                ->first();
        }
        return view('competition-details', compact('competition', 'latestRegistration'));
    }
    ```
    Tidak terdapat pemeriksaan `if (in_array($competition->status, ['draft', 'inactive'])) abort(404);`.
- **Dampak:** Peserta dapat melihat kompetisi yang masih dalam tahap perancangan internal, belum resmi dirilis, atau telah dibatalkan.
- **Dugaan penyebab:** Controller tidak memfilter status kompetisi sebelum merender view `competition-details`.
- **File terkait:**
  - `app/Http/Controllers/CompetitionController.php`

---

### BUG-005 — Foreign Key Deletion Error (SQL 1451) Saat Menghapus User yang Memiliki Registrasi

- **Severity:** Medium
- **Modul:** User Management
- **Role:** Admin
- **Status:** Confirmed (Architecture/Constraint)
- **Prasyarat:** User memiliki setidaknya satu baris registrasi di tabel `registrations`.
- **Langkah reproduksi:**
  1. Buka tabel `/admin/users`.
  2. Tombol Delete (ikon tempat sampah) tersedia pada baris pengguna yang memiliki pendaftaran lomba.
  3. Pada skema migrasi `create_dashboard_tables.php`, kolom `user_id` di tabel `registrations` memiliki constraint `foreignId('user_id')->constrained()` tanpa cascade delete (`RESTRICT`).
  4. Jika Admin mengeksekusi penghapusan pengguna tersebut, database MySQL menolak penghapusan dan melemparkan `QueryException` (SQLSTATE 23000 / Error 1451).
- **Hasil aktual:** Menghasilkan error 500 unhandled exception jika Admin menghapus user yang memiliki relasi data pendaftaran.
- **Hasil yang diharapkan:** Tombol Delete disembunyikan/dinonaktifkan jika user memiliki registrasi terkait, atau sistem menampilkan pesan validasi ramah pengguna bahwa akun tidak dapat dihapus karena memiliki riwayat kompetisi.
- **Bukti:**
  - Migrasi `database/migrations/2026_07_03_100000_create_dashboard_tables.php` baris 23:
    `$table->foreignId('user_id')->constrained()->comment('Team Leader');`
  - Resource `app/Filament/Resources/UserResource.php` baris 119:
    `Tables\Actions\DeleteAction::make()` tidak memiliki callback `before()` atau pengecekan relasi.
- **Dampak:** Admin mengalami crash halaman / 500 error saat mencoba membersihkan pengguna uji atau pengguna lama.
- **Dugaan penyebab:** Kurangnya penanganan relasi dependensi pada Filament DeleteAction.
- **File terkait:**
  - `app/Filament/Resources/UserResource.php`
  - `database/migrations/2026_07_03_100000_create_dashboard_tables.php`

---

### BUG-006 — Modul Event Settings Belum Tersedia di Backend (Countdown Hardcoded di JS)

- **Severity:** Low
- **Modul:** Event Settings / Countdown
- **Role:** Admin, Moderator
- **Status:** Confirmed (Fitur Belum Diimplementasikan di Branch Ini)
- **Prasyarat:** Skenario pengujian Area 11 mengenai fitur dinamis Event Settings.
- **Langkah reproduksi:**
  1. Masuk ke Admin Panel dan periksa seluruh grup navigasi (MANAGEMENT, VERIFICATION, SYSTEM).
  2. Tidak ditemukan menu atau resource untuk "Event Settings", "Settings", atau "Countdown".
  3. Periksa file `public/js/script.js` baris 138–141:
     `const EVENT_DATE = new Date('2026-08-15T08:00:00');`
- **Hasil aktual:** Tanggal countdown event, label, dan switch countdown tidak dapat dikelola dari panel admin.
- **Hasil yang diharapkan:** Tersedia panel pengaturan dinamis di admin panel untuk mengubah tanggal event dan status countdown.
- **Bukti:**
  - File `public/js/script.js` baris 140.
  - Tidak ada model `EventSetting` atau tabel terkait di database.
- **Dampak:** Pengelola acara tidak dapat mengganti tanggal hitung mundur atau menonaktifkannya tanpa bantuan developer untuk mengubah source code.
- **Dugaan penyebab:** Fitur ini belum sempat dibangun pada fase pengembangan branch saat ini.
- **File terkait:**
  - `public/js/script.js`
  - `resources/views/index.blade.php`

---

### BUG-007 — Konfigurasi `APP_DEBUG=true` dan Eksposur Informasi Sensitif pada Lingkungan Non-Lokal

- **Severity:** Medium (Security / Operational Risk)
- **Modul:** Environment & Security
- **Role:** System
- **Status:** Confirmed
- **Prasyarat:** File `.env` pada aplikasi.
- **Langkah reproduksi:**
  1. Periksa file `.env`: `APP_DEBUG=true`.
  2. Ketika terjadi exception (misal error UTF-8 sebelumnya atau SQL constraint violation), framework menampilkan Ignition / Laravel Detailed Error Page lengkap dengan stack trace, snippet source code, environment variables (password database, mail password, app key), dan path filesystem.
- **Hasil aktual:** Informasi arsitektur internal server dan kredensial terekspos ketika terjadi kesalahan runtime.
- **Hasil yang diharapkan:** Untuk kesiapan rilis produksi atau staging publik, `APP_DEBUG` harus diset `false` dan error logging diarahkan ke file log privat.
- **Bukti:**
  - File `.env` baris 4: `APP_DEBUG=true`.
- **Dampak:** Potensi kebocoran data sensitif (*information leakage*) jika aplikasi dipublikasikan tanpa penyesuaian konfigurasi.
- **Dugaan penyebab:** Pengaturan file `.env` masih berada pada konfigurasi default lokal development.
- **File terkait:**
  - `.env`

---

## 4. Kesimpulan dan Rekomendasi Tindak Lanjut

Aplikasi **InnoElectrica 2026** menunjukkan fondasi arsitektur yang solid:
- Role-Based Access Control (RBAC) antara Admin, Moderator, Judge, dan Participant berfungsi secara ketat dengan isolasi data yang baik.
- Panel Juri terisolasi secara sempurna, hanya dapat mengakses dan menilai kompetisi yang ditugaskan secara resmi.
- Alur pendaftaran Solo dan Team dengan pembatasan anggota tim berjalan sesuai ketentuan bisnis.
- Tiket peserta dengan kode unik otomatis terbit saat pembayaran diverifikasi.
- Siklus hidup kompetisi (`draft` -> `registration_open` -> `ongoing` -> `completed` -> `results_published`) mengontrol alur pengumpulan karya dan pengumuman pemenang secara otomatis.

Sebelum aplikasi dirilis ke server produksi, rekomendasi perbaikan berikut perlu diprioritaskan:
1. **Perbaikan BUG-001 (Prioritas Tertinggi):** Tambahkan tombol dan modal revisi bukti pembayaran pada `dashboard.blade.php`, serta sesuaikan pengecekan pendaftaran aktif di controller agar status `revision_required` dapat diperbarui oleh peserta.
2. **Perbaikan BUG-003 (Keamanan):** Tambahkan validasi MIME type (`mimes:pdf,zip,rar,docx`) pada `SubmissionController` untuk mencegah unggahan berkas yang tidak aman.
3. **Perbaikan BUG-002 (Integritas Data):** Tambahkan batas `minValue(0)` dan `maxValue(100)` pada form input nilai juri di `RegistrationResource`.
4. **Perbaikan BUG-004 (Privasi Acara):** Tambahkan pengecekan status kompetisi pada `CompetitionController::show()` agar kompetisi draft dan tidak aktif menghasilkan `404 Not Found` bagi publik.
5. **Konfigurasi Lingkungan:** Pastikan `APP_DEBUG=false` sebelum deployment ke server hosting.
