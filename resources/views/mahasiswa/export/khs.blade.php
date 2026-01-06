<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KHS {{ $tahunAkademik->tahun }} Semester {{ $tahunAkademik->semester }} - {{ $mahasiswa->nim }}</title>

<style>
    body {
        font-family: "Times New Roman", serif;
        background: #f2f2f2;
        margin: 0;
        padding: 20px;
    }

    .paper {
        max-width: 210mm;
        min-height: 297mm;
        background: #e6f0ef;
        margin: auto;
        padding: 25mm 20mm;
        box-sizing: border-box;
    }

.header {
    display: flex;
    flex-direction: column; /* logo di atas teks */
    align-items: center;    /* tengah-tengah secara horizontal */
    gap: 10px;              /* jarak antara logo dan teks */
    margin-bottom: 20px;
}

.logo-img {
    width: 80px;     /* ukuran logo */
    height: auto;
}

.header-text {
    text-align: center;
}

.header-text .unswa {
    font-weight: bold;
    font-size: clamp(16px, 2vw, 20px);
}

.header-text .univ {
    font-size: clamp(14px, 1.8vw, 18px);
    color: #555;
}

    hr {
        border: none;
        border-top: 2px solid #333;
        margin: 10px 0 15px;
    }

    h2 {
        text-align: center;
        margin: 10px 0 20px;
        font-size: clamp(14px, 1.8vw, 16px);
        letter-spacing: 1px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .info td {
        padding: 3px 5px;
        vertical-align: top;
    }

    /* TABEL NILAI */
    .nilai {
        overflow-x: auto;
        display: block;
    }

    .nilai table {
        width: 100%;
        border-collapse: collapse;
    }

    .nilai th, .nilai td {
        border: 1px dashed #333;
        padding: 5px;
        text-align: center;
        white-space: nowrap;
    }

    .nilai th {
        font-weight: bold;
    }

    .left {
        text-align: left !important;
    }

    /* RINGKASAN */
    .summary {
        margin-top: 15px;
        font-size: 13px;
    }

    .summary td {
        padding: 3px 5px;
    }

    /* FOOTER */
    .footer {
        margin-top: 40px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        font-size: 13px;
        gap: 20px;
    }

    .ttd {
        text-align: center;
        width: 100%;
        max-width: 40%;
    }

    .ttd .nama {
        margin-top: 60px;
        font-weight: bold;
        text-decoration: underline;
    }

    .keterangan {
        margin-top: 30px;
        font-size: 12px;
    }

    .print-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 10px 20px;
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        z-index: 1000;
    }

    .print-btn:hover {
        background: #4338ca;
    }

    /* CETAK */
    @media print {
        body {
            background: none;
            padding: 0;
        }
        .paper {
            margin: 0;
        }
        .print-btn {
            display: none;
        }
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            gap: 5px;
        }

        .ttd {
            max-width: 100%;
        }
    }
</style>
</head>

<body>

