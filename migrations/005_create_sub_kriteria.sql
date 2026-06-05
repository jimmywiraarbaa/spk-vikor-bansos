CREATE TABLE IF NOT EXISTS sub_kriteria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kriteria_id INT NOT NULL,
    kode VARCHAR(10) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    bobot DECIMAL(5, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kriteria_id) REFERENCES kriteria(id) ON DELETE CASCADE
);

INSERT IGNORE INTO sub_kriteria (kriteria_id, kode, nama, bobot) VALUES
    (1, 'C1.1', 'Penghasilan per Bulan', 0.60),
    (1, 'C1.2', 'Sumber Penghasilan', 0.40),
    (2, 'C2.1', 'Jenis Pekerjaan', 0.50),
    (2, 'C2.2', 'Status Pekerjaan', 0.50),
    (3, 'C3.1', 'Jenis Lantai', 0.40),
    (3, 'C3.2', 'Jenis Dinding', 0.30),
    (3, 'C3.3', 'Luas Rumah', 0.30),
    (4, 'C4.1', 'Jumlah Tanggungan', 0.60),
    (4, 'C4.2', 'Status Pernikahan', 0.40),
    (5, 'C5.1', 'Kepemilikan Tanah', 0.60),
    (5, 'C5.2', 'Status Kepemilikan Rumah', 0.40);
