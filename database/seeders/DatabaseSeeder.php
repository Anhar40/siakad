<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\TahunAkademik;
use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\Nilai;
use App\Models\JadwalKuliah;
use App\Models\Ruangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        // ==========================================
        // 1. SUPERADMIN
        // ==========================================
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@siakad.test',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        // ==========================================
        // 2. TAHUN AKADEMIK
        // ==========================================
        TahunAkademik::create([
            'tahun' => '2023/2024',
            'semester' => 'Ganjil',
            'is_active' => false,
            'tanggal_mulai' => '2023-09-01',
            'tanggal_selesai' => '2024-01-31',
        ]);
        
        $taLalu = TahunAkademik::create([
            'tahun' => '2023/2024',
            'semester' => 'Genap',
            'is_active' => false,
            'tanggal_mulai' => '2024-02-01',
            'tanggal_selesai' => '2024-06-30',
        ]);
        
        $taAktif = TahunAkademik::create([
            'tahun' => '2024/2025',
            'semester' => 'Ganjil',
            'is_active' => true,
            'tanggal_mulai' => '2024-09-01',
            'tanggal_selesai' => '2025-01-31',
        ]);

        // ==========================================
        // 3. FAKULTAS
        // ==========================================
        $fakultas = Fakultas::create(['nama' => 'Fakultas Teknik dan Ilmu Komputer']);

        // Admin Fakultas
        $adminFakultas = User::create([
            'name' => 'Admin FTIK',
            'email' => 'admin.ftik@siakad.test',
            'password' => Hash::make('password'),
            'role' => 'admin_fakultas',
            'fakultas_id' => $fakultas->id,
        ]);

        // ==========================================
        // 4. PROGRAM STUDI
        // ==========================================
        $prodi = Prodi::create([
            'nama' => 'Teknik Informatika',
            'fakultas_id' => $fakultas->id,
        ]);

        // ==========================================
        // 5. RUANGAN
        // ==========================================
        $ruangan = Ruangan::create([
            'kode_ruangan' => 'LC-01',
            'nama_ruangan' => 'Lab Komputer 1',
            'kapasitas' => 40,
            'gedung' => 'Gedung A',
            'lantai' => 1,
        ]);

        // ==========================================
        // 6. MATA KULIAH - KURIKULUM 8 SEMESTER (144 SKS)
        // ==========================================
        $kurikulum = $this->getKurikulum($prodi->id);
        
        foreach ($kurikulum as $mk) {
            MataKuliah::create($mk);
        }

        // ==========================================
        // 7. DOSEN
        // ==========================================
        $dosenUser = User::create([
            'name' => 'Dr. Ahmad Fauzi, M.Kom.',
            'email' => 'dosen@siakad.test',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        $dosen = Dosen::create([
            'user_id' => $dosenUser->id,
            'nidn' => '0012056701',
            'prodi_id' => $prodi->id,
        ]);

        // ==========================================
        // 8. KELAS (untuk semester 1-2)
        // ==========================================
        $mataKuliahSem1 = MataKuliah::where('semester', 1)->get();
        $mataKuliahSem2 = MataKuliah::where('semester', 2)->get();
        
        $kelasList = [];
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jamMulai = ['08:00', '10:00', '13:00', '15:00'];
        
        $dayIndex = 0;
        $jamIndex = 0;
        
        foreach ($mataKuliahSem1->merge($mataKuliahSem2) as $mk) {
            $kelas = Kelas::create([
                'mata_kuliah_id' => $mk->id,
                'dosen_id' => $dosen->id,
                'nama_kelas' => 'A',
                'kapasitas' => 40,
                'tahun_akademik_id' => $taAktif->id,
            ]);
            
            // Create jadwal
            JadwalKuliah::create([
                'kelas_id' => $kelas->id,
                'hari' => $hari[$dayIndex % 5],
                'jam_mulai' => $jamMulai[$jamIndex % 4],
                'jam_selesai' => date('H:i', strtotime($jamMulai[$jamIndex % 4]) + 5400), // +1.5 hours
                'ruangan' => $ruangan->nama_ruangan,
            ]);
            
            $kelasList[] = $kelas;
            $dayIndex++;
            $jamIndex++;
        }

        // ==========================================
        // 9. MAHASISWA (Semester 5 - Angkatan 2022)
        // ==========================================
        $mahasiswaUser = User::create([
            'name' => 'Budi Santoso',
            'email' => 'anharaldevaro@gmail.com',
            'password' => Hash::make('Anhar12345'),
            'role' => 'mahasiswa',
        ]);

        $mahasiswa = Mahasiswa::create([
            'user_id' => $mahasiswaUser->id,
            'nim' => '2022101001',
            'prodi_id' => $prodi->id,
            'angkatan' => 2022,
            'dosen_pa_id' => $dosen->id,
            'status' => 'aktif',
        ]);

        // ==========================================
        // 10. RIWAYAT AKADEMIK (4 Semester Selesai)
        // ==========================================
        
        // Buat tahun akademik untuk semester 1-4
        $ta2022Ganjil = TahunAkademik::create([
            'tahun' => '2022/2023', 'semester' => 'Ganjil', 'is_active' => false,
            'tanggal_mulai' => '2022-09-01', 'tanggal_selesai' => '2023-01-31',
        ]);
        $ta2022Genap = TahunAkademik::create([
            'tahun' => '2022/2023', 'semester' => 'Genap', 'is_active' => false,
            'tanggal_mulai' => '2023-02-01', 'tanggal_selesai' => '2023-06-30',
        ]);
        
        // Semester 1 (20 SKS - 7 MK)
        $krs1 = Krs::create(['mahasiswa_id' => $mahasiswa->id, 'tahun_akademik_id' => $ta2022Ganjil->id, 'status' => 'approved']);
        foreach (MataKuliah::where('semester', 1)->get() as $mk) {
            $kelas = Kelas::where('mata_kuliah_id', $mk->id)->first();
            if ($kelas) {
                KrsDetail::create(['krs_id' => $krs1->id, 'kelas_id' => $kelas->id]);
                $nilaiAngka = rand(75, 92);
                Nilai::create(['mahasiswa_id' => $mahasiswa->id, 'kelas_id' => $kelas->id, 'nilai_angka' => $nilaiAngka, 'nilai_huruf' => $this->convertToLetter($nilaiAngka)]);
            }
        }

        // Semester 2 (20 SKS - 7 MK)
        $krs2 = Krs::create(['mahasiswa_id' => $mahasiswa->id, 'tahun_akademik_id' => $ta2022Genap->id, 'status' => 'approved']);
        foreach (MataKuliah::where('semester', 2)->get() as $mk) {
            $kelas = Kelas::where('mata_kuliah_id', $mk->id)->first();
            if ($kelas) {
                KrsDetail::create(['krs_id' => $krs2->id, 'kelas_id' => $kelas->id]);
                $nilaiAngka = rand(73, 90);
                Nilai::create(['mahasiswa_id' => $mahasiswa->id, 'kelas_id' => $kelas->id, 'nilai_angka' => $nilaiAngka, 'nilai_huruf' => $this->convertToLetter($nilaiAngka)]);
            }
        }

        // Semester 3 (21 SKS - 7 MK) - 2023/2024 Ganjil (sudah ada di atas)
        $ta2023Ganjil = TahunAkademik::where('tahun', '2023/2024')->where('semester', 'Ganjil')->first();
        $krs3 = Krs::create(['mahasiswa_id' => $mahasiswa->id, 'tahun_akademik_id' => $ta2023Ganjil->id, 'status' => 'approved']);
        foreach (MataKuliah::where('semester', 3)->get() as $mk) {
            // Create kelas for semester 3
            $kelas3 = Kelas::create([
                'mata_kuliah_id' => $mk->id, 'dosen_id' => $dosen->id, 'nama_kelas' => 'A', 
                'kapasitas' => 40, 'tahun_akademik_id' => $ta2023Ganjil->id,
            ]);
            KrsDetail::create(['krs_id' => $krs3->id, 'kelas_id' => $kelas3->id]);
            $nilaiAngka = rand(72, 88);
            Nilai::create(['mahasiswa_id' => $mahasiswa->id, 'kelas_id' => $kelas3->id, 'nilai_angka' => $nilaiAngka, 'nilai_huruf' => $this->convertToLetter($nilaiAngka)]);
        }

        // Semester 4 (21 SKS - 7 MK) - 2023/2024 Genap
        $krs4 = Krs::create(['mahasiswa_id' => $mahasiswa->id, 'tahun_akademik_id' => $taLalu->id, 'status' => 'approved']);
        foreach (MataKuliah::where('semester', 4)->get() as $mk) {
            $kelas4 = Kelas::create([
                'mata_kuliah_id' => $mk->id, 'dosen_id' => $dosen->id, 'nama_kelas' => 'A',
                'kapasitas' => 40, 'tahun_akademik_id' => $taLalu->id,
            ]);
            KrsDetail::create(['krs_id' => $krs4->id, 'kelas_id' => $kelas4->id]);
            $nilaiAngka = rand(74, 90);
            Nilai::create(['mahasiswa_id' => $mahasiswa->id, 'kelas_id' => $kelas4->id, 'nilai_angka' => $nilaiAngka, 'nilai_huruf' => $this->convertToLetter($nilaiAngka)]);
        }

        // ==========================================
        // 11. KRS SEMESTER 5 SEKARANG (Draft)
        // ==========================================
        $krsSekarang = Krs::create([
            'mahasiswa_id' => $mahasiswa->id,
            'tahun_akademik_id' => $taAktif->id,
            'status' => 'draft',
        ]);

        // Create kelas untuk semester 5 dan ambil KRS
        foreach (MataKuliah::where('semester', 5)->get() as $mk) {
            $kelas5 = Kelas::create([
                'mata_kuliah_id' => $mk->id, 'dosen_id' => $dosen->id, 'nama_kelas' => 'A',
                'kapasitas' => 40, 'tahun_akademik_id' => $taAktif->id,
            ]);
            KrsDetail::create(['krs_id' => $krsSekarang->id, 'kelas_id' => $kelas5->id]);
        }

        // ==========================================
        // OUTPUT
        // ==========================================
        $this->command->newLine();
        $this->command->info('✅ Database seeded successfully!');
        $this->command->newLine();
        $this->command->info('📋 Login Credentials:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Superadmin', 'superadmin@siakad.test', 'password'],
                ['Admin Fakultas', 'admin.ftik@siakad.test', 'password'],
                ['Dosen', 'dosen@siakad.test', 'password'],
                ['Mahasiswa', 'mahasiswa@siakad.test', 'password'],
            ]
        );
        $this->command->newLine();
        $this->command->info("📚 Kurikulum: {$prodi->nama}");
        $this->command->info("   Total: 144 SKS | 8 Semester | " . MataKuliah::count() . " Mata Kuliah");
    }

    /**
     * Kurikulum Teknik Informatika - 8 Semester - 144 SKS
     */
    private function getKurikulum(int $prodiId): array
    {
        return [
            // ====== SEMESTER 1 (20 SKS) ======
            // SEMESTER I
            ['kode_mk' => 'PIP1105', 'nama_mk' => 'Bahasa inggris', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_mk' => 'IT1106', 'nama_mk' => 'Pengantar teknologi informasi', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_mk' => 'IT2421', 'nama_mk' => 'Algoritma dan Pemrograman Dasar', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_mk' => 'IT2421', 'nama_mk' => 'Prak Algoritma dan Pemrograman Dasar', 'sks' => 1, 'semester' => 1, 'prodi_id' => 1],
            ['kode_mk' => 'IT2208', 'nama_mk' => 'Organisasi dan Arsitektur komputer', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_mk' => 'IT2208', 'nama_mk' => 'Prak Organisasi dan Arsitektur komputer', 'sks' => 1, 'semester' => 1, 'prodi_id' => 1],
            ['kode_mk' => 'IT2105', 'nama_mk' => 'Logika informatika', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_mk' => 'IT2318', 'nama_mk' => 'Kalkulus', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_mk' => 'IT2211', 'nama_mk' => 'Matematika diskrit', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_mk' => 'PIP1101', 'nama_mk' => 'Pendidikan Agama', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
            ['kode_mk' => 'PIP1102', 'nama_mk' => 'Pendidikan Pancasila', 'sks' => 2, 'semester' => 1, 'prodi_id' => 1],
        
            // SEMESTER II
            ['kode_mk' => 'IT2207', 'nama_mk' => 'Sistem operasi', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
            ['kode_mk' => 'IT2315', 'nama_mk' => 'Pemrograman Berorientasi Objek', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
            ['kode_mk' => 'IT2212', 'nama_mk' => 'Teknologi Basis Data', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
            ['kode_mk' => 'PIP1206', 'nama_mk' => 'Kewirausahaan', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
            ['kode_mk' => 'IT2209', 'nama_mk' => 'Aljabar Linear', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
            ['kode_mk' => 'IT2747', 'nama_mk' => 'Statistik', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
            ['kode_mk' => 'IT2747', 'nama_mk' => 'Prak Statistik', 'sks' => 1, 'semester' => 2, 'prodi_id' => 1],
            ['kode_mk' => 'PIP1104', 'nama_mk' => 'Bahasa Indonesia', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
            ['kode_mk' => 'IT2534', 'nama_mk' => 'Metode Numerik', 'sks' => 2, 'semester' => 2, 'prodi_id' => 1],
        
            // SEMESTER III
            ['kode_mk' => 'IT2317', 'nama_mk' => 'Struktur Data', 'sks' => 2, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2317', 'nama_mk' => 'Prak Struktur Data', 'sks' => 1, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2423', 'nama_mk' => 'Pemrograman Web I', 'sks' => 2, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2423', 'nama_mk' => 'Prak Pemrograman Web I', 'sks' => 1, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2214', 'nama_mk' => 'Sistem Informasi', 'sks' => 2, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2214', 'nama_mk' => 'Prak Sistem Informasi', 'sks' => 1, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2639', 'nama_mk' => 'Komunikasi Data dan Jaringan Komputer', 'sks' => 2, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2639', 'nama_mk' => 'Prak Komunikasi Data dan Jaringan Komputer', 'sks' => 1, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2536', 'nama_mk' => 'Rekayasa Perangkat Lunak', 'sks' => 2, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2536', 'nama_mk' => 'Prak Rekayasa Perangkat Lunak', 'sks' => 1, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2424', 'nama_mk' => 'Interaksi Manusia dan Komputer', 'sks' => 2, 'semester' => 3, 'prodi_id' => 1],
            ['kode_mk' => 'IT2424', 'nama_mk' => 'Prak Interaksi Manusia dan Komputer', 'sks' => 1, 'semester' => 3, 'prodi_id' => 1],
        
            // SEMESTER IV
            ['kode_mk' => 'IT2426', 'nama_mk' => 'Pemrograman Web II', 'sks' => 2, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT2426', 'nama_mk' => 'Prak Pemrograman Web II', 'sks' => 1, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT2213', 'nama_mk' => 'Keamanan Informasi dan Jaringan', 'sks' => 2, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT2213', 'nama_mk' => 'Prak Keamanan Informasi dan Jaringan', 'sks' => 1, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT4311', 'nama_mk' => 'Kecerdasan Buatan', 'sks' => 2, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT4311', 'nama_mk' => 'Prak Kecerdasan Buatan', 'sks' => 1, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT2215', 'nama_mk' => 'Cloud Computing', 'sks' => 2, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT2215', 'nama_mk' => 'Prak Cloud Computing', 'sks' => 1, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT2641', 'nama_mk' => 'Ethical Hacking', 'sks' => 2, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT2425', 'nama_mk' => 'Pemrograman Mobile', 'sks' => 2, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT2425', 'nama_mk' => 'Prak Pemrograman Mobile', 'sks' => 1, 'semester' => 4, 'prodi_id' => 1],
            ['kode_mk' => 'IT2746', 'nama_mk' => 'Metodelogi Penelitian', 'sks' => 3, 'semester' => 4, 'prodi_id' => 1],
        
            // SEMESTER V
            ['kode_mk' => 'IT2210', 'nama_mk' => 'Big Data dan Analitik', 'sks' => 2, 'semester' => 5, 'prodi_id' => 1],
            ['kode_mk' => 'IT2210', 'nama_mk' => 'Prak Big Data dan Analitik', 'sks' => 1, 'semester' => 5, 'prodi_id' => 1],
            ['kode_mk' => 'IT6138', 'nama_mk' => 'Sistem Cerdas', 'sks' => 2, 'semester' => 5, 'prodi_id' => 1],
            ['kode_mk' => 'IT6138', 'nama_mk' => 'Prak Sistem Cerdas', 'sks' => 1, 'semester' => 5, 'prodi_id' => 1],
            ['kode_mk' => 'IT2537', 'nama_mk' => 'Analisis dan Perancangan Sistem', 'sks' => 2, 'semester' => 5, 'prodi_id' => 1],
            ['kode_mk' => 'IT2537', 'nama_mk' => 'Prak Analisis dan Perancangan Sistem', 'sks' => 1, 'semester' => 5, 'prodi_id' => 1],
            ['kode_mk' => 'IT2558', 'nama_mk' => 'Sistem Terdistribusi', 'sks' => 2, 'semester' => 5, 'prodi_id' => 1],
            ['kode_mk' => 'IT2558', 'nama_mk' => 'Prak Sistem Terdistribusi', 'sks' => 1, 'semester' => 5, 'prodi_id' => 1],
        ];
    }

    private function convertToLetter(int $nilai): string
    {
        return match (true) {
            $nilai >= 80 => 'A',
            $nilai >= 75 => 'A-',
            $nilai >= 70 => 'B+',
            $nilai >= 65 => 'B',
            $nilai >= 60 => 'C+',
            $nilai >= 55 => 'C',
            $nilai >= 50 => 'D',
            default => 'E',
        };
    }
}
