<?php 

    require 'ceklogin.php';

    //hitung jumlah pelanggan
    $h1 = mysqli_query($conn, "SELECT * FROM user");
    $h2 = mysqli_num_rows($h1); //jumlah pesanan

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data User</title>
        <!-- Favicons -->
        <link href="logo/4.png" rel="icon">>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php"><img src="logo/4.png" alt="" style="width: 50px;"> TECHIT</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Order
                            </a>
                            <a class="nav-link" href="stock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link" href="user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                User
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data User</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Selamat Datang</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Jumlah User: <?= $h2; ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Tambah User Baru
                        </button>
                        <div class="card mb-4">

                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data User
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                            $get = mysqli_query($conn, "SELECT * FROM user");

                                            $i = 1;

                                            while($p=mysqli_fetch_array($get)){
                                                $username = $p['username'];
                                                $password = $p['password'];
                                                $idu = $p['iduser'];
                                        ?>

                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $username; ?></td>
                                            <td><?= $password; ?></td>
                                            <td>
                                                <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" 
                                            data-bs-target="#edit<?= $idu;?>">
                                                    Edit
                                            </button> 
                                                <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
                                            data-bs-target="#delete<?= $idu;?>">
                                                    Delete
                                            </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit--> 
                                        <div class="modal fade" id="edit<?= $idu;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $username; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="" method="post">

                                            <div class="modal-body">
                                            <input type="text" name="username" class="form-control" placeholder="Username" value="<?= $username; ?>">
                                                    <input type="text" name="password" class="form-control mt-2" placeholder="Password" value="<?= $password; ?>">
                                                    <input type="hidden" name="idu" value="<?= $idu; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="edituser">Submit</button> 
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>

                                            </form>

                                            </div>
                                        </div>
                                        </div>

                                        <!-- Modal Delete-->
                                        <div class="modal fade" id="delete<?= $idu;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $username; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="" method="post">

                                            <div class="modal-body">
                                                Apakah anda ingin menghapus user ini
                                                <input type="hidden" name="idu" value="<?= $idu; ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="hapususer">Submit</button> 
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>

                                            </form>

                                            </div>
                                        </div>
                                        </div>

                                        <?php 
                                            }; //end of while
                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah User Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="" method="post">

        <div class="modal-body">
            <input type="text" name="username" class="form-control" placeholder="username">
            <input type="text" name="password" class="form-control mt-2" placeholder="password">
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="tambahuser">Submit</button> 
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>

        </form>

        </div>
    </div>
    </div>
</html>
