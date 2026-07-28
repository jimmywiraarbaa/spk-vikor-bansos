-- Migration: Restructure sub_kriteria (flat model)
-- 1. Drop kolom lama (kode, skala_1..skala_5 jika ada)
-- 2. Ubah tipe bobot menjadi INT (1-5)
-- 3. Kosongkan & isi ulang data sub_kriteria (25 baris, 5 per kriteria)
-- 4. Update C5 di kriteria
-- 5. Bersihkan data penilaian & hasil lama
-- 6. Hapus tabel skala_penilaian

-- 1. Drop kolom kode
ALTER TABLE sub_kriteria DROP COLUMN kode;

-- 2. Drop kolom skala_1..skala_5 jika ada (dari migrasi sebelumnya yang dibatalkan)
SET @s = CONCAT('SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ''sub_kriteria'' AND COLUMN_NAME = ''skala_1'' LIMIT 1');
-- Gunakan prepared statement untuk drop kolom skala jika ada
SET @drop_skala = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE sub_kriteria DROP COLUMN skala_1, DROP COLUMN skala_2, DROP COLUMN skala_3, DROP COLUMN skala_4, DROP COLUMN skala_5', 'SELECT 1') FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'sub_kriteria' AND COLUMN_NAME = 'skala_1');
PREPARE stmt FROM @drop_skala;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 3. Ubah tipe kolom bobot menjadi INT (1-5)
ALTER TABLE sub_kriteria MODIFY COLUMN bobot INT NOT NULL;

-- 4. Kosongkan data lama & isi ulang
DELETE FROM sub_kriteria;

-- C1 Penghasilan
INSERT INTO sub_kriteria (kriteria_id, nama, bobot) VALUES
    (1, '> Rp 3.000.000', 1),
    (1, 'Rp 2.000.001 - Rp 3.000.000', 2),
    (1, 'Rp 1.000.001 - Rp 2.000.000', 3),
    (1, 'Rp 500.001 - Rp 1.000.000', 4),
    (1, '<= Rp 500.000', 5);

-- C2 Pekerjaan
INSERT INTO sub_kriteria (kriteria_id, nama, bobot) VALUES
    (2, 'PNS/TNI/Polri', 1),
    (2, 'Pegawai Swasta Tetap', 2),
    (2, 'Wiraswasta', 3),
    (2, 'Pekerja Harian Lepas', 4),
    (2, 'Tidak Bekerja', 5);

-- C3 Kondisi Rumah
INSERT INTO sub_kriteria (kriteria_id, nama, bobot) VALUES
    (3, 'Sangat Layak Huni', 1),
    (3, 'Layak Huni', 2),
    (3, 'Cukup Layak', 3),
    (3, 'Kurang Layak', 4),
    (3, 'Tidak Layak Huni', 5);

-- C4 Jumlah Anak
INSERT INTO sub_kriteria (kriteria_id, nama, bobot) VALUES
    (4, '0 - 1 orang', 1),
    (4, '2 orang', 2),
    (4, '3 orang', 3),
    (4, '4 orang', 4),
    (4, '> 4 orang', 5);

-- C5 Kepemilikan Aset
INSERT INTO sub_kriteria (kriteria_id, nama, bobot) VALUES
    (5, 'Memiliki banyak aset berharga', 1),
    (5, 'Memiliki beberapa aset', 2),
    (5, 'Memiliki aset terbatas', 3),
    (5, 'Sedikit aset', 4),
    (5, 'Tidak memiliki aset', 5);

-- 5. Update C5 di kriteria (Status Tanah -> Kepemilikan Aset)
UPDATE kriteria SET nama = 'Kepemilikan Aset', penjelasan = 'Aset yang dimiliki semakin kecil maka semakin layak untuk menerima.' WHERE kode = 'C5';

-- 6. Hapus data penilaian lama (struktur sub_kriteria berubah)
DELETE FROM penilaian;

-- 7. Hapus hasil perhitungan lama
DELETE FROM hasil_perhitungan;

-- 8. Drop tabel skala_penilaian
DROP TABLE IF EXISTS skala_penilaian;
