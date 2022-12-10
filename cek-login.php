<?php
// cek login berfungsi saat belum login tidak dapat mengakses halaman index.php
// saat sudah login tidak dapat mengakses halaman login

// jika belum login
if(isset($_SESSION['log'])){

} else {
    header('location:login.php');
}
?>
