<?php

/**
 * Menghasilkan markup isi laporan (kop, rekap penilaian, hasil VIKOR, tanda tangan).
 *
 * @param array $kriteria            Daftar kriteria
 * @param array $alternatifFiltered  Daftar alternatif sesuai filter
 * @param array $aggregated          Matriks agregasi penilaian per alternatif
 * @param array $ranking             Hasil perhitungan VIKOR terurut
 * @return string
 */
function renderLaporan(array $kriteria, array $alternatifFiltered, array $aggregated, array $ranking): string
{
    ob_start();
?>
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

    <?php if (empty($alternatifFiltered)): ?>
        <div class="no-data">Tidak ada data untuk ditampilkan.</div>
    <?php else: ?>

        <div class="table-caption">A. Rekap Penilaian (Matriks Agregasi)</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
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
                    <?php $no = 1;
                    foreach ($alternatifFiltered as $alt): ?>
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
                        <th>Ranking</th>
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

        <table class="ttd-table">
            <tr>
                <td>
                    <p>Mengetahui,</p>
                    <p>Kepala Dinas Sosial</p>
                    <div class="spacer">&nbsp;</div>
                    <p class="nama">________________________</p>
                    <p class="nip">NIP.</p>
                </td>
            </tr>
        </table>

    <?php endif; ?>
<?php
    return ob_get_clean();
}
