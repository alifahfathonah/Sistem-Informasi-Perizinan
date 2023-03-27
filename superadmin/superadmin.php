<?php
    require '../db_login.php';
    require './aksi.php';
    session_start();
    // isset not login
    if (!isset($_SESSION['email'])) {
        header("location:../index.php");
    }
    error_reporting(E_ERROR | E_PARSE);

    function getSuperadminDetail($email)
    {
        global $conn;
        $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE email='$email'");
        $data = mysqli_fetch_assoc($query);
        return $data;
    }

    // get detail superadmin
    $SuperadminDetail = getSuperadminDetail($_SESSION['email']);
    $_SESSION['email'] = $SuperadminDetail['email'];

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
                <div class="email"><?php echo $SuperadminDetail['email']; ?></div>
            </div>
        </div>
        <i class="fa fa-bars" id="bars"></i>
    </li>
    </ul>
  </div>

  <section class="home-section">
      <div class="container">
      <div class="h4 mt-5 w-100 ">Home
      <button type="button" class="btn btn-danger float-end ms-3" data-bs-toggle="modal" data-bs-target="#myModal">
      Hapus Semua
      </button>

      <a href="./add_user.php">
      <button type="button" class="btn btn-primary float-end" >
        Tambah Data User
      </button></div><br></a>
      <div class=" mt-4 mb-4 w-100">Data User PT PLN INDONESIA POWER SEMARANG PGU</div>
      <div class="card p-4 rounded-4">
      <table id="example" class="table   rounded-3" style="width:100%">
        <thead>
            <tr>
                <th>NIP User</th>
                <th>Email</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $ambildata = mysqli_query($conn, 'SELECT * FROM tb_user');
          while ($data = mysqli_fetch_array($ambildata)) {
              $nip_user = $data['nip_user'];
              $email = $data['email'];
              $status_user = $data['status_user'];
          ?>

        <tr>
          <td><?= $nip_user; ?></td>
          <td><?= $email; ?></td>
          <td><?= $status_user; ?></td>
          <td>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="edit_user" data-bs-toggle="modal" data-bs-target="#edit_user<?= $nip_user;?>">Edit</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" name="delete_user" data-bs-toggle="modal" data-bs-target="#delete_user<?= $nip_user;?>">Hapus</button>
          </td>
        </tr>
        
          <!-- Edit Modal -->
        <div class="modal fade" id="edit_user<?= $nip_user;?>">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Edit Data User</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="POST">
              <div class="modal-body">
              <label for="nip_user">NIP User</label>
                    <span class="form-control mb-2 bg-light" type="text-muted" name="nip_user"
                          placeholder="NIP User"><?= $nip_user; ?></span>
              <p></p>
              <label for="email">Email</label>
                <input type="hidden" name="id" value="<?= $nip_user; ?>">
                <input type="email" name="email" placeholder="Email" value="<?= $email; ?>"  class="form-control" required>
              <br>

              <label for="password">Password</label>
                <input type="hidden" name="id" value="<?= $nip_user; ?>">
                <input type="password" name="password" placeholder="Password" value="<?= $password; ?>"  class="form-control" required>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
              <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="edit_user">Submit</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
              </div>
            </form>

              </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="delete_user<?= $nip_user;?>">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Hapus Data User</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="POST">
              <div class="modal-body">
                <input type="hidden" name="id" value="<?= $email; ?>">
                <h6>Apakah yakin akan menghapus </h6> <?= $email; ?>
                <br>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
              <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" name="delete_user">Hapus</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
              </div>
            </form>

              </div>
            </div>
        </div>

        <?php
          }
        ?>
      </table>
    </div>
  </div>

<!-- The Modal Delete All -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Hapus Data</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form action="" method="POST">
        <!-- Modal body -->
        <div class="modal-body">
          Apakah Anda yakin untuk hapus semua data user?
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" name="delete_all_user">Ya</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  </div>
      <footer>
      <div class="card card-body my-5 mx-2 rounded-4" style=>
        <div class="float-end">PT PLN INDONESIA POWER - Copyright © 2023</div>
      </div>
      </footer>
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