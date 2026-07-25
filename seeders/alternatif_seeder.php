<?php
require_once __DIR__ . '/../includes/db.php';

$pdo->exec("DELETE FROM alternatif");

$data = [
    ['Syafruddin', '1505651509010001', 'Jl. Diponegoro No. 45', '002/003', 'Dusun Bangko', 'Bangko', '0812-7654-3210'],
    ['Sarifah', '4512701509010002', 'Jl. Jendral Sudirman No. 12', '001/002', 'Pasar Atas', 'Bangko', '0852-5678-1234'],
    ['Sugiyono', '1203721509010003', 'Jl. Imam Bonjol No. 8', '003/001', 'Pasar Bangko', 'Bangko', '0813-4321-9876'],
    ['Nurhayati', '6508681509010004', 'Jl. Pematang Kandis No. 3', '003/002', 'Pematang Kandis', 'Bangko', '0856-7890-4321'],
    ['Suparman', '0906661509010005', 'Dusun Mudo RT 2', '004/003', 'Dusun Mudo', 'Bangko', '0822-5656-7878'],
    ['Wahyuni', '4405781509020001', 'Bedeng Rejo RT 1', '001/001', 'Bedeng Rejo', 'Bangko Barat', '0838-3434-5656'],
    ['Mukhtar', '0809751509020002', 'Biuku Tanjung No. 15', '002/001', 'Biuku Tanjung', 'Bangko Barat', '0812-1122-3344'],
    ['Ernita', '4811801509020003', 'Bukit Beringin No. 7', '001/002', 'Bukit Beringin', 'Bangko Barat', '0853-9988-7766'],
    ['Sutrisno', '1006671509030001', 'Baru Nalo RT 3', '003/002', 'Baru Nalo', 'Batang Masumai', '0857-6655-4433'],
    ['Rohani', '3009721509030002', 'Kederasan Panjang No. 11', '002/004', 'Kederasan Panjang', 'Batang Masumai', '0821-5544-3322'],
    ['Syamsul Bahri', '1504701509030003', 'Lubuk Gaung No. 6', '004/001', 'Lubuk Gaung', 'Batang Masumai', '0812-4545-6767'],
    ['Siti Aminah', '4408751509030004', 'Nibung RT 2', '005/002', 'Nibung', 'Batang Masumai', '0852-8989-1212'],
    ['Yulizal', '1503711509040001', 'Koto Rawang No. 9', '001/002', 'Koto Rawang', 'Jangkat', '0813-7788-9900'],
    ['Marlina', '5212751509040002', 'Koto Renah RT 1', '002/001', 'Koto Renah', 'Jangkat', '0852-3434-5656'],
    ['Edi Sofyan', '2201881509040003', 'Lubuk Mantilin No. 14', '003/003', 'Lubuk Mantilin', 'Jangkat', '0822-7788-1122'],
    ['Sumarni', '6703791509050001', 'Buluran Panjang RT 2', '004/001', 'Buluran Panjang', 'Margo Tabir', '0838-5566-7788'],
    ['Rahman', '0605731509050002', 'Kampung Main No. 8', '001/002', 'Kampung Main', 'Margo Tabir', '0857-5656-7878'],
    ['Hendra Gunawan', '1805851509050003', 'Lubuk Bumbun No. 3', '002/003', 'Lubuk Bumbun', 'Margo Tabir', '0857-1212-3434'],
    ['Rosmiati', '4609731509060001', 'Muara Siau No. 22', '001/001', 'Muara Siau', 'Muara Siau', '0812-9988-7766'],
    ['Joko Susilo', '0301781509060002', 'Pasar Muara Siau No. 5', '003/001', 'Pasar Muara Siau', 'Muara Siau', '0853-4455-6677'],
    ['Yurni', '5407901509060003', 'Lubuk Beringin RT 1', '002/002', 'Lubuk Beringin', 'Muara Siau', '0821-6677-8899'],
    ['Rismawati', '4702911509060004', 'Air Lago No. 12', '004/001', 'Air Lago', 'Muara Siau', '0813-6767-8989'],
    ['Asmuni', '1009691509070001', 'Aur Berduri No. 7', '001/002', 'Aur Berduri', 'Nalo Tantan', '0812-3344-5566'],
    ['Misliah', '4205801509070002', 'Baru Nalo RT 3', '003/001', 'Baru Nalo', 'Nalo Tantan', '0856-7788-9900'],
    ['Darwis', '1507711509070003', 'Danau No. 4', '002/003', 'Danau', 'Nalo Tantan', '0838-1122-3344'],
    ['Tasmi', '6006681509080001', 'Pamenang No. 18', '004/002', 'Pamenang', 'Pamenang', '0822-4455-6677'],
    ['Suharto', '1009551509080002', 'Empang Benao RT 2', '001/002', 'Empang Benao', 'Pamenang', '0856-5656-3434'],
    ['Joni Saputra', '0511921509080003', 'Jelatang No. 9', '002/001', 'Jelatang', 'Pamenang', '0852-6767-8899'],
    ['Fitri Yani', '4408881509080004', 'Karang Anyar RT 1', '003/003', 'Karang Anyar', 'Pamenang', '0813-2233-4455'],
    ['Mahyuddin', '1203741509090001', 'Buluh Kaso No. 16', '001/001', 'Buluh Kaso', 'Pamenang Selatan', '0857-8899-0011'],
    ['Dewi Anggraini', '4805921509090002', 'Panca Karya RT 2', '002/002', 'Panca Karya', 'Pamenang Selatan', '0821-3344-5566'],
    ['Eko Prasetyo', '1704871509090003', 'Pulau Bayur No. 11', '003/002', 'Pulau Bayur', 'Pamenang Selatan', '0812-5566-7788'],
    ['Nurbaiti', '5103721509100001', 'Baru Pangkalan Jambu RT 1', '002/001', 'Baru Pangkalan Jambu', 'Pangkalan Jambu', '0853-6677-8899'],
    ['Rusdi Tahir', '0909651509100002', 'Bukit Perentak No. 8', '001/002', 'Bukit Perentak', 'Pangkalan Jambu', '0856-9900-1122'],
    ['Ahmad Rifai', '1106801509100003', 'Bungo Tanjung No. 20', '003/003', 'Bungo Tanjung', 'Pangkalan Jambu', '0813-5566-7788'],
    ['Zurnila', '5001761509100004', 'Tanjung Mudo RT 2', '004/001', 'Tanjung Mudo', 'Pangkalan Jambu', '0822-9988-7766'],
    ['Marsudi', '1507621509110001', 'Air Batu No. 14', '001/003', 'Air Batu', 'Renah Pembarap', '0857-3434-5656'],
    ['Yetti Antini', '4910871509110002', 'Guguk RT 1', '002/001', 'Guguk', 'Renah Pembarap', '0821-4545-6767'],
    ['Alfaiz Nazaruddin', '2010901509110003', 'Muara Bantan No. 6', '005/002', 'Muara Bantan', 'Renah Pembarap', '0812-7878-9090'],
    ['Hayati', '4203731509110004', 'Renah Medan No. 10', '003/003', 'Renah Medan', 'Renah Pembarap', '0853-1212-3434'],
    ['Darwin Siregar', '0805711509120001', 'Benteng No. 15', '002/003', 'Benteng', 'Sungai Manau', '0838-7676-5454'],
    ['Akhyar', '1006681509120002', 'Bukit Batu No. 3', '001/001', 'Bukit Batu', 'Sungai Manau', '0852-4545-6767'],
    ['Rina Wati', '4709821509120003', 'Durian Lecah RT 2', '002/002', 'Durian Lecah', 'Sungai Manau', '0813-9090-1212'],
    ['Ramli', '0303751509120004', 'Gelanggang No. 8', '003/001', 'Gelanggang', 'Sungai Manau', '0856-3434-7878'],
    ['Suhardi', '1207771509130001', 'Dusun Baru No. 11', '001/002', 'Dusun Baru', 'Tabir', '0812-6767-5454'],
    ['Amlah', '4309681509130002', 'Kampung Baruh RT 1', '002/003', 'Kampung Baruh', 'Tabir', '0857-2323-4545'],
    ['Heri Setiawan', '2811851509130003', 'Pasar Baru Rantau No. 7', '003/001', 'Pasar Baru Rantau', 'Tabir', '0821-8989-7676'],
    ['Fadli Ahmad', '0902881509130004', 'Kandang No. 16', '004/002', 'Kandang', 'Tabir', '0853-5656-7878'],
    ['Yusnidar', '5303791509130005', 'Koto Rayo RT 2', '005/001', 'Koto Rayo', 'Tabir', '0812-3434-9090'],
    ['Mulyadi', '1605691509140001', 'Bungo Tanjung No. 5', '001/001', 'Bungo Tanjung', 'Tabir Selatan', '0856-1212-3434'],
    ['Zainuddin', '1104621509140002', 'Gading Jaya RT 3', '002/002', 'Gading Jaya', 'Tabir Selatan', '0813-7878-1212'],
    ['Sulastri', '4807741509140003', 'Mekar Jaya No. 12', '003/001', 'Mekar Jaya', 'Tabir Selatan', '0852-5656-3434'],
    ['Darmansyah', '0508811509150001', 'Kapuk No. 9', '001/003', 'Kapuk', 'Tabir Ulu', '0838-9090-7878'],
    ['Kamarruddin', '0301661509150002', 'Medan Baru RT 1', '002/001', 'Medan Baru', 'Tabir Ulu', '0853-7878-1212'],
    ['Basri Talif', '1407701509150003', 'Muara Jernih No. 14', '003/002', 'Muara Jernih', 'Tabir Ulu', '0812-8989-6767'],
    ['Juita', '4511851509160001', 'Air Liki RT 2', '001/002', 'Air Liki', 'Tabir Barat', '0857-4545-2323'],
    ['Hendri Kusuma', '2002931509160002', 'Baru Kibul No. 6', '002/002', 'Baru Kibul', 'Tabir Barat', '0821-1212-9090'],
    ['Holidin', '0803761509160003', 'Tanjung Beringin No. 10', '003/001', 'Tanjung Beringin', 'Tabir Barat', '0853-6767-8989'],
    ['Maslida', '5106681509170001', 'Bukit Subur RT 1', '001/001', 'Bukit Subur', 'Tabir Timur', '0813-2323-4545'],
    ['Adi Putra', '1201901509170002', 'Sungai Bulian No. 8', '002/001', 'Sungai Bulian', 'Tabir Timur', '0856-7878-1212'],
];

$stmt = $pdo->prepare("INSERT INTO alternatif (nama, nik, alamat, rt_rw, kelurahan, kecamatan, no_hp) VALUES (?, ?, ?, ?, ?, ?, ?)");

$jumlah = 0;
foreach ($data as $row) {
    $stmt->execute($row);
    $jumlah++;
    echo "Alternatif '{$row[0]}' ({$row[5]}) berhasil ditambahkan.\n";
}

echo "\nSelesai. Total {$jumlah} alternatif ditambahkan.\n";
