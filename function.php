<?php

// sesi/session berfungsi sebagai validasi apa kita pernah mengunjungin halaman ini sebelumnya
session_start();

// membuat koneksi pada database (root dan "" adalah id dan password)
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

// menambah barang baru halaman index
if (isset($_POST['addnewbarang'])) {
    $namaBarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addToTable = mysqli_query($conn, "insert into stock(namaBarang, deskripsi, stock) values('$namaBarang','$deskripsi','$stock')");
    if ($addToTable) {
        header('location:index.php');
    } else {
        echo 'Simpan Gagal';
        header('location:index.php');
    }
}

//Menambah barang halaman barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk (idbarang, keterangan, qty) values('$barangnya', '$penerima', '$qty')");
    $udpatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if ($addtomasuk&&$udpatestockmasuk) {
        header('location:barang-masuk.php');
    } else {
        echo 'Simpan Gagal';
        header('location:barang-masuk.php');
    }
}

// menambah barang halaman barang keluar
if (isset($_POST['addbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang-'$$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];

    // alert jika jumlah barang keluar melebihi dari stock tersedia
    if ($stocksekarang >= $qty) {
        // Jika barang cukup
        $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

        $addtokeluar = mysqli_query($conn, "insert into keluar (idbarang, penerima, qty) values('$barangnya', '$penerima', '$qty')");
        $udpatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
        if ($addtokeluar && $udpatestockmasuk) {
            header('location:barang-keluar.php');
        } else {
            echo 'Simpan Gagal';
            header('location:barang-keluar.php');
        }
    } else{
        // barang tidak cukup
        echo '
        <script>
            alert("Stock saat ini tidak mencukupi");
            window.location.href="barang-keluar.php";
        </script>
        ';
        
    }
}

// update info barang
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang='$idb'");
    if ($update) {
        header("location:index.php");
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

// menghapus barang dari stock
if (isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");
    if ($hapus) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

// mengubah data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($connn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
        if ($kuranginstocknya && $updatenya) {
            header('location:barang-masuk.php');
        } else {
            echo 'Gagal';
            header('location:barang-masuk.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg - $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
        if ($kuranginstocknya && $updatenya) {
            header('location:barang-masuk.php');
        } else {
            echo 'Gagal';
            header('location:barang-masuk.php');
        }
    }
}


// Menghapus barang dari halaman barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok - $qty;
    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if ($update && $hapusdata) {
        header('location:barang-masuk.php');
    } else {
        header('location:barang-masuk.php');
    }
}

// mengubah data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        if ($kuranginstocknya && $updatenya) {
            header('location:barang-keluar.php');
        } else {
            echo 'Gagal';
            header('location:barang-keluar.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg + $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        if ($kuranginstocknya && $updatenya) {
            header('location:barang-keluar.php');
        } else {
            echo 'Gagal';
            header('location:barang-keluar.php');
        }
    }
}


// Menghapus barang dari barang masuk
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok + $qty;
    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('location:barang-keluar.php');
    } else {
        header('location:barang-keluar.php');
    }
}
