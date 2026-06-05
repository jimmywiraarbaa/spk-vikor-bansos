CREATE TABLE IF NOT EXISTS skala_penilaian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sub_kriteria_id INT NOT NULL,
    nilai INT NOT NULL,
    keterangan VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sub_kriteria_id) REFERENCES sub_kriteria(id) ON DELETE CASCADE,
    UNIQUE KEY (sub_kriteria_id, nilai)
);

-- C1.1 Penghasilan per Bulan (cost - semakin kecil semakin baik)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (1, 1, '> Rp 3.000.000'),
    (1, 2, 'Rp 2.000.001 - Rp 3.000.000'),
    (1, 3, 'Rp 1.000.001 - Rp 2.000.000'),
    (1, 4, 'Rp 500.001 - Rp 1.000.000'),
    (1, 5, '<= Rp 500.000');

-- C1.2 Sumber Penghasilan (cost)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (2, 1, 'Pengusaha/Profesional'),
    (2, 2, 'PNS/Pegawai Swasta Tetap'),
    (2, 3, 'Pekerja Harian Lepas'),
    (2, 4, 'Buruh/Perantara'),
    (2, 5, 'Tidak Bekerja/Tidak Tetap');

-- C2.1 Jenis Pekerjaan (cost)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (3, 1, 'PNS/TNI/Polri'),
    (3, 2, 'Pegawai Swasta Tetap'),
    (3, 3, 'Wiraswasta'),
    (3, 4, 'Pekerja Harian Lepas'),
    (3, 5, 'Tidak Bekerja');

-- C2.2 Status Pekerjaan (cost)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (4, 1, 'Tetap/Pensiun'),
    (4, 2, 'Kontrak'),
    (4, 3, 'Musiman'),
    (4, 4, 'Harian Lepas'),
    (4, 5, 'Tidak Bekerja');

-- C3.1 Jenis Lantai (cost)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (5, 1, 'Marmer/Granit'),
    (5, 2, 'Keramik'),
    (5, 3, 'Tegel/Teraso'),
    (5, 4, 'Semen/Plester'),
    (5, 5, 'Tanah');

-- C3.2 Jenis Dinding (cost)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (6, 1, 'Bata Plester/Pengecatan'),
    (6, 2, 'Bata Plester'),
    (6, 3, 'Bata Expose/Anyaman'),
    (6, 4, 'Papan/Bambu'),
    (6, 5, 'Kayu/Ilalang');

-- C3.3 Luas Rumah (cost)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (7, 1, '> 100 m²'),
    (7, 2, '71 - 100 m²'),
    (7, 3, '46 - 70 m²'),
    (7, 4, '21 - 45 m²'),
    (7, 5, '<= 20 m²');

-- C4.1 Jumlah Tanggungan (benefit - semakin banyak semakin baik)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (8, 1, '0 - 1 orang'),
    (8, 2, '2 orang'),
    (8, 3, '3 orang'),
    (8, 4, '4 orang'),
    (8, 5, '> 4 orang');

-- C4.2 Status Pernikahan (benefit)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (9, 1, 'Belum Menikah'),
    (9, 2, 'Duda/Janda'),
    (9, 3, 'Menikah'),
    (9, 4, 'Menikah dengan tanggungan'),
    (9, 5, 'Menikah, banyak tanggungan');

-- C5.1 Kepemilikan Tanah (cost)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (10, 1, 'Milik Sendiri Bersertifikat'),
    (10, 2, 'Milik Sendiri Tidak Bersertifikat'),
    (10, 3, 'Sewa'),
    (10, 4, 'Menumpang'),
    (10, 5, 'Tanah Negara/Sengketa');

-- C5.2 Status Kepemilikan Rumah (cost)
INSERT IGNORE INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES
    (11, 1, 'Milik Sendiri'),
    (11, 2, 'Waris'),
    (11, 3, 'Kontrak/Sewa'),
    (11, 4, 'Menumpang Keluarga'),
    (11, 5, 'Rumah Dinas/Fasilitas');
