<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();

$selectedKelurahan = $_GET['kelurahan'] ?? '';

$kriteria = $pdo->query("SELECT * FROM kriteria ORDER BY kode ASC")->fetchAll();

$whereClause = '';
$params = [];
if ($selectedKelurahan !== '') {
    $whereClause = " WHERE kelurahan = ?";
    $params[] = $selectedKelurahan;
}

$alternatifStmt = $pdo->prepare("SELECT * FROM alternatif" . $whereClause . " ORDER BY nama ASC");
$alternatifStmt->execute($params);
$alternatifFiltered = $alternatifStmt->fetchAll();

$alternatifIds = array_column($alternatifFiltered, 'id');
$altIdPlaceholders = implode(',', array_fill(0, count($alternatifIds), '?'));

$subKriteria = $pdo->query("SELECT * FROM sub_kriteria ORDER BY kriteria_id, kode ASC")->fetchAll();

$aggregated = [];
$penilaianRows = [];
if (!empty($alternatifIds)) {
    $penStmt = $pdo->prepare("SELECT * FROM penilaian WHERE alternatif_id IN (" . $altIdPlaceholders . ")");
    $penStmt->execute($alternatifIds);
    $penilaianRows = $penStmt->fetchAll();

    $penData = [];
    foreach ($penilaianRows as $row) {
        $penData[$row['alternatif_id']][$row['sub_kriteria_id']] = (float) $row['nilai'];
    }

    $subByKriteria = [];
    foreach ($subKriteria as $sk) {
        $subByKriteria[$sk['kriteria_id']][] = $sk;
    }

    foreach ($alternatifFiltered as $alt) {
        $aggregated[$alt['id']] = [];
        foreach ($kriteria as $k) {
            $weightedSum = 0;
            if (isset($subByKriteria[$k['id']])) {
                foreach ($subByKriteria[$k['id']] as $sk) {
                    $bobot = (float) $sk['bobot'];
                    $nilai = $penData[$alt['id']][$sk['id']] ?? 0;
                    $weightedSum += $bobot * $nilai;
                }
            }
            $aggregated[$alt['id']][$k['id']] = $weightedSum;
        }
    }
}

