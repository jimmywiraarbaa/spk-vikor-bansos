CREATE TABLE IF NOT EXISTS hasil_perhitungan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alternatif_id INT NOT NULL,
    nilai_s DECIMAL(15,6) NOT NULL,
    nilai_r DECIMAL(15,6) NOT NULL,
    nilai_q DECIMAL(15,6) NOT NULL,
    ranking INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (alternatif_id) REFERENCES alternatif(id) ON DELETE CASCADE
);
