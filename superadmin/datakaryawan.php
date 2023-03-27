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

    // get detail
    $UserDetail = getUserDetail($_SESSION['email']);
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
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.css">
    <title> Superadmin Dashboard </title>
    <link rel="icon" type="image/x-icon" href="../asset/favicon.ico">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <style>
      
      .home-section a .card-active{
        color: white;
        background-color: #8974FF;
      }
    </style>
    <style>
				.modal {
				  background: rgba(0, 0, 0, 0.5); 
				}
				.modal-backdrop {
				  display: none;
				}
		</style>
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
      <div class="container">
      <div class="h4 mt-5 w-100 ">Data Karyawan

      <a href="./add_karyawan.php">
      <button type="button" class="btn btn-primary float-end" >
        Tambah Data Karyawan
      </button></div><br></a>
      
      <div class="row row-cols-1 row-cols-md-1 g-4 mt-1">
      <?php
      $ambildata = mysqli_query($conn, "SELECT * FROM tb_karyawan");
      $karyawan = 0;
      while ($data = mysqli_fetch_array($ambildata)) {
          $karyawan++;
          }
      ?>
      <div class="col">
      <a href="datakaryawan.php">
      <div class="card rounded-4 ">
        <div class="card-body">
          <p class="text-center">Jumlah Karyawan</p>
          <p class="card-text jumlah text-center"><?= $karyawan; ?></p>
        </div>
      </div>
      </a>
      </div>
      </div>

      <div class=" mt-4 mb-4 w-100">Data Karyawan PT PLN INDONESIA POWER SEMARANG PGU</div>
      <div class="card p-4 rounded-4">
      <table id="example" class="table   rounded-3" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>Bidang</th>
                <th>NIP Atasan</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $ambildata = mysqli_query($conn, 'SELECT * FROM tb_karyawan, tb_jabatan, tb_bidang WHERE tb_karyawan.id_jabatan = tb_jabatan.id_jabatan AND tb_karyawan.id_bidang = tb_bidang.id_bidang;');
          $i = 1;
          while ($data = mysqli_fetch_array($ambildata)) {
              $nip_karyawan = $data['nip_karyawan'];
              $nama_karyawan= $data['nama_karyawan'];
              $nip_atasan = $data['nip_atasan'];
              $jabatan = $data['nama_jabatan'];
              $bidang = $data['nama_bidang'];
          ?>

        <tr>
          <td><?= $i++; ?></td>
          <td><?= $nip_karyawan; ?></td>
          <td><?= $nama_karyawan; ?></td>
          <td><?= $jabatan; ?></td>
          <td><?= $bidang; ?></td>
          <td><?= $nip_atasan; ?></td>
        </tr>

        <?php
          }
        ?>
      </table>
    </section>

</body>

<script src="./script.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>


<script>$(document).ready(function () {
    $('#example').DataTable({
      ordering: true
    });
});</script>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</html>