$ranking = [];
if (!empty($alternatifIds)) {
    $rankStmt = $pdo->prepare("
        SELECT h.*, a.nama, a.nik, a.alamat, a.rt_rw, a.kelurahan
        FROM hasil_perhitungan h
        JOIN alternatif a ON a.id = h.alternatif_id
        WHERE h.alternatif_id IN (" . $altIdPlaceholders . ")
        ORDER BY h.ranking ASC
    ");
    $rankStmt->execute($alternatifIds);
    $ranking = $rankStmt->fetchAll();
}

$tanggal = date('d F Y');
$filterLabel = $selectedKelurahan !== '' ? 'Kelurahan: ' . htmlspecialchars($selectedKelurahan) : 'Semua Kelurahan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; padding: 40px 60px; line-height: 1.6; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 15px; margin-bottom: 25px; }
        .kop h2 { font-size: 16pt; font-weight: bold; letter-spacing: 2px; margin-bottom: 2px; text-transform: uppercase; }
        .kop h3 { font-size: 14pt; font-weight: bold; letter-spacing: 3px; margin-bottom: 4px; text-transform: uppercase; }
        .kop p { font-size: 10pt; }
        .judul { text-align: center; margin-bottom: 20px; }
        .judul h3 { font-size: 13pt; font-weight: bold; text-decoration: underline; margin-bottom: 2px; text-transform: uppercase; }
        .judul h4 { font-size: 11pt; font-weight: bold; text-transform: uppercase; }
        .info { margin-bottom: 15px; font-size: 11pt; }
        .info p { margin-bottom: 2px; }
        .info strong { display: inline-block; min-width: 120px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #000; padding: 6px 10px; font-size: 10pt; }
        table th { background-color: #f0f0f0; font-weight: bold; text-align: center; }
        table td { vertical-align: top; }
        table td.text-center { text-align: center; }
        table td.text-right { text-align: right; }
        .table-caption { font-weight: bold; font-size: 11pt; margin-bottom: 8px; margin-top: 15px; }
        .no-data { text-align: center; padding: 20px; font-style: italic; color: #666; }
        .rank-1 td { font-weight: bold; background-color: #fffbe6; }
        .tanda-tangan { margin-top: 40px; text-align: right; padding-right: 60px; }
        .tanda-tangan .spacer { height: 80px; }
        .tanda-tangan p { font-size: 11pt; margin-bottom: 2px; }
        .tanda-tangan .nama { font-weight: bold; text-decoration: underline; }
        .tanda-tangan .nip { font-size: 10pt; }
        .btn-print { display: block; margin: 20px auto; padding: 10px 30px; background-color: #dc3545; color: #fff; border: none; border-radius: 20px; font-size: 12pt; cursor: pointer; }
        .btn-print:hover { background-color: #bb2d3b; }
        @media print {
            body { padding: 20px 40px; }
            .no-print { display: none !important; }
            .btn-print { display: none !important; }
            table { page-break-inside: avoid; }
            tr { page-break-inside: avoid; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">
        <span>&#128424;</span> Cetak
    </button>

    <div class="kop">
        <h2>Pemerintah Kabupaten Merangin</h2>
        <h3>Dinas Sosial</h3>
        <p>Jl. Sultan Thaha, Bangko, Kabupaten Merangin, Jambi</p>
        <p>Telp: (0743) 21107 | Email: dinasos@meranginkab.go.id</p>
    </div>

    <div class="judul">
        <h3>Laporan Hasil Perhitungan SPK VIKOR</h3>
        <h4>Penentuan Penerima Bantuan Sosial</h4>
    </div>

    <div class="info">
        <p>Tanggal: <strong><?php echo $tanggal; ?></strong></p>
        <p>Filter: <strong><?php echo $filterLabel; ?></strong></p>
    </div>

    <?php if (empty($alternatifFiltered)): ?>
    <div class="no-data">Tidak ada data untuk ditampilkan.</div>
    <?php else: ?>

    <div class="table-caption">A. Rekap Penilaian (Matriks Agregasi)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="text-align: left;">Alternatif</th>
                <?php foreach ($kriteria as $k): ?>
                <th><?php echo $k['kode']; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($aggregated)): ?>
            <tr>
                <td colspan="<?php echo 2 + count($kriteria); ?>" class="no-data">Tidak ada data penilaian</td>
            </tr>
            <?php else: ?>
            <?php $no = 1; foreach ($alternatifFiltered as $alt): ?>
            <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($alt['nama']); ?></td>
                <?php foreach ($kriteria as $k): ?>
                <td class="text-right"><?php echo number_format($aggregated[$alt['id']][$k['id']] ?? 0, 4); ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="table-caption">B. Hasil Perhitungan VIKOR</div>
    <?php if (empty($ranking)): ?>
    <div class="no-data">Belum ada hasil perhitungan VIKOR.</div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th style="width: 50px;">Ranking</th>
                <th style="text-align: left;">Nama</th>
                <th>Alamat</th>
                <th>Kelurahan</th>
                <th>Nilai S</th>
                <th>Nilai R</th>
                <th>Nilai Q</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ranking as $row): ?>
            <tr class="<?php echo $row['ranking'] == 1 ? 'rank-1' : ''; ?>">
                <td class="text-center"><?php echo $row['ranking']; ?></td>
                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                <td><?php echo htmlspecialchars($row['kelurahan']); ?></td>
                <td class="text-right"><?php echo number_format($row['nilai_s'], 4); ?></td>
                <td class="text-right"><?php echo number_format($row['nilai_r'], 4); ?></td>
                <td class="text-right"><?php echo number_format($row['nilai_q'], 4); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <div class="tanda-tangan">
        <p>Mengetahui,</p>
        <p>Kepala Dinas Sosial</p>
        <p class="spacer">&nbsp;</p>
        <p>&nbsp;</p>
        <p class="nama">________________________</p>
        <p>NIP. ________________________</p>
    </div>

    <?php endif; ?>

    <script>
        function noPrint() {}
    </script>
</body>
</html>
