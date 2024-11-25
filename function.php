<?php

session_start();

$c = mysqli_connect('localhost','root','','kasir');

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($c, "SELECT * FROM user WHERE username= '$username' and password= '$password'");
    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        $_SESSION['login'] = 'True';
        header("location:index.php");
    }else{
        echo'
        <script>alert("username atau password salah");
        window.location.href="login.php"
        </script>
        ';
    }
}

if(isset($_POST['tambahbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $insert = mysqli_query($c,"insert into produk(namaproduk,deskripsi,harga,stok) values ('$namaproduk','$deskripsi','$harga','$stok')");

    if($insert){
        header('location:stok.php');
    }else{
        echo'
        <script>alert("Gagal menambah barang baru");
        window.location.href="stok.php"
        </script>
        ';
    }
};

if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($c,"insert into pelanggan(namapelanggan,notelp,alamat) values ('$namapelanggan','$notelp','$alamat')");

    if($insert){
        header('location:pelanggan.php');
    }else{
        echo'
        <script>alert("Gagal menambah pelanggan baru");
        window.location.href="pelanggan.php"
        </script>
        ';
    }  
};

if(isset($_POST['tambahpesanan'])){
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($c,"insert into pesanan(idpelanggan) values ('$idpelanggan')");

    if($insert){
        header('location:index.php');
    }else{
        echo'
        <script>alert("Gagal menambah pesanan baru");
        window.location.href="index.php"
        </script>
        ';
    }  
}


if(isset($_POST['addproduk'])){
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp']; //idpesanan
    $qty = $_POST['qty']; //jumlah yang mau dikeluarkan


    //hitung stok sekarang ada berapa
    $hitung1 = mysqli_query($c, "SELECT * FROM produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stoksekarang = $hitung2['stok'];//stok barang saat ini
    
    if($stoksekarang>=$qty){

        //kurangi stoknya dengan jumlah yang akan dikeluarkan
        $selisih = $stoksekarang-$qty;

        //stoknya cukup
        $insert = mysqli_query($c,"insert into detailpesanan (idpesanan, idproduk, qty) values ('$idp','$idproduk','$qty')");
        $update = mysqli_query($c, "update produk set stok='$selisih' where idproduk='$idproduk'");

        if($insert&&$update){
            header('location:view.php?idp='.$idp);
        }else{
            echo'
            <script>alert("Gagal menambah pesanan baru");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            ';
        }
    }else{
        echo'
        <script>alert("Stok barang tidak cukup");
        window.location.href="view.php?idp='.$idp.'"
        </script>
        ';
    }
}

//menambah barang masuk
// Menambah barang masuk dan update stok produk
if(isset($_POST['barangmasuk'])){
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    // Query untuk menambah barang masuk
    $insertb = mysqli_query($c, "INSERT INTO masuk (idproduk, qty) VALUES ('$idproduk', '$qty')");

    if($insertb){
        // Update stok produk setelah barang masuk
        $updateStok = mysqli_query($c, "UPDATE produk SET stok = stok + '$qty' WHERE idproduk = '$idproduk'");

        if($updateStok){
            header('location:masuk.php');
        } else {
            echo'
            <script>alert("Gagal update stok");
            window.location.href="masuk.php"
            </script>
            ';
        }
    } else {
        echo'
        <script>alert("Gagal menambah barang masuk");
        window.location.href="masuk.php"
        </script>
        ';
    }
}


//hapus produk pesanan
if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['idp'];//iddetailpesanan
    $idpr = $_POST['idpr'];
    $idpesanan = $_POST['idpesanan'];
    $

    //cek qty sekarang
    $cek1 = mysqli_query($c, "SELECT * FROM detailpesanan where iddetailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //cek stok sekarang
    $cek3 = mysqli_query($c, "SELECT * FROM produk where idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stoksekarang = $cek4['stok'];

    $hitung = $stoksekarang+$qtysekarang;

    $update = mysqli_query($c, "update produk set stok ='$hitung' where idproduk='$idpr'");//update stok
    $hapus = mysqli_query($c, "delete from detailpesanan where idproduk='$idpr' and iddetailpesanan='$idp'");

    if($update&&$hapus){
        header('location:view.php?idp='.$idpesanan);
    }else{
        echo '
        <script>alert("Gagal menghapus barang");
        window.location.href="view.php?idp='.$idpesanan.'"
        </script>
        ';
    }
}

//edit barang
if(isset($_POST['editbarang'])){
    $np = $_POST['namaproduk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp'];//idproduk

    $query = mysqli_query($c, "update produk set namaproduk='$np', deskripsi='$desc', harga='$harga' where idproduk='$idp' ");

    if($query){
        header('location:stok.php');
    }else{
        echo'
        <script>alert("Gagal");
        window.location.href="stok.php"
        </script>
        ';

    }
}

//hapus barang
if(isset($_POST['hapusbarang'])){
    $idp = $_POST['idp'];

    $query = mysqli_query($c, "delete from produk where idproduk='$idp'");
    if($query){
        header('location:stok.php');
    }else{
        echo'
        <script>alert("Gagal");
        window.location.href="stok.php"
        </script>
        ';

    }
}

//edit pelanggan
if(isset($_POST['editpelanggan'])){
    $np = $_POST['namapelanggan'];
    $nt = $_POST['notelp'];
    $a = $_POST['alamat'];
    $id = $_POST['idpl'];

    $query = mysqli_query($c, "update pelanggan set namapelanggan='$np', notelp='$nt', alamat='$a' where idpelanggan='$id' ");

    if($query){
        header('location:pelanggan.php');
    }else{
        echo'
        <script>alert("Gagal");
        window.location.href="pelanggan.php"
        </script>
        ';

    }
}


 //hapus pelanggan
if(isset($_POST['hapuspelanggan'])){
    $idpl = $_POST['idpl'];

    $query = mysqli_query($c, "delete from pelanggan where idpelanggan='$idpl'");
    if($query){
        header('location:pelanggan.php');
    }else{
        echo'
        <script>alert("Gagal");
        window.location.href="pelanggan.php"
        </script>
        ';

    }
}

//mengubah data barang masuk

//edit pelanggan
if(isset($_POST['editdatabarangmasuk'])){
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

   
    //cari tahu qty skr brp
    $caritahu = mysqli_query($c, "SELECT * FROM masuk where idmasuk='$idm'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tahu stok sekarang brp
    $caristok = mysqli_query($c, "SELECT * FROM produk where idproduk='$idp'");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    if($qty >= $qtysekarang){
        //kalau inputan user lebih besar daripada qty yg tercatat
        //hitung selisih
        $selisih = $qty+$qtysekarang;
        $newstok = $stoksekarang+$selisih;

        $query1 = mysqli_query($c, "update masuk set qty='$qty' where idmasuk='$idm' ");
        $query2 = mysqli_query($c, "update produk set stok='$newstok' where idproduk='$idp' ");

        if($query1&&$query2){
            header('location:masuk.php');
        }else{
            echo'
            <script>alert("Gagal");
            window.location.href="masuk.php"
            </script>
            ';

        }
       
    }else{
        //kalau lebih kecil
        //hitung selisih
        $selisih = $qtysekarang-$qty;
        $newstok = $stoksekarang+$selisih;

        $query1 = mysqli_query($c, "update masuk set qty='$qty' where idmasuk='$idm' ");
        $query2 = mysqli_query($c, "update produk set stok='$newstok' where idproduk='$idp' ");

        if($query1&&$query2){
            header('location:masuk.php');
        }else{
            echo'
            <script>alert("Gagal");
            window.location.href="masuk.php"
            </script>
            ';

        }

        
    }
}
   
?>