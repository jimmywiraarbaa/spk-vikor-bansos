<?php
require_once __DIR__ . '/../includes/db.php';

$pdo->exec("DELETE FROM alternatif");

$data = [
    ['Syafruddin', '1505651509010001', 'Jl. Talangkawo No. 45', '002/003', 'Dusun Bangko', 'Bangko', '0812-7654-3210'],
    ['Sarifah', '4512701509010002', 'Jl. Jend. Sudirman No. 12', '001/002', 'Pasar Atas', 'Bangko', '0852-5678-1234'],
    ['Sugiyono', '1203721509010003', 'Jl. Rangkayo Hitam No. 8', '003/001', 'Pasar Bangko', 'Bangko', '0813-4321-9876'],
    ['Nurhayati', '6508681509010004', 'Jl. R. Kadipan No. 17', '003/002', 'Pematang Kandis', 'Bangko', '0856-7890-4321'],
    ['Suparman', '0906661509010005', 'Jl. Kebun Kelapa No. 23', '004/003', 'Dusun Mudo', 'Bangko', '0822-5656-7878'],
    ['Wahyuni', '4405781509020001', 'Jl. Raya Bangko-Kerinci KM 8, Dusun II', '001/001', 'Bedeng Rejo', 'Bangko Barat', '0838-3434-5656'],
    ['Mukhtar', '0809751509020002', 'Jl. Lintas Sumatera KM 5, Dusun I', '002/001', 'Biuku Tanjung', 'Bangko Barat', '0812-1122-3344'],
    ['Ernita', '4811801509020003', 'Jl. Raya Bangko-Kerinci KM 11, Dusun III', '001/002', 'Bukit Beringin', 'Bangko Barat', '0853-9988-7766'],
    ['Sutrisno', '1006671509030001', 'Dusun I, RT 03/RW 02', '003/002', 'Baru Nalo', 'Batang Masumai', '0857-6655-4433'],
    ['Rohani', '3009721509030002', 'Dusun II, RT 02/RW 01', '002/004', 'Kederasan Panjang', 'Batang Masumai', '0821-5544-3322'],
    ['Syamsul Bahri', '1504701509030003', 'Jl. Lintas Sumatera KM 14, Dusun I', '004/001', 'Lubuk Gaung', 'Batang Masumai', '0812-4545-6767'],
    ['Siti Aminah', '4408751509030004', 'Dusun III, RT 04/RW 02', '005/002', 'Nibung', 'Batang Masumai', '0852-8989-1212'],
    ['Yulizal', '1503711509040001', 'Dusun II, RT 01/RW 01', '001/002', 'Koto Rawang', 'Jangkat', '0813-7788-9900'],
    ['Marlina', '5212751509040002', 'Dusun I, RT 03/RW 02', '002/001', 'Koto Renah', 'Jangkat', '0852-3434-5656'],
    ['Edi Sofyan', '2201881509040003', 'Dusun III, RT 02/RW 01', '003/003', 'Lubuk Mantilin', 'Jangkat', '0822-7788-1122'],
    ['Sumarni', '6703791509050001', 'Jl. Lintas Sumatera KM 9, Dusun II', '004/001', 'Buluran Panjang', 'Margo Tabir', '0838-5566-7788'],
    ['Rahman', '0605731509050002', 'Dusun I, RT 02/RW 01', '001/002', 'Kampung Main', 'Margo Tabir', '0857-5656-7878'],
    ['Hendra Gunawan', '1805851509050003', 'Dusun III, RT 01/RW 02', '002/003', 'Lubuk Bumbun', 'Margo Tabir', '0857-1212-3434'],
    ['Rosmiati', '4609731509060001', 'Jl. Raya Muara Hemat KM 2, Dusun I', '001/001', 'Muara Siau', 'Muara Siau', '0812-9988-7766'],
    ['Joko Susilo', '0301781509060002', 'Jl. Pasar Lama No. 5, Dusun II', '003/001', 'Pasar Muara Siau', 'Muara Siau', '0853-4455-6677'],
    ['Yurni', '5407901509060003', 'Dusun I, RT 02/RW 01', '002/002', 'Lubuk Beringin', 'Muara Siau', '0821-6677-8899'],
    ['Rismawati', '4702911509060004', 'Dusun II, RT 03/RW 01', '004/001', 'Air Lago', 'Muara Siau', '0813-6767-8989'],
    ['Asmuni', '1009691509070001', 'Dusun II, RT 01/RW 01', '001/002', 'Aur Berduri', 'Nalo Tantan', '0812-3344-5566'],
    ['Misliah', '4205801509070002', 'Dusun I, RT 03/RW 02', '003/001', 'Baru Nalo', 'Nalo Tantan', '0856-7788-9900'],
    ['Darwis', '1507711509070003', 'Dusun III, RT 02/RW 01', '002/003', 'Danau', 'Nalo Tantan', '0838-1122-3344'],
    ['Tasmi', '6006681509080001', 'Jl. Lintas Sumatera KM 4, Dusun II', '004/002', 'Pamenang', 'Pamenang', '0822-4455-6677'],
    ['Suharto', '1009551509080002', 'Dusun I, RT 02/RW 01', '001/002', 'Empang Benao', 'Pamenang', '0856-5656-3434'],
    ['Joni Saputra', '0511921509080003', 'Jl. Lintas Sumatera KM 6, Dusun III', '002/001', 'Jelatang', 'Pamenang', '0852-6767-8899'],
    ['Fitri Yani', '4408881509080004', 'Dusun II, RT 01/RW 02', '003/003', 'Karang Anyar', 'Pamenang', '0813-2233-4455'],
    ['Mahyuddin', '1203741509090001', 'Dusun I, RT 02/RW 01', '001/001', 'Buluh Kaso', 'Pamenang Selatan', '0857-8899-0011'],
    ['Dewi Anggraini', '4805921509090002', 'Dusun II, RT 01/RW 02', '002/002', 'Panca Karya', 'Pamenang Selatan', '0821-3344-5566'],
    ['Eko Prasetyo', '1704871509090003', 'Jl. Lintas Sumatera KM 8, Dusun I', '003/002', 'Pulau Bayur', 'Pamenang Selatan', '0812-5566-7788'],
    ['Nurbaiti', '5103721509100001', 'Jl. Lintas Bangko-Kerinci KM 22, Dusun I', '002/001', 'Baru Pangkalan Jambu', 'Pangkalan Jambu', '0853-6677-8899'],
    ['Rusdi Tahir', '0909651509100002', 'Jl. Penurunan Bedeng XII KM 3, Dusun II', '001/002', 'Bukit Perentak', 'Pangkalan Jambu', '0856-9900-1122'],
    ['Ahmad Rifai', '1106801509100003', 'Dusun III, RT 02/RW 01', '003/003', 'Bungo Tanjung', 'Pangkalan Jambu', '0813-5566-7788'],
    ['Zurnila', '5001761509100004', 'Dusun I, RT 03/RW 02', '004/001', 'Tanjung Mudo', 'Pangkalan Jambu', '0822-9988-7766'],
    ['Marsudi', '1507621509110001', 'Jl. Raya Bangko-Kerinci KM 12, Dusun II', '001/003', 'Air Batu', 'Renah Pembarap', '0857-3434-5656'],
    ['Yetti Antini', '4910871509110002', 'Dusun I, RT 02/RW 01', '002/001', 'Guguk', 'Renah Pembarap', '0821-4545-6767'],
    ['Alfaiz Nazaruddin', '2010901509110003', 'Dusun III, RT 01/RW 02', '005/002', 'Muara Bantan', 'Renah Pembarap', '0812-7878-9090'],
    ['Hayati', '4203731509110004', 'Jl. Raya Bangko-Kerinci KM 15, Dusun I', '003/003', 'Renah Medan', 'Renah Pembarap', '0853-1212-3434'],
    ['Darwin Siregar', '0805711509120001', 'Jl. Sungai Manau KM 3, Dusun II', '002/003', 'Benteng', 'Sungai Manau', '0838-7676-5454'],
    ['Akhyar', '1006681509120002', 'Jl. Sungai Nilau No. 3, Dusun I', '001/001', 'Bukit Batu', 'Sungai Manau', '0852-4545-6767'],
    ['Rina Wati', '4709821509120003', 'Jl. Sungai Manau KM 5, Dusun III', '002/002', 'Durian Lecah', 'Sungai Manau', '0813-9090-1212'],
    ['Ramli', '0303751509120004', 'Jl. Raya Muara Hemat KM 7, Dusun I', '003/001', 'Gelanggang', 'Sungai Manau', '0856-3434-7878'],
    ['Suhardi', '1207771509130001', 'Jl. Sako No. 11, Dusun I', '001/002', 'Dusun Baru', 'Tabir', '0812-6767-5454'],
    ['Amlah', '4309681509130002', 'Jl. Sako KM 2, Dusun II', '002/003', 'Kampung Baruh', 'Tabir', '0857-2323-4545'],
    ['Heri Setiawan', '2811851509130003', 'Jl. Lintas Sumatera KM 18, Dusun I', '003/001', 'Pasar Baru Rantau', 'Tabir', '0821-8989-7676'],
    ['Fadli Ahmad', '0902881509130004', 'Jl. Penurunan Bedeng XII KM 1, Dusun I', '004/002', 'Kandang', 'Tabir', '0853-5656-7878'],
    ['Yusnidar', '5303791509130005', 'Jl. Sako KM 4, Dusun III', '005/001', 'Koto Rayo', 'Tabir', '0812-3434-9090'],
    ['Mulyadi', '1605691509140001', 'Dusun II, RT 01/RW 01', '001/001', 'Bungo Tanjung', 'Tabir Selatan', '0856-1212-3434'],
    ['Zainuddin', '1104621509140002', 'Dusun I, RT 03/RW 02', '002/002', 'Gading Jaya', 'Tabir Selatan', '0813-7878-1212'],
    ['Sulastri', '4807741509140003', 'Dusun III, RT 02/RW 01', '003/001', 'Mekar Jaya', 'Tabir Selatan', '0852-5656-3434'],
    ['Darmansyah', '0508811509150001', 'Dusun I, RT 01/RW 01', '001/003', 'Kapuk', 'Tabir Ulu', '0838-9090-7878'],
    ['Kamarruddin', '0301661509150002', 'Dusun II, RT 02/RW 01', '002/001', 'Medan Baru', 'Tabir Ulu', '0853-7878-1212'],
    ['Basri Talif', '1407701509150003', 'Dusun I, RT 03/RW 02', '003/002', 'Muara Jernih', 'Tabir Ulu', '0812-8989-6767'],
    ['Juita', '4511851509160001', 'Dusun II, RT 01/RW 02', '001/002', 'Air Liki', 'Tabir Barat', '0857-4545-2323'],
    ['Hendri Kusuma', '2002931509160002', 'Dusun I, RT 02/RW 02', '002/002', 'Baru Kibul', 'Tabir Barat', '0821-1212-9090'],
    ['Holidin', '0803761509160003', 'Dusun III, RT 01/RW 01', '003/001', 'Tanjung Beringin', 'Tabir Barat', '0853-6767-8989'],
    ['Maslida', '5106681509170001', 'Dusun I, RT 01/RW 01', '001/001', 'Bukit Subur', 'Tabir Timur', '0813-2323-4545'],
    ['Adi Putra', '1201901509170002', 'Dusun II, RT 02/RW 01', '002/001', 'Sungai Bulian', 'Tabir Timur', '0856-7878-1212'],
];

$stmt = $pdo->prepare("INSERT INTO alternatif (nama, nik, alamat, rt_rw, kelurahan, kecamatan, no_hp) VALUES (?, ?, ?, ?, ?, ?, ?)");

$jumlah = 0;
foreach ($data as $row) {
    $stmt->execute($row);
    $jumlah++;
    echo "Alternatif '{$row[0]}' ({$row[5]}) berhasil ditambahkan.\n";
}

echo "\nSelesai. Total {$jumlah} alternatif ditambahkan.\n";
