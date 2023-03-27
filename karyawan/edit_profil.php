<?php
    require '../db_login.php';
    session_start();
    // isset not login
    if (!isset($_SESSION['email'])) {
        header("location:../index.php");
    }
    error_reporting(E_ERROR | E_PARSE);

    function getKaryawanDetail($email)
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

    // get detail karyawan
    $KaryawanDetail = getKaryawanDetail($_SESSION['email']);
    $queryjabatan = mysqli_query($conn, "select * from tb_jabatan");
    $querybidang = mysqli_query($conn, "select * from tb_bidang");
    $_SESSION['email'] = $KaryawanDetail['email'];
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title> Karyawan Dashboard </title>
    <link rel="icon" type="image/x-icon" href="../asset/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

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
        <a class="nav-link " href="karyawan.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Home</span>
        </a>
         <span class="tooltip">Home</span>
      </li>
      <li>
       <a class="nav-link active" href="edit_profil.php">
         <i class='bx bx-user' ></i>
         <span class="links_name">Edit Profil</span>
       </a>
       <span class="tooltip">Edit Profil</span>
     </li>
     <li>
       <a class="nav-link " href="./formizin.php">
         <i class='bx bx-chat' ></i>
         <span class="links_name">Form Izin</span>
       </a>
       <span class="tooltip">Form Izin</span>
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
            <img src="karyawan.png">
            <div class="name_job">
                <div class="name">Karyawan</div>
                <div class="email"><?php echo $KaryawanDetail['email']; ?></div>
            </div>
        </div>
        <i class="fa fa-bars" id="bars"></i>>
    </li>
    </ul>
</div>

          <?php
          $ambildata = mysqli_query($conn, "SELECT * from tb_karyawan WHERE nip_karyawan = '".$KaryawanDetail['nip_user']."'");
          $i = 1;
          while ($data = mysqli_fetch_array($ambildata)) {
              $nip_karyawan = $data['nip_karyawan'];
              $nama_karyawan= $data['nama_karyawan'];
              $nip_atasan = $data['nip_atasan'];

              if (isset($_POST['update'])) {
                $valid = true;
                $nama_karyawan = $_POST['nama_karyawan'];
                if (empty($nama_karyawan)) {
                    $valid = false;
                    $error_nama = "Nama karyawan tidak boleh kosong";
                } else if (!preg_match("/^[a-zA-Z ]*$/", $nama_karyawan)) {
                    $valid = false;
                    $error_nama = "Hanya huruf dan spasi yang diperbolehkan";
                }
                $nip_atasan = $_POST['nip_atasan'];
                if (empty($nip_atasan)) {
                    $valid = false;
                    $error_nip_atasan = "NIP tidak boleh kosong";
                } else if (!preg_match("/^[0-9]*$/", $nip_atasan)) {
                    $valid = false;
                    $error_nip_atasan = "Hanya angka yang diperbolehkan";
                }
                if ($valid) {
                    $queryedit = "UPDATE tb_karyawan SET nama_karyawan = '$nama_karyawan', nip_atasan = '$nip_atasan', id_jabatan = '$_POST[id_jabatan]',  id_bidang = '$_POST[id_bidang]'
                        WHERE nip_karyawan = '$nip_karyawan'";
                    $resultedit = mysqli_query($conn, $queryedit);
                    if ($resultedit) {
                        header("Location: karyawan.php");
                    } else {
                        $error = "Error: " . $queryedit . "<br>" . mysqli_error($conn);
                    }
                }
            }
        ?>
  <section class="home-section">
        <div class="container container-fluid">
            <form action="" method="POST">
                <div class="h4 mt-5 w-100 ">Edit Profil<br>
                    <div class="row row-cols-1 row-cols-md-1 g-4 mt-1">
                        <div class="col">
                            <div class="card rounded-4 ">
                                <div class="card-body">
                                    <!-- Editable content -->
                                    <div class="mx-5">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <h6 class="mb-2" style="font-weight: bold;">NIP Karyawan</h6>
                                            </div>
                                            <br>
                                            <div class="col-sm-12">
                                                <span class="form-control mb-2 bg-light" type="text-muted" name="nip_karyawan"
                                                    placeholder="NIP Karyawan"><?= $nip_karyawan; ?></span>
                                            </div>
                                            <p></p>
                                        </div>    

                                        <div class="row">
                                            <div class="col-sm-10">
                                                <h6 class="mb-2" style="font-weight: bold;">Nama Karyawan</h6>
                                            </div>
                                            <br>
                                            <div class="col-sm-12">
                                                <input type="hidden" name="nama_karyawan" value="<?= $nama_karyawan; ?>">
                                                <input type="nama_karyawan" name="nama_karyawan" placeholder="Nama Karyawan" value="<?= $nama_karyawan; ?>"  class="form-control" required>
                                            </div>
                                            <p id="error"><?php echo $error_nama; ?></p>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-10">
                                                <h6 class="mb-2" style="font-weight: bold;">Jabatan</h6>
                                            </div>
                                            <br>
                                            <div class="col-sm-12">
                                                <select name="id_jabatan" id="id_jabatan" class="form-control"
                                                    onchange="getJabatan(this.value)">
                                                    <option value="">---Pilih Jabatan---</option>
                                                    <?php while ($row = $queryjabatan->fetch_object()) {
                                                        echo '<option value="' . $row->id_jabatan . '">' . $row->nama_jabatan . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <p></p>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-10">
                                                <h6 class="mb-2" style="font-weight: bold;">Bidang</h6>
                                            </div>
                                            <br>
                                            <div class="col-sm-12">
                                                <select name="id_bidang" id="id_bidang" class="form-control"
                                                    onchange="getBidang(this.value)">
                                                    <option value="">---Pilih Bidang---</option>
                                                    <?php while ($row = $querybidang->fetch_object()) {
                                                        echo '<option value="' . $row->id_bidang . '">' . $row->nama_bidang . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <p></p>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-10">
                                                <h6 class="mb-2" style="font-weight: bold;">NIP Atasan</h6>
                                            </div>
                                            <br>
                                            <div class="col-sm-12">
                                                <input type="hidden" name="nip_atasan" value="<?= $nip_atasan; ?>">
                                                <input type="nip_atasan" name="nip_atasan" placeholder="NIP Atasan" value="<?= $nip_atasan; ?>"  class="form-control" required>
                                            </div>
                                            <p id="error"><?php echo $error_nip_atasan; ?></p>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end pt-4">
                                <div class="me-3">
                                    <input type="hidden" name="idm" value="<?= $idm; ?>">
                                    <a href="karyawan.php" class="btn btn-danger ">Cancel</a>
                                </div>
                                <div class="float-end">
                                    <button type="submit" class="btn btn-primary float-end" name="update"
                                        value="update">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
          }
        ?>
    </section>
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