<?php 

    require 'ceklogin.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!-- Favicons -->
        <link href="logo/4.png" rel="icon">>
        <title>Stock Barang</title>
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
                        <h1 class="mt-4">Data Barang Masuk</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Selamat Datang</li>
                        </ol>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Tambah Barang Masuk
                        </button>
                        <div class="card mb-4">

                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pesanan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Produk</th>
                                            <th>Deskripsi</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                            $get = mysqli_query($conn, "SELECT * FROM masuk m, produk p WHERE m.idproduk=p.idproduk");

                                            $i = 1;

                                            while($p=mysqli_fetch_array($get)){
                                                $namaproduk = $p['namaproduk'];
                                                $deskripsi = $p['deskripsi'];
                                                $qty = $p['qty'];
                                                $tanggal = $p['tanggalmasuk'];
                                                $idmasuk = $p['idmasuk'];
                                                $idproduk = $p['idproduk'];
                                        ?>

                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $namaproduk; ?></td>
                                            <td><?= $deskripsi; ?></td>
                                            <td><?= $qty; ?></td>
                                            <td><?= $tanggal; ?></td>
                                            <td>
                                                <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" 
                                            data-bs-target="#edit<?= $idmasuk;?>">
                                                    Edit
                                            </button> 
                                                <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
                                            data-bs-target="#delete<?= $idmasuk;?>">
                                                    Delete
                                            </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit--> 
                                        <div class="modal fade" id="edit<?= $idmasuk;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Ubah Data Barang Masuk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="" method="post">

                                            <div class="modal-body">
                                            <input type="text" name="namaproduk" class="form-control" placeholder="Nama Produk" value="<?= $namaproduk; ?>" disabled>
                                                    <input type="number" name="qty" class="form-control mt-2" placeholder="jumlah" value="<?= $qty; ?>" min="1" required>
                                                    <input type="hidden" name="idm" value="<?= $idmasuk; ?>">
                                                    <input type="hidden" name="idp" value="<?= $idproduk; ?>">
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="editmasuk">Submit</button> 
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>

                                            </form>

                                            </div>
                                        </div>
                                        </div>

                                        <!-- Modal Delete-->
                                        <div class="modal fade" id="delete<?= $idmasuk;?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Barang Masuk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="" method="post">

                                            <div class="modal-body">
                                                Apakah anda ingin menghapus data ini
                                                <input type="hidden" name="idp" value="<?= $idproduk; ?>">
                                                <input type="hidden" name="idm" value="<?= $idmasuk; ?>">
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="hapusdatabarangmasuk">Submit</button> 
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
            <h5 class="modal-title" id="exampleModalLabel">Tambah Barang Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="" method="post">

        <div class="modal-body">
            Pilih Barang
            <select name="idproduk" id="" class="form-control">

            <?php 
                
                $getproduk = mysqli_query($conn, "SELECT * FROM produk");
                                
                    while($pl = mysqli_fetch_array($getproduk)){
                        $idproduk = $pl['idproduk'];
                        $namaproduk = $pl['namaproduk'];
                        $stock = $pl['stock'];
                        $deskripsi = $pl['deskripsi'];
            ?>
                            
                <option value="<?= $idproduk; ?>"><?= $namaproduk; ?> - <?= $deskripsi; ?> (Stock : <?= $stock; ?>) </option>

            <?php 
                };
            ?>

            </select>

            <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" required>

        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-success" name="barangmasuk">Submit</button> 
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>

        </form>

        </div>
    </div>
    </div>
</html>
