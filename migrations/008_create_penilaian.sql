CREATE TABLE IF NOT EXISTS penilaian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alternatif_id INT NOT NULL,
    sub_kriteria_id INT NOT NULL,
    nilai DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY (alternatif_id, sub_kriteria_id),
    FOREIGN KEY (alternatif_id) REFERENCES alternatif(id) ON DELETE CASCADE,
    FOREIGN KEY (sub_kriteria_id) REFERENCES sub_kriteria(id) ON DELETE CASCADE
);
