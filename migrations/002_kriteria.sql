CREATE TABLE IF NOT EXISTS kriteria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    sifat ENUM('cost', 'benefit') NOT NULL,
    bobot DECIMAL(5, 2) NOT NULL,
    penjelasan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- Data Awal Kriteria
INSERT IGNORE INTO kriteria (kode, nama, sifat, bobot, penjelasan)
VALUES (
        'C1',
        'Penghasilan',
        'cost',
        0.30,
        'Semakin kecil penghasilan, semakin prioritas.'
    ),
    (
        'C2',
        'Pekerjaan',
        'cost',
        0.25,
        'Jenis pekerjaan tidak tetap/serabutan lebih diprioritaskan.'
    ),
    (
        'C3',
        'Kondisi Rumah',
        'cost',
        0.15,
        'Rumah yang tidak layak huni mendapat prioritas tinggi.'
    ),
    (
        'C4',
        'Jumlah Anak',
        'benefit',
        0.15,
        'Semakin banyak anak (tanggungan), semakin prioritas.'
    ),
    (
        'C5',
        'Kepemilikan Aset',
        'cost',
        0.15,
        'Aset yang dimiliki semakin kecil maka semakin layak untuk menerima.'
    );