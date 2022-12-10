<?php
require 'function.php';
require 'cek-login.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Barang Keluar</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Management Koperasi</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">                    
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="barang-masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="barang-keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Keluar
                        </a>

                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.html">Login</a>
                                        <a class="nav-link" href="register.html">Register</a>
                                        <a class="nav-link" href="password.html">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.html">401 Page</a>
                                        <a class="nav-link" href="404.html">404 Page</a>
                                        <a class="nav-link" href="500.html">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Barang Keluar</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Simpan Baru
                            </button>
                            <!-- The Modal -->
                            <div class="modal" id="myModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Tambah Barang</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <!-- required berfungsi field pada input tidak boleh kosong -->
                                        <form method="post">
                                            <div class="modal-body">
                                            <select name="barangnya" class="form-control">
                                                    <?php
                                                        $ambilsemuadatanya = mysqli_query($conn,"SELECT * FROM stock");
                                                        while($fetchChararray = mysqli_fetch_array($ambilsemuadatanya)){
                                                            $namabarangnya = $fetchChararray['namabarang'];
                                                            $idbarangnya = $fetchChararray['idbarang'];                                                    
                                                                                                                                                    
                                                    ?>                                                
                                                    <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>
                                                    
                                                    <?php
                                                        }
                                                    ?>                                                    
                                                </select>
                                                <br>
                                                <input type="number" name="qty" placeholder="Quantity" class="form-control" required>                                    
                                                <br>
                                                <input type="text" name="penerima" placeholder="penerima" class="form-control" required>                                    
                                                <br>
                                                <button type="submit" class="btn btn-primary" name="addbarangkeluar">Submit</button>
                                            </div>
                                        </form>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Nama barang</th>
                                            <th>Jumlah</th>
                                            <th>Penerima</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        $ambilsemuadatastock = mysqli_query($conn,"select * from keluar k, stock s where s.idbarang = k.idbarang");
                                        while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $idk = $data['idkeluar'];
                                            $idb = $data['idbarang'];
                                            $tanggal = $data['tanggal'];
                                            $namabarang = $data['namabarang'];
                                            $qty = $data['qty'];
                                            $penerima = $data['penerima'];                                        
                                        ?>
                                        <tr>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$qty;?></td>
                                            <td><?=$penerima;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idk;?>">
                                                    Edit
                                                </button>                                                
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idk;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?=$idk;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <!-- required berfungsi field pada input tidak boleh kosong -->
                                                        <form method="post">
                                                            <div class="modal-body">                                                                
                                                                <input type="text" name="penerima" value="<?=$penerima;?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="qty" value="<?=$qty;?>" class="form-control" required>
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                <input type="hidden" name="idk" value="<?=$idk;?>">
                                                                <button type="submit" class="btn btn-primary" name="updatebarangkeluar">Edit</button>
                                                            </div>
                                                        </form>                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$idk;?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Barang</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <!-- required berfungsi field pada input tidak boleh kosong -->
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus "<?=$namabarang;?>"?
                                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                                <input type="hidden" name="kty" value="<?=$qty;?>">
                                                                <input type="hidden" name="idk" value="<?=$idk;?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary" name="hapusbarangkeluar">Hapus</button>
                                                            </div>
                                                        </form>                                                        
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        };
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

</html>