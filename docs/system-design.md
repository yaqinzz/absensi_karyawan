# Sistem Penggajian & Absensi Karyawan

Dokumen ini merangkum struktur folder, ERD, flow sistem, endpoint API, dummy data, dan best practice keamanan.

## Struktur Folder (ringkas)
- app/Http/Controllers: controller untuk web dan API
- app/Models: model Eloquent
- app/Domain: entity dan aturan bisnis inti
- app/Application: use case, service, dan orchestrator
- app/Infrastructure: repository, integrasi eksternal, dan implementasi storage
- database/migrations: skema database
- database/seeders: data dummy
- resources/views: UI Blade + Tailwind
- routes: rute web dan API
- docs: dokumentasi proyek

## ERD (Mermaid)
```mermaid
erDiagram
    users ||--o| employees : "has"
    divisions ||--o| employees : "has"
    positions ||--o| employees : "has"
    employees ||--o| attendances : "has"
    employees ||--o| payrolls : "has"
    payroll_runs ||--o| payrolls : "has"
    payrolls ||--o| payroll_items : "has"
    salary_components ||--o| payroll_items : "has"
    employees ||--o| employee_salary_components : "has"
    salary_components ||--o| employee_salary_components : "has"
    users ||--o| payroll_runs : "created_by"

    users {
      bigint id
      string name
      string email
      string password
      boolean is_active
    }
    employees {
      bigint id
      bigint user_id
      bigint division_id
      bigint position_id
      string nik
      string name
      date join_date
      string status
      decimal base_salary
    }
    divisions {
      bigint id
      string code
      string name
      boolean is_active
    }
    positions {
      bigint id
      string code
      string name
      int level
      boolean is_active
    }
    attendances {
      bigint id
      bigint employee_id
      date work_date
      datetime check_in_at
      datetime check_out_at
      string status
      int late_minutes
    }
    salary_components {
      bigint id
      string code
      string name
      string type
      boolean is_fixed
      decimal default_amount
      boolean is_active
    }
    employee_salary_components {
      bigint id
      bigint employee_id
      bigint salary_component_id
      decimal amount
      boolean is_active
    }
    payroll_runs {
      bigint id
      date period_start
      date period_end
      date pay_date
      string status
      bigint created_by
    }
    payrolls {
      bigint id
      bigint payroll_run_id
      bigint employee_id
      decimal base_salary
      decimal total_earnings
      decimal total_deductions
      decimal net_pay
    }
    payroll_items {
      bigint id
      bigint payroll_id
      bigint salary_component_id
      string name
      string type
      decimal amount
    }
```

## Flow Sistem
### Absensi
1. Karyawan login dan membuka halaman absensi.
2. Sistem cek status absensi hari ini.
3. Absen masuk/pulang disimpan otomatis dengan waktu server.
4. Sistem hitung keterlambatan berdasarkan jam kerja.
5. HRD melihat rekap absensi bulanan dan status kehadiran.

### Penggajian
1. HRD pilih periode gaji.
2. Sistem tarik data karyawan, komponen gaji, dan absensi.
3. Hitung pendapatan dan potongan otomatis.
4. HRD review dan finalisasi payroll.
5. Slip gaji dibuat dan dapat diunduh karyawan.

## Sequence Flow (Mermaid)
### Absensi
```mermaid
sequenceDiagram
    participant K as Karyawan
    participant W as Web App
    participant DB as Database

    K->>W: Absen masuk
    W->>DB: Cek absensi hari ini
    DB-->>W: Belum ada
    W->>DB: Simpan check_in_at
    DB-->>W: OK
    W-->>K: Notifikasi sukses
```

### Penggajian
```mermaid
sequenceDiagram
    participant H as HRD
    participant W as Web App
    participant DB as Database

    H->>W: Proses payroll periode
    W->>DB: Ambil karyawan, absensi, komponen gaji
    DB-->>W: Data payroll
    W->>W: Hitung gaji otomatis
    W->>DB: Simpan payroll dan item
    DB-->>W: OK
    W-->>H: Payroll siap finalisasi
```

## Endpoint API (v1)
- Auth
  - POST /api/v1/auth/login
  - POST /api/v1/auth/logout
- Karyawan
  - GET /api/v1/employees
  - POST /api/v1/employees
  - GET /api/v1/employees/{id}
  - PATCH /api/v1/employees/{id}
  - DELETE /api/v1/employees/{id}
- Absensi
  - GET /api/v1/attendances
  - POST /api/v1/attendances/check-in
  - POST /api/v1/attendances/check-out
  - GET /api/v1/attendances/recap
- Penggajian
  - GET /api/v1/payroll-runs
  - POST /api/v1/payroll-runs
  - GET /api/v1/payrolls
  - GET /api/v1/payrolls/{id}
  - GET /api/v1/payrolls/{id}/slip
- Laporan
  - GET /api/v1/reports/attendance
  - GET /api/v1/reports/payroll
- Pengaturan
  - GET /api/v1/settings/work
  - PATCH /api/v1/settings/work
  - GET /api/v1/settings/salary-components
  - PATCH /api/v1/settings/salary-components

## Dummy Data
- Admin: admin@company.test / password
- HRD: hrd@company.test / password
- Karyawan: karyawan1@company.test / password (karyawan2/3 juga ada)
- Divisi: Finance, Human Resource, Engineering
- Jabatan: Manager, Staff, Analyst
- Komponen gaji: Gaji Pokok, Tunjangan, Bonus, Keterlambatan, BPJS, Pajak

## Best Practice Keamanan
- Gunakan RBAC untuk semua rute sensitif.
- Validasi input dengan FormRequest.
- Lindungi endpoint dengan CSRF dan rate limiting.
- Gunakan hashing password bawaan Laravel.
- Audit log untuk perubahan payroll dan pengaturan.
- Batasi ekspor data sensitif dan beri watermark PDF.