<div class="paper">
    <button class="print-btn" onclick="window.print()">🖨️ Cetak / PDF</button>

    <!-- HEADER -->
    <div class="header">
        <img src="/LOGO-KAMPUS.png" alt="Logo UNSWA" class="logo-img">
        <div class="header-text">
            <div class="unswa">UNSWA</div>
            <div class="univ">UNIVERSITAS NGGUSUWARU</div>
        </div>
    </div>

    <hr>

    <h2>KARTU HASIL STUDI (KHS)</h2>

    <!-- INFO MAHASISWA -->
    <table class="info">
        <tr><td width="120">NAMA</td><td>: {{ $mahasiswa->user->name }}</td></tr>
        <tr><td>NIM</td><td>: {{ $mahasiswa->nim }}</td></tr>
        <tr><td>FAKULTAS</td><td>: {{ $mahasiswa->prodi->fakultas->nama ?? '-' }}</td></tr>
        <tr><td>PRODI</td><td>: {{ $mahasiswa->prodi->nama ?? '-' }}</td></tr>
        <tr><td>SEMESTER</td><td>: {{ $tahunAkademik->semester }} ({{ $tahunAkademik->tahun }})</td></tr>
        <tr><td>DOSEN PA</td><td>: {{ $mahasiswa->dosenPa->user->name ?? '-' }}</td></tr>
    </table>

    <br>

    <!-- TABEL NILAI -->
    <div class="nilai">
        <table>
            <thead>
            <tr>
                <th>No</th>
                <th>Kode MK</th>
                <th class="left">Mata Uji</th>
                <th>SKS</th>
                <th>HM</th>
                <th>AM</th>
                <th>NK</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>
            @php $totalSks = 0; $totalBobot = 0; @endphp
            @forelse($nilaiList as $index => $nilai)
            @php
                $mk = $nilai->kelas->mataKuliah;
                $bobot = match($nilai->nilai_huruf) {
                    'A' => 4.00,
                    'A-' => 3.75,
                    'B+' => 3.50,
                    'B' => 3.00,
                    'B-' => 2.75,
                    'C+' => 2.50,
                    'C' => 2.00,
                    'C-' => 1.75,
                    'D' => 1.00,
                    default => 0
                };
                $nilaiBobot = $bobot * $mk->sks;
                $totalSks += $mk->sks;
                $totalBobot += $nilaiBobot;
                // Keterangan berdasarkan nilai huruf
                $keterangan = match($nilai->nilai_huruf) {
                    'A' => 'Sangat Baik',
                    'A-' => 'Baik Sekali',
                    'B+' => 'Baik',
                    'B' => 'Cukup Baik',
                    'B-' => 'Cukup',
                    'C+' => 'Cukup',
                    'C' => 'Kurang',
                    'C-' => 'Kurang Sekali',
                    'D' => 'Sangat Kurang',
                    default => '-'
                };
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mk->kode_mk }}</td>
                <td class="left">{{ $mk->nama_mk }}</td>
                <td>{{ $mk->sks }}</td>
                <td>{{ $nilai->nilai_angka ?? '-' }}</td>
                <td><strong>{{ $nilai->nilai_huruf ?? '-' }}</strong></td>
                <td>{{ number_format($nilaiBobot, 1) }}</td>
                <td>{{ $keterangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="center">Belum ada nilai</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="3" class="center"><b>Jumlah</b></td>
                <td><b>{{ $totalSks }}</b></td>
                <td colspan="3"><b>{{ number_format($totalBobot, 1) }}</b></td>
                <td></td>
            </tr>
        </table>
    </div>

    <br>
    @php
        $ipk = $ipsData['ips'] ?? 0; // Pastikan ada nilai default jika data kosong
        $maxSks = 0;
    
        if($ipk >= 3.00) {
            $maxSks = 24;
        } elseif($ipk >= 2.50) {
            $maxSks = 21;
        } elseif($ipk >= 2.00) {
            $maxSks = 18;
        } else {
            $maxSks = 15; // Standar minimal biasanya 12 atau 15 SKS
        }
    @endphp

    <!-- IP -->
    <table class="summary">
        <tr><td>IP Semester sebelumnya<span style="margin-left: 20px;">=</span><span style="margin-left: 20px;">{{ number_format($ipsData['ips'], 1) }}</span></td></tr>
        <tr><td>IP Semester sekarang<span style="margin-left: 20px;">=</span><span style="margin-left: 20px;">{{ number_format($ipsData['ips'], 2) }}</td></tr>
        <tr><td>IP Kumulatif (IPK)<span style="margin-left: 20px;">=</span><span style="margin-left: 20px;">{{ number_format($ipsData['ips'], 2) }}</td></tr>
        <tr><td>SKS yang bisa diprogramkan<span style="margin-left: 20px;">=</span><span style="margin-left: 20px;">{{ $maxSks }}</td></tr>
    </table>

    <!-- TANDA TANGAN -->
    <div class="footer">
        <div class="ttd">
            Mengetahui,<br>
            Kepala Bagian Administrasi<br>
            Akademik Kemahasiswaan
            <div class="nama">Yahya, A.Md</div>
            NITK. 7700009423
        </div>

        <div class="ttd">
            Kota Bima, {{ now()->format('d F Y') }}<br>
            {{ $mahasiswa->prodi->fakultas->nama ?? '-' }}<br>
            Ketua Program Studi {{ $mahasiswa->prodi->nama ?? '-' }}
            <div class="nama">Irwansyah, S.T., M.Pd</div>
            NIDN. 0827049402
        </div>
    </div>

    <!-- KETERANGAN -->
    <div class="keterangan">
        <b>Keterangan:</b><br>
        Lembar Kuning untuk BAAK<br>
        Lembar Pink untuk PRODI<br>
        Lembar Putih untuk MAHASISWA
    </div>

</div>

</body>
</html>
