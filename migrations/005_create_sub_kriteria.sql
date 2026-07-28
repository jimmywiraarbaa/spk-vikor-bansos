CREATE TABLE IF NOT EXISTS sub_kriteria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kriteria_id INT NOT NULL,
    nama VARCHAR(255) NOT NULL,
    bobot INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kriteria_id) REFERENCES kriteria(id) ON DELETE CASCADE
);

-- C1 Penghasilan (cost, Wi = 0.30)
INSERT IGNORE INTO sub_kriteria (kriteria_id, nama, bobot) VALUES
    (1, '> Rp 3.000.000', 1),
    (1, 'Rp 2.000.001 - Rp 3.000.000', 2),
    (1, 'Rp 1.000.001 - Rp 2.000.000', 3),
    (1, 'Rp 500.001 - Rp 1.000.000', 4),
    (1, '<= Rp 500.000', 5);

-- C2 Pekerjaan (cost, Wi = 0.25)
INSERT IGNORE INTO sub_kriteria (kriteria_id, nama, bobot) VALUES
    (2, 'PNS/TNI/Polri', 1),
    (2, 'Pegawai Swasta Tetap', 2),
    (2, 'Wiraswasta', 3),
    (2, 'Pekerja Harian Lepas', 4),
    (2, 'Tidak Bekerja', 5);

-- C3 Kondisi Rumah (cost, Wi = 0.15) — Kategori Gabungan
INSERT IGNORE INTO sub_kriteria (kriteria_id, nama, bobot) VALUES
    (3, 'Sangat Layak Huni', 1),
    (3, 'Layak Huni', 2),
    (3, 'Cukup Layak', 3),
    (3, 'Kurang Layak', 4),
    (3, 'Tidak Layak Huni', 5);

-- C4 Jumlah Anak (benefit, Wi = 0.15)
INSERT IGNORE INTO sub_kriteria (kriteria_id, nama, bobot) VALUES
    (4, '0 - 1 orang', 1),
    (4, '2 orang', 2),
    (4, '3 orang', 3),
    (4, '4 orang', 4),
    (4, '> 4 orang', 5);

-- C5 Kepemilikan Aset (cost, Wi = 0.15)
INSERT IGNORE INTO sub_kriteria (kriteria_id, nama, bobot) VALUES
    (5, 'Memiliki banyak aset berharga', 1),
    (5, 'Memiliki beberapa aset', 2),
    (5, 'Memiliki aset terbatas', 3),
    (5, 'Sedikit aset', 4),
    (5, 'Tidak memiliki aset', 5);
