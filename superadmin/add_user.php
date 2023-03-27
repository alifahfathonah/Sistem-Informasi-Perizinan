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

    // get detail user
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
        <a class="nav-link active" href="superadmin.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Home</span>
        </a>
         <span class="tooltip">Home</span>
      </li>
      <li>
       <a class="nav-link " href="datakaryawan.php">
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
   
      <div class="h4 mt-5 w-100 mb-5 ">Tambah Data User

      <a href="superadmin.php">
        <button type="button" class="btn btn-primary float-end" >
          Kembali
        </button></a>
      </div>

      <div class="card p-5 rounded-4 mt-3">

      <form method="POST" autocomplete="on"  name="form">
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="nip_user">NIP</label>
            <input type="nip_user" name="nip_user" placeholder="NIP User" class="form-control" value="<?php if(isset($nip_user)) {echo $nip_user;} ?>" >
            <div class="error text-danger fst-italic"> <?php if(isset($error_nip_user)) echo $error_nip_user; ?> </div>
        </div>
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="email">Email</label>
            <input type="email" name="email" placeholder="Email" class="form-control" value="<?php if(isset($email)) {echo $email;} ?>" >
            <div class="error text-danger fst-italic"> <?php if(isset($error_email)) echo $error_email; ?> </div>
        </div>
        <div class="form-group  mb-4">
            <label class="h6" for="password">Password</label>
            <input type="hidden">
            <input type="password" name="password" placeholder="Password" value=""  class="form-control mb-2">
            <div class="error text-danger fst-italic"> <?php echo $error_password; ?></div>
        </div>
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="status_user">Status</label>
            <select name="status_user" class="form-select" aria-label="Default select example">
                <option value="superadmin">superadmin</option>
                <option value="karyawan">karyawan</option>
                <option value="atasan">atasan</option>
            </select>
        </div>
        <button type="submit" name="add_user" value="add_user" class="btn btn-primary w-100 mb-3">Submit</button>
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
 </html>
