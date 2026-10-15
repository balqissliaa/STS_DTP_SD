<?php
require_once "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama_pelapor"];
    $fasilitas = $_POST["nama_fasilitas"];
    $lokasi = $_POST["lokasi"];
    $kategori = $_POST["id_kategori"];
    $deskripsi = $_POST["deskripsi"];
    $prioritas = $_POST["prioritas"];

    $sql = "INSERT INTO laporan_kerusakan
            (nama_pelapor, nama_fasilitas, lokasi, id_kategori,
             deskripsi, prioritas, status)
            VALUES (?, ?, ?, ?, ?, ?, 'Menunggu')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $nama, $fasilitas, $lokasi,
        $kategori, $deskripsi, $prioritas
    ]);

    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}
$sql = "SELECT
            kategori_fasilitas.nama_kategori,
            laporan_kerusakan.nama_pelapor,
            laporan_kerusakan.nama_fasilitas,
            laporan_kerusakan.lokasi,
            laporan_kerusakan.deskripsi,
            laporan_kerusakan.prioritas,
            laporan_kerusakan.status,
            laporan_kerusakan.tanggal_laporan
        FROM kategori_fasilitas
        INNER JOIN laporan_kerusakan
        ON kategori_fasilitas.id_kategori =
           laporan_kerusakan.id_kategori";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Kerusakan Fasilitas Sekolah</title>
    <!-- TANTANGAN UI/UX: Tambahkan styling CSS, Bootstrap, atau Tailwind sendiri. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
    crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" 
    integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" 
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Bagian ini merupakan starter HTML. Belum ada koneksi database ataupun query. -->
    <header>
        <h1>Sistem Pelaporan Kerusakan Fasilitas Sekolah</h1>
        <p>Catat dan pantau laporan kerusakan fasilitas sekolah.</p>
        <nav aria-label="Navigasi utama">
            <a href="#form-laporan">Buat Laporan</a>
            <a href="#daftar-laporan">Daftar Laporan</a>
        </nav>
    </header>

    <main>
        <section id="form-laporan" aria-labelledby="judul-form">
            <h2 id="judul-form">Form Pelaporan Kerusakan</h2>
            <p>Lengkapi data berikut untuk melaporkan fasilitas yang rusak.</p>

            <!-- TANTANGAN BONUS CREATE: Buat proses PHP agar POST menyimpan data. -->
            <form action="" method="post">
                <fieldset>
                    <legend>Data Pelaporan</legend>

                    <p>
                        <label for="nama_pelapor" class="form-label">Nama pelapor</label>
                        <input type="text" id="nama_pelapor" name="nama_pelapor" class="form-control" maxlength="100" required>
                    </p>

                    <p>
                        <label for="nama_fasilitas" class="form-label">Nama fasilitas</label>
                        <input type="text" id="nama_fasilitas" name="nama_fasilitas" class="form-control" maxlength="100" required>
                    </p>

                    <p>
                        <label for="lokasi" class="form-label">Lokasi kerusakan</label>
                        <input type="text" id="lokasi" name="lokasi" class="form-control" maxlength="100" required>
                    </p>

                    <p>
                        <label for="id_kategori" class="form-label">Kategori fasilitas</label>
                        <select id="id_kategori" name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih kategori --</option>
                            <!-- Nilai berikut sesuai dengan data awal kategori_fasilitas. -->
                            <option value="1">Elektronik</option>
                            <option value="2">Furnitur</option>
                            <option value="3">Jaringan</option>
                            <option value="4">Peralatan Kelas</option>
                        </select>
                    </p>

                    <p>
                        <label for="deskripsi" class="form-label">Deskripsi kerusakan</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" required></textarea>
                    </p>

                    <p>
                        <label for="prioritas" class="form-label">Prioritas</label>
                        <select id="prioritas" name="prioritas" class="form-select" required>
                            <option value="">-- Pilih prioritas --</option>
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </p>

                    <p><button type="submit" class="btn btn-ungu">
                        Kirim Laporan</button></p>
                </fieldset>
            </form>
        </section>

        <section id="daftar-laporan" aria-labelledby="judul-daftar">
            <h2 id="judul-daftar">Daftar Laporan Kerusakan</h2>
            <p>Seluruh laporan yang tercatat pada database ditampilkan di bagian ini.</p>

            <!-- TANTANGAN WAJIB:
                 1. Buat sendiri koneksi PHP ke MySQL.
                 2. Jalankan query SELECT untuk mengambil data dari laporan_kerusakan.
                 3. Ganti baris placeholder pada tbody dengan perulangan hasil query.
                 4. Jangan mengetik data database secara manual di HTML.
            -->
            <table>
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Fasilitas</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Pelapor</th>
                        <th scope="col">Prioritas</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php if (count($result) > 0): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row["nama_fasilitas"]) ?></td>
                                <td><?= htmlspecialchars($row["lokasi"]) ?></td>
                                <td><?= htmlspecialchars($row["nama_pelapor"]) ?></td>
                                <td><?= htmlspecialchars($row["prioritas"]) ?></td>
                                <td><?= htmlspecialchars($row["status"]) ?></td>
                                <td><?= htmlspecialchars($row["tanggal_laporan"]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data laporan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Sistem Pelaporan Kerusakan Fasilitas Sekolah.</p>
    </footer>
</body>
</html>
