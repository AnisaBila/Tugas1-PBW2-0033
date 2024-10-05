<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOKO BERKAH JAYA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>

        //membuat fungsi pada input penjualan
        function toggleakunmember() {
            var StatusM = document.getElementById('member').value;
            var nameField = document.getElementById('nameField');

            if (StatusM === 'yes') {
                nameField.style.display = 'flex'; 
            } else {
                nameField.style.display = 'none'; // Jika pembeli non member fieldnama tidak muncul
            }
        }
        window.onload = function() {
            toggleakunmember();
        };
    </script>
</head>
<body>
    <!-- Pembuatan inputan data pembelian -->
    <div class="container mt-5">
        <h2 class="mb-4">Input Data Pembelian</h2>
        <form method="POST" action="">
            <div class="mb-3" style="display: flex; align-items: center;">
                <label for="barang" class="form-label" style="width: 100px; margin-right: 10px;">Barang:</label>
                <input type="text" class="form-control" id="barang" name="barang" required style="width: 450px;">
            </div>
            <div class="mb-3" style="display: flex; align-items: center;">
                <label for="harga" class="form-label" style="width: 100px; margin-right: 10px;">Harga Barang Per-Item:</label>
                <input type="text" class="form-control" id="harga" name="harga" required style="width: 450px;">
            </div>
            <div class="mb-3" style="display: flex; align-items: center;">
                <label for="jumlah" class="form-label" style="width: 100px; margin-right: 10px;">Jumlah Barang:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" required style="width: 450px;">
            </div>
            <div class="mb-3" style="display: flex; align-items: center;">
                <label for="member" class="form-label" style="width: 100px; margin-right: 10px;">Status Member:</label>
                <select class="form-select" id="member" name="member" onchange="toggleakunmember()" required style="width: 450px;">
                    <option value="yes">Member</option>
                    <option value="no">Non Member</option>
                </select>
            </div>
            <div class="mb-3" id="nameField" style="display: flex; align-items: center;">
                <label for="akunmember" class="form-label" style="width: 100px; margin-right: 10px;">Nama:</label>
                <input type="text" class="form-control" id="akunmember" name="akunmember" style="width: 450px;">
            </div>
            <!-- Tombol Untuk Perhitungan -->
            <button type="submit" class="btn btn-primary">Hitung Total Bayar</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Data inputan
            $akunmember = $_POST['akunmember'];
            $barang = $_POST['barang'];
            $StatusM = $_POST['member'];
            $hargaB = $_POST['harga'];
            $ItemB = $_POST['jumlah'];

            // Jika Member, ambil nama dari input
            $akunmember = isset($_POST['akunmember']) ? $_POST['akunmember'] : '';

            // Hitung total harga awal
            $HargaAwal = 0;
            $HargaAwal = $hargaB * $ItemB;
            
            // Hitung diskon
            $diskon = 0;
            if ($StatusM == "yes") {
                // Diskon untuk member (10% untuk member, tambahan: 10% jika >=500000, 5% jika >= 300000)
                $StatusM = "Member";
                $diskon = 0.1; 
                if ($HargaAwal >= 500000) {
                    $diskon += 0.1; 
                } else if ($HargaAwal >= 300000) {
                    $diskon += 0.05; 
                }
            } else {
                $StatusM = "Non Member"; //non member tidakmendapatkan diskon tetapi jika belanja >= 500000 diskon 10%
                if ($HargaAwal >= 500000) {
                    $diskon = 0.1;
                }
            }

            $potongan = $diskon * $HargaAwal;
            $TotalBelanja = $HargaAwal - $potongan;

            // Tampilkan hasil
            echo "<div class='alert-info mt-5'>";
            echo "<h4>Nota Pembayaran</h4>";

            // Tampilkan nama jika status member
            if ($StatusM == "Member") {
                echo "<p><b>$StatusM : $akunmember </p>";
            }
            
            echo "<p><b>Barang:</b> $barang</p>";
            echo "<p><b>Jumlah:</b> $ItemB</p>";
            echo "<p><b>Harga Barang:</b> Rp " . number_format($hargaB, 0, ',', '.') . "</p>";
            echo "<p><b>Diskon:</b> " . ($diskon * 100) . "%</p>";
            echo "--------------------------------------";
            echo "<p><b>Total Harga Awal:</b> Rp " . number_format($HargaAwal, 0, ',', '.') . "</p>";
            echo "<p><b>Total Diskon:</b> Rp " . number_format($potongan, 0, ',', '.') . "</p>";
            echo "<p><b>Total Belanja:</b> Rp " . number_format($TotalBelanja, 0, ',', '.') . "</p>";
            echo "</div>";
        }
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
