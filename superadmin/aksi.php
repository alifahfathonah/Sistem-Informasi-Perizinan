<?php
require "../db_login.php";

function test_input($data)
{
   global $conn;

   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = $conn->real_escape_string($data);

   return $data;
}

function close()
{
   header('location:../db_login.php');
}

//Delete All User
if (isset($_POST['delete_all_user'])) {

   $querydelete = mysqli_query($conn, "DELETE FROM tb_user");

   if ($querydelete) {
      header('location:superadmin.php');
   } else {
      echo "Gagal Menambahkan Data";
      header('location:superadmin.php');
   }

}

//Add User
$valid = true;
if (isset($_POST['add_user'])) {    
    $email = $_POST['email'];
   if($email == ''){
      $error_email = "Email harus diisi";
      $valid = false;
   }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $error_email = "Format email tidak benar";
      $valid = false;
   }

   $nip_user = $_POST['nip_user'];
   if (empty($nip_user)) {
      $valid = false;
      $error_nip_user = "NIP tidak boleh kosong";
   } else if (!preg_match("/^[0-9]*$/", $nip_user)) {
      $valid = false;
      $error_nip_user = "Hanya angka yang diperbolehkan";
   }

   $password = $_POST['password'];
   //validate password
   if (empty($password)) {
      $valid = false;
      $error_password = "Password tidak boleh kosong";
   }else if (strlen($password) < 3) {
      $valid = false;
      $error_password = "Password minimal 4 karakter";
   }

   $ceknip_user = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tb_user WHERE nip_user='$nip_user'"));
   if ($ceknip_user > 0){
     $error_nip_user = "NIP sudah ada";
     $valid = false;
   }

   $cekEmail = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tb_user WHERE email='$email'"));
   if ($cekEmail > 0){
     $error_email = "Email sudah ada";
     $valid = false;
   }

   if($valid == true){
      $status_user = $_POST['status_user'];
      $addtouser = mysqli_query($conn, "INSERT INTO tb_user (email, password, status_user, nip_user) VALUES('$email', '$password','$status_user','$nip_user')");

      if ($addtouser) {
         header('location:superadmin.php');
      } else {
         echo "Gagal Menambahkan Data";
         header('location:superadmin.php');
      }
   }

}

//Add karyawan
$valid = true;
if (isset($_POST['add_karyawan'])) {    
   $nip_karyawan = $_POST['nip_karyawan'];
   if (empty($nip_karyawan)) {
      $valid = false;
      $error_nip_karyawan = "NIP tidak boleh kosong";
   } else if (!preg_match("/^[0-9]*$/", $nip_karyawan)) {
      $valid = false;
      $error_nip_karyawan = "Hanya angka yang diperbolehkan";
   }
   $nama_karyawan = $_POST['nama_karyawan'];
   if($nama_karyawan == ''){
      $error_nama_karyawan = "Nama Karyawan harus diisi";
      $valid = false;
   }elseif(!preg_match("/^[a-zA-Z ]*$/", $nama_karyawan)){
      $error_nama_karyawan = "Hanya huruf dan spasi yang diperbolehkan";
      $valid = false;
   }
   $nip_atasan = $_POST['nip_atasan'];
   if (empty($nip_atasan)) {
      $valid = false;
      $error_nip_atasan = "NIP tidak boleh kosong";
   } else if (!preg_match("/^[0-9]*$/", $nip_atasan)) {
      $valid = false;
      $error_nip_atasan = "Hanya angka yang diperbolehkan";
   }

   $ceknip = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tb_karyawan WHERE nip_karyawan='$nip_karyawan'"));
    if ($ceknip > 0){
      $error_nip_karyawan = "NIP Karyawan sudah ada";
      $valid = false;
    }

   $cek = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tb_karyawan WHERE nama_karyawan='$nama_karyawan'"));
    if ($cek > 0){
      $error_nama_karyawan = "Nama Karyawan sudah ada";
      $valid = false;
    }

   if($valid == true){
      $addtouser = mysqli_query($conn, "INSERT INTO tb_karyawan (nama_karyawan, nip_karyawan, nip_atasan, id_jabatan, id_bidang) VALUES('$nama_karyawan','$nip_karyawan','$nip_atasan','$_POST[id_jabatan]','$_POST[id_bidang]')");

      if ($addtouser) {
         header('location:datakaryawan.php');
      } else {
         echo "Gagal Menambahkan Data";
         header('location:datakaryawan.php');
      }
   }

}

//edit user
if (isset($_POST['edit_user'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id = $_POST['id'];

   $queryupdateuser = mysqli_query($conn, "UPDATE tb_user SET email = '$email', password = '$password' WHERE nip_user='$id'");
 
    if ($queryupdateuser) {
       header('location:superadmin.php');
    } else {
       echo "Gagal Edit Data";
       header('location:superadmin.php');
    }
 
 }

//delete user
if (isset($_POST['delete_user'])) {
   $id = $_POST['id'];

   $querydelete = mysqli_query($conn, "DELETE FROM tb_user WHERE email='$id'");

   if ($querydelete) {
      header('location:superadmin.php');
   } else {
      echo "Gagal Hapus Data";
      header('location:superadmin.php');
   }

}

//delete karyawan
if (isset($_POST['delete_karyawan'])) {
   $nip_karyawan = $_POST['nip_karyawan'];

   $querydelete = mysqli_query($conn, "DELETE FROM tb_karyawan WHERE nip_karyawan='$nip_karyawan'");

   if ($querydelete) {
      header('location:datakaryawan.php');
   } else {
      echo "Gagal Hapus Data";
      header('location:datakaryawan.php');
   }

}

?>

