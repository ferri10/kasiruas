<?php 

    session_start();

    //koneksi
    $conn = mysqli_connect('localhost', 'root', '', 'kasir');

    //login
    if (isset($_POST['login'])) {
        //Initiate variable
        $username = $_POST['username'];
        $password = $_POST['password'];

        $check = mysqli_query($conn, "SELECT* FROM user WHERE username='$username' and password='$password'");
        $hitung = mysqli_num_rows($check);

        if ($hitung > 0) {
            $_SESSION['login'] = true;
            header('location: index.php');
        }else{
            echo '<script>
                    alert("username atau password salah");
                    window.location.href="login.php";
                </script>';
        }
    }

    
    if (isset($_POST['tambahbarang'])) {
        $namaproduk = htmlspecialchars($_POST["namaproduk"]); 
        $deskripsi = htmlspecialchars($_POST["deskripsi"]);
        $harga = htmlspecialchars($_POST["harga"]);
        $stock = htmlspecialchars($_POST["stock"]);

        //query insert data
        $insert = mysqli_query($conn,"INSERT INTO produk VALUES ('', '$namaproduk', '$deskripsi', '$harga', 
        '$stock')");

        if ($insert) {
            header('Location: stock.php');
        }else{
            echo "<script>
                    alert('Gagal menambah barang baru');
                    window.location.href='stock.php';
                </script>";
        }
    }

    if (isset($_POST['tambahpelanggan'])) {
        $namapelanggan = htmlspecialchars($_POST["namapelanggan"]); 
        $notelp = htmlspecialchars($_POST["notelp"]);
        $alamat = htmlspecialchars($_POST["alamat"]);
        //query insert data
        $insert = mysqli_query($conn,"INSERT INTO pelanggan VALUES ('', '$namapelanggan', '$notelp', '$alamat')");

        if ($insert) {
            header('Location: pelanggan.php');
        }else{
            echo "<script>
                    alert('Gagal menambah pelanggan baru');
                    window.location.href='pelanggan.php';
                </script>";
        }
    }

    if (isset($_POST['tambahpesanan'])) {
        $idpelanggan = htmlspecialchars($_POST["idpelanggan"]); 
        //query insert data
        $insert = mysqli_query($conn,"INSERT INTO pesanan (idpelanggan) VALUES ('$idpelanggan')");

        if ($insert) {
            header('Location: index.php');
        }else{
            echo "<script>
                    alert('Gagal menambah pesanan baru');
                    window.location.href='index.php';
                </script>";
        }
    }

    //hapus produk dipilih view
    if (isset($_POST['addproduk'])) {
        $idproduk = htmlspecialchars($_POST["idproduk"]); 
        $idp = htmlspecialchars($_POST["idp"]); 
        $qty = htmlspecialchars($_POST["qty"]); 

        // cek stok
        $hitung1 =mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
        $hitung2 = mysqli_fetch_array($hitung1);
        $stocksekarang = $hitung2['stock']; //stock barang saat ini

        //stoknya cukup
        if ($stocksekarang>=$qty) {
            // kurangi stok 
            $selisih = $stocksekarang-$qty;

            //query insert data
            $query = "INSERT INTO detailpesanan VALUES ('', '$idp', '$idproduk', '$qty') ";
            $insert = mysqli_query($conn, $query);

            //query update barang
            $update = mysqli_query($conn, "UPDATE produk SET stock='$selisih' where idproduk='$idproduk'");

            if ($insert&&$update) {
                header('location: view.php?idp='.$idp);

            }else{
                echo "
                <script>
                    alert('Gagal menambah pesanan baru!');
                    // window.location.href='view.php?idp=.$idp.';
                </script>
            ";
            }

        }else{

            //stok tidak cukup
            echo "
                <script>
                    alert('Stok barang tidak cukup!');
                    window.location.href='view.php?idp=$idp'
                    // window.location.href='index.php';
                </script>
            ";
        }
    }

    //menambah barang masuk
    if (isset($_POST['barangmasuk'])) {
        
        $idproduk = $_POST['idproduk'];
        $qty = $_POST['qty'];

        //cari tahu stock sekarang
        $caristock = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
        $caristock2 = mysqli_fetch_array($caristock);
        $stocksekarang = $caristock2['stock'];

        //hitung stock
        $newstockb = $stocksekarang+$qty;

            $insertb = mysqli_query($conn, "INSERT INTO masuk (idproduk, qty)VALUES ('$idproduk', '$qty')");
            $updateb = mysqli_query($conn, "UPDATE produk SET stock='$newstockb' where idproduk='$idproduk'");

            if ($insertb&&$updateb) {
                
                header('location: masuk.php');

            }else{
                echo "
                <script>
                    alert('Gagal!');
                    window.location.href='masuk.php';
                </script>
            ";
            }
            
    }

    //hapus produk pesanan
    if (isset($_POST['hapusprodukpesanan'])) {
        
        $idp = $_POST['idp']; //iddetailpesanan
        $idpr = $_POST['idpr'];
        $idorder = $_POST['idorder'];
        
        //cek qty sekarang
        $cek1 = mysqli_query($conn, "SELECT * FROM detailpesanan WHERE iddetailpesanan='$idp'");
        $cek2 = mysqli_fetch_array($cek1);
        $qtysekarang =$cek2['qty'];

        //cek stok sekarang
        $cek3 = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idpr'");
        $cek4 = mysqli_fetch_array($cek3);
        $stocksekarang = $cek4['stock'];

        $hitung = $stocksekarang + $qtysekarang;

        $update = mysqli_query($conn, "UPDATE produk set stock = '$hitung' where idproduk='$idpr'"); //update stock
        $hapus = mysqli_query($conn, "DELETE FROM detailpesanan where idproduk='$idpr' and iddetailpesanan='$idp'"); 

        if ($update&&$hapus) {

            echo "
                <script>
                    alert('ahaha!');
                </script>
            ";

            header('location: view.php?idp='.$idorder);
            
        }else{
            echo "
                <script>
                    alert('Gagal menghapus barang!');
                    window.location.href='view.php?idp=$idorder'
                </script>
            ";
        }
            
    }

    //edit barang stock
    if (isset($_POST['editbarang'])) {
        $np = $_POST['namaproduk'];
        $desc = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $idp = $_POST['idp'];

        $query = mysqli_query($conn,"UPDATE produk set namaproduk='$np', deskripsi='$desc', harga='$harga' where idproduk='$idp'");

        if ($query) {
            header('location: stock.php');
        }else{
            echo "
                <script>
                    alert('Gagal Edit barang!');
                    window.location.href='view.php?idp=$idorder'
                </script>
            ";
        }
    }

    //hapus barang stock
    if (isset($_POST['hapusbarang'])) {
        $idp = $_POST['idp'];

        $query = mysqli_query($conn,"DELETE FROM produk where idproduk='$idp'");

        if ($query) {
            header('location: stock.php');
        }else{
            echo "
                <script>
                    alert('Gagal Edit barang!');
                    window.location.href='view.php?idp=$idorder'
                </script>
            ";
        }
    }

    //edit pelanggan
    if (isset($_POST['editpelanggan'])) {
        $np = $_POST['namapelanggan'];
        $not = $_POST['notelp'];
        $alamat = $_POST['alamat'];
        $idpl = $_POST['idpl'];

        $query = mysqli_query($conn,"UPDATE pelanggan set namapelanggan='$np', notelp='$not', alamat='$alamat' where idpelanggan='$idpl'");

        if ($query) {
            header('location: pelanggan.php');
        }else{
            echo "
                <script>
                    alert('Gagal Edit pelanggan!');
                    window.location.href='pelanggan.php'
                </script>
            ";
        }
    }

    //hapus pelanggan
    if (isset($_POST['hapuspelanggan'])) {
        $idpl = $_POST['idpl'];

        $query = mysqli_query($conn,"DELETE FROM pelanggan where idpelanggan='$idpl'");

        if ($query) {
            header('location: pelanggan.php');
        }else{
            echo "
                <script>
                    alert('Gagal Edit pelanggan!');
                    window.location.href='pelanggan.php'
                </script>
            ";
        }
    }

    //edit barang masuk
    if (isset($_POST['editmasuk'])) {
        $qty = $_POST['qty'];
        $idm = $_POST['idm'];
        $idp = $_POST['idp'];

        //cari qty sekarang
        $caritahu = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
        $caritahu2 = mysqli_fetch_array($caritahu);
        $qtysekarang = $caritahu2['qty'];

        //cari tahu stock sekarang
        $caristock = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idp'");
        $caristock2 = mysqli_fetch_array($caristock);
        $stocksekarang = $caristock2['stock'];

        if ($qty >= $qtysekarang) {
            $selisih = $qty - $qtysekarang;
            $newstock= $stocksekarang + $selisih;

            $query1 = mysqli_query($conn,"UPDATE masuk set qty='$qty' where idmasuk='$idm'");
            $query2 = mysqli_query($conn,"UPDATE produk set stock='$newstock' where idproduk='$idp'");

            if ($query1&&$query2) {
                header('location: masuk.php');
            }else{
                echo "
                    <script>
                        alert('Gagal Edit barang!');
                        window.location.href='masuk.php'
                    </script>
                ";
            }

        }else{
            //hitung selisih
            $selisih = $qtysekarang - $qty;
            $newstock= $stocksekarang - $selisih;

            $query1 = mysqli_query($conn,"UPDATE masuk set qty='$qty' where idmasuk='$idm'");
            $query2 = mysqli_query($conn,"UPDATE produk set stock='$newstock' where idproduk='$idp'");

            if ($query1&&$query2) {
                header('location: masuk.php');
            }else{
                echo "
                    <script>
                        alert('Gagal Edit barang!');
                        window.location.href='masuk.php'
                    </script>
                ";
            }
        }
    }

    //hapus data barang masuk
    if (isset($_POST['hapusdatabarangmasuk'])) {
        $idm = $_POST['idm'];
        $idp = $_POST['idp'];
        

        //cari qty sekarang
        $caritahu = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
        $caritahu2 = mysqli_fetch_array($caritahu);
        $qtysekarang = $caritahu2['qty'];

        //cari tahu stock sekarang
        $caristock = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idp'");
        $caristock2 = mysqli_fetch_array($caristock);
        $stocksekarang = $caristock2['stock'];

        //hitung selisih
        $selisih = $qtysekarang - $qty;
            $newstock= $stocksekarang - $qtysekarang;

            $query1 = mysqli_query($conn,"delete from masuk where idmasuk='$idm'");
            $query2 = mysqli_query($conn,"UPDATE produk set stock='$newstock' where idproduk='$idp'");

            if ($query1&&$query2) {
                header('location: masuk.php');
            }else{
                echo "
                    <script>
                        alert('Gagal Edit barang!');
                        window.location.href='masuk.php'
                    </script>
                ";
            }
    }

    //hapus order
    if (isset($_POST['hapusorder'])) {
        $ido = $_POST['ido'];

        $cekdata = mysqli_query($conn, "SELECT * FROM detailpesanan WHERE idpesanan='$ido'");

        while ($ok=mysqli_fetch_array($cekdata)) { 
            //balikin stok
            $qty=$ok['qty'];
            $idproduk=$ok['idproduk'];
            $iddp=$ok['iddetailpesanan'];

            //cari tahu stock sekarang
            $caristock = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
            $caristock2 = mysqli_fetch_array($caristock);
            $stocksekarang = $caristock2['stock'];

            $newstock = $stocksekarang+$qty;

            $queryupdate=mysqli_query($conn,"UPDATE produk set stock='$newstock' where idproduk='$idproduk'");
            
            //hapus data
            $querydelete = mysqli_query($conn,"DELETE FROM detailpesanan where iddetailpesanan='$iddp'");
            
        }

        $query = mysqli_query($conn,"DELETE FROM pesanan where idorder='$ido'");

        if ($queryupdate&&$querydelete&&$query) {
            header('location: index.php');
        }else if($query){
            echo "
                <script>
                    alert('Berhasil Hapus!');
                    window.location.href='index.php'
                </script>
            ";
        }else{
            echo "
                <script>
                    alert('Gagal Hapus pelanggan!');
                    window.location.href='index.php'
                </script>
            ";
        }
    }

    //edit detailpesanan
    if (isset($_POST['editdetailpesanan'])) {
        $qty = $_POST['qty'];
        $iddp = $_POST['iddp']; //id masuk
        $idpr = $_POST['idpr']; // idproduk
        $idp = $_POST['idp']; //id pesanan

        //cari qty sekarang
        $caritahu = mysqli_query($conn, "SELECT * FROM detailpesanan WHERE iddetailpesanan='$iddp'");
        $caritahu2 = mysqli_fetch_array($caritahu);
        $qtysekarang = $caritahu2['qty'];

        //cari tahu stock sekarang
        $caristock = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idpr'");
        $caristock2 = mysqli_fetch_array($caristock);
        $stocksekarang = $caristock2['stock'];

        if ($qty >= $qtysekarang) {
            $selisih = $qty - $qtysekarang;
            $newstock= $stocksekarang - $selisih;

            $query1 = mysqli_query($conn,"UPDATE detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
            $query2 = mysqli_query($conn,"UPDATE produk set stock='$newstock' where idproduk='$idpr'");

            if ($query1&&$query2) {
                header('location: view.php?idp='.$idp);
            }else{
                echo "
                    <script>
                        alert('Gagal Edit barang!');
                        window.location.href='view.php?idp=$idp';
                    </script>
                ";
            }

        }else{
            //hitung selisih
            $selisih = $qtysekarang - $qty;
            $newstock= $stocksekarang + $selisih;

            $query1 = mysqli_query($conn,"UPDATE detailpesanan set qty='$qty' where iddetailpesanan='$iddp'");
            $query2 = mysqli_query($conn,"UPDATE produk set stock='$newstock' where idproduk='$idpr'");

            if ($query1&&$query2) {
                header('location: view.php?idp='.$idp);
            }else{
                echo "
                    <script>
                        alert('Gagal Edit barang!');
                        window.location.href='view.php?idp=$idp';
                    </script>
                ";
            }
        }
    }

    if (isset($_POST['tambahuser'])) {
        $username = htmlspecialchars($_POST["username"]); 
        $password = htmlspecialchars($_POST["password"]);
        //query insert data
        $insert = mysqli_query($conn,"INSERT INTO user VALUES ('', '$username', '$password')");

        if ($insert) {
            header('Location: user.php');
        }else{
            echo "<script>
                    alert('Gagal menambah user baru');
                    window.location.href='user.php';
                </script>";
        }
    }

    //edit user
    if (isset($_POST['edituser'])) {
        $usn = $_POST['username'];
        $pw = $_POST['password'];
        $idu = $_POST['idu'];

        $query = mysqli_query($conn,"UPDATE user set username='$usn', password='$pw' where iduser='$idu'");

        if ($query) {
            header('location: user.php');
        }else{
            echo "
                <script>
                    alert('Gagal Edit user!');
                    window.location.href='user.php'
                </script>
            ";
        }
    }

    //hapus user
    if (isset($_POST['hapususer'])) {
        $idu = $_POST['idu'];

        $query = mysqli_query($conn,"DELETE FROM user where iduser='$idu'");

        if ($query) {
            header('location: user.php');
        }else{
            echo "
                <script>
                    alert('Gagal Edit user!');
                    window.location.href='user.php'
                </script>
            ";
        }
    }

?>