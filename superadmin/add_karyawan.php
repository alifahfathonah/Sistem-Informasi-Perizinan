<?php
    require '../db_login.php';
    require './aksi.php';
    session_start();
    // isset not login
    if (!isset($_SESSION['email'])) {
        header("location:../index.php");
    }
    error_reporting(E_ERROR | E_PARSE);

    function getUserDetail($email)
    {
        global $conn;
        $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE email='$email'");
        $data = mysqli_fetch_assoc($query);
        return $data;
    }
    function getJabatan($id_jabatan)
    {
        global $conn;
        $query = mysqli_query($conn, "SELECT * FROM tb_jabatan WHERE id_jabatan='$id_jabatan'");
        $data = mysqli_fetch_assoc($query);
        return $data;
    }

    function getBidang($id_bidang)
    {
        global $conn;
        $query = mysqli_query($conn, "SELECT * FROM tb_bidang WHERE id_bidang='$id_bidang'");
        $data = mysqli_fetch_assoc($query);
        return $data;
    }

    // get detail user
    $UserDetail = getUserDetail($_SESSION['email']);
    $queryjabatan = mysqli_query($conn, "select * from tb_jabatan");
    $querybidang = mysqli_query($conn, "select * from tb_bidang");
    $_SESSION['email'] = $UserDetail['email'];

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title> Superadmin Dashboard </title>
    <link rel="icon" type="image/x-icon" href="../asset/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="sidebar">
  <div class="logo-details">
      <i> <img src="../asset/favicon.ico" style="width:40px ; padding-bottom:5px" alt=""></i>
      <div class="logo_name" style="padding-top: 5px;"> <div style="font-size:15px; color:#01B9EF; font-weight: bold;">PLN</div>  Indonesia Power</div>
    </div>
    <ul class="nav-list" id="nav-list">
      <li>
        <a class="nav-link " href="superadmin.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Home</span>
        </a>
         <span class="tooltip">Home</span>
      </li>
      <li>
       <a class="nav-link active" href="datakaryawan.php">
         <i class='bx bx-user' ></i>
         <span class="links_name">Data Karyawan</span>
       </a>
       <span class="tooltip">Data Karyawan</span>
     </li>
     <li>
       <a class="nav-link" href="../logout.php">
         <i class="bi bi-box-arrow-right"></i>
         <span class="links_name">Keluar</span>
       </a>
       <span class="tooltip">Keluar</span>
     </li>
     <li class="profile">
        <div class="profile-details">
        <img src="superadmin.png">
            <div class="name_job">
                <div class="name">Superadmin</div>
                <div class="email"><?php echo $UserDetail['email']; ?></div>
            </div>
        </div>
        <i class="fa fa-bars" id="bars"></i>
    </li>
    </ul>
  </div>
  
<section class="home-section">
   
      <div class="h4 mt-5 w-100 mb-5 ">Tambah Data Karyawan

      <a href="datakaryawan.php">
        <button type="button" class="btn btn-primary float-end" >
          Kembali
        </button></a>
      </div>

      <div class="card p-5 rounded-4 mt-3">

      <form method="POST" autocomplete="on"  name="form">
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="nip_karyawan">NIP Karyawan</label>
            <input type="nip_karyawan" name="nip_karyawan" placeholder="NIP Karyawan" class="form-control" value="<?php if(isset($nip_karyawan)) {echo $nip_karyawan;} ?>" >
            <div class="error text-danger fst-italic"> <?php if(isset($error_nip_karyawan)) echo $error_nip_karyawan; ?> </div>
        </div>
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="nama_karyawan">Nama Karyawan</label>
            <input type="nama_karyawan" name="nama_karyawan" placeholder="Nama Karyawan" class="form-control" value="<?php if(isset($nama_karyawan)) {echo $nama_karyawan;} ?>" >
            <div class="error text-danger fst-italic"> <?php if(isset($error_nama_karyawan)) echo $error_nama_karyawan; ?> </div>
        </div>
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="jabatan">Jabatan</label>
            <select name="id_jabatan" id="id_jabatan" class="form-control"
                onchange="getJabatan(this.value)">
                <option value="">Pilih Jabatan</option>
                <?php while ($row = $queryjabatan->fetch_object()) {
                    echo '<option value="' . $row->id_jabatan . '">' . $row->nama_jabatan . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="bidang">Bidang</label>
            <select name="id_bidang" id="id_bidang" class="form-control"
                onchange="getBidang(this.value)">
                <option value="">Pilih Bidang</option>
                <?php while ($row = $querybidang->fetch_object()) {
                    echo '<option value="' . $row->id_bidang . '">' . $row->nama_bidang . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="nip_atasan">NIP Atasan</label>
            <input type="nip_atasan" name="nip_atasan" placeholder="NIP Atasan" class="form-control" value="<?php if(isset($nip_atasan)) {echo $nip_atasan;} ?>" >
            <div class="error text-danger fst-italic"> <?php if(isset($error_nip_atasan)) echo $error_nip_atasan; ?> </div>
            <p style="font-style: italic; color: blue; font-size: 12px;">Isi angka 1 jika tidak memiliki atasan</p>
        </div>
        <button type="submit" name="add_karyawan" value="add_karyawan" class="btn btn-primary w-100 mb-3">Submit</button>
      </form>

    </div>
  </div>
</body>
</section>

<script src="../library/js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="./script.js"></script>

<script>$(document).ready(function () {
    $('#example').DataTable();
});</script>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

 <script>

    
 </script>
 </html>
