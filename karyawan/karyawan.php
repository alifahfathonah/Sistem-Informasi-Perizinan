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

    // get detail karyawan
    $KaryawanDetail = getKaryawanDetail($_SESSION['email']);
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
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
        <a class="nav-link active" href="karyawan.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Home</span>
        </a>
         <span class="tooltip">Home</span>
      </li>
      <li>
       <a class="nav-link " href="edit_profil.php">
         <i class='bx bx-user' ></i>
         <span class="links_name">Edit Profil</span>
       </a>
       <span class="tooltip">Edit Profil</span>
     </li>
     <li>
       <a class="nav-link " href="formizin.php">
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
          $ambildata = mysqli_query($conn, "SELECT * from tb_karyawan, tb_jabatan, tb_bidang WHERE tb_karyawan.id_jabatan = tb_jabatan.id_jabatan AND tb_karyawan.id_bidang = tb_bidang.id_bidang AND nip_karyawan = '".$KaryawanDetail['nip_user']."'");
          $i = 1;
          while ($data = mysqli_fetch_array($ambildata)) {
              $nip_karyawan = $data['nip_karyawan'];
              $nama_karyawan= $data['nama_karyawan'];
              $nip_atasan = $data['nip_atasan'];
              $nama_bidang =$data['nama_bidang'];
              $nama_jabatan = $data['nama_jabatan'];}
        ?>

    <section class="home-section">
        <div class="container-fluid">
            <!--write in one line-->
            <div class="h4 mt-5 w-100 ">Home
                <div class="h4 float-end">
                    <h4>Halo, <?= $nama_karyawan; ?></h4>
                </div>
            </div><br>

            <!--Card dari kolom profil mahasiswa-->

            <div class="row row-cols-1 row-cols-md-1 g-4 mt-1">

                <div class="col">
                    <div class="card rounded-4 card-active ">
                        <div class="card-body">
                            <span class="tooltip"></span>

                            <div class="px-5">
                                <table class="table table-responsive">

                                    <tr>
                                        <th>NIP Karyawan</th>
                                        <td><?= $nip_karyawan; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Karyawan</th>
                                        <td><?= $nama_karyawan; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Jabatan</th>
                                        <td><?= $nama_jabatan; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Bidang</th>
                                        <td><?= $nama_bidang; ?></td>
                                    </tr>
                                    <tr>
                                        <th>NIP Atasan</th>
                                        <td><?= $nip_atasan; ?></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
			
			<div class="h4 mt-5 w-100 ">Riwayat Perizinan
                <div class="h4 float-end">
                </div>
            </div>
			
			<div class="row row-cols-1 row-cols-md-1 g-4 mt-1">

                <div class="col">
                    <div class="card rounded-4 card-active ">
                        <div class="card-body">
                            <span class="tooltip"></span>

                            <div class="px-5">
                                <table id="example" class="table   rounded-3" style="width:100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Lengkap</th>
										<th>Tanggal</th>
										<th>Jam Pergi</th>
										<th>Jam Kembali</th>
                                        <th>Jenis Izin</th>
										<th>Keperluan</th>
									</tr>
								</thead>
								<tbody>
								  <?php
								  $ambildata = mysqli_query($conn, 'SELECT * FROM tb_surat_izin, tb_jenis_izin WHERE tb_surat_izin.id_jenis_izin = tb_jenis_izin.id_jenis_izin');
								  $i = 1;
								  while ($data = mysqli_fetch_array($ambildata)) {
									  $nama_lengkap = $data['nama_lengkap'];
									  $tanggal= $data['tanggal'];
									  $jam_pergi = $data['jam_pergi'];
									  $jam_kembali = $data['jam_kembali'];
                                      $id_jenis_izin = $data['nama_izin'];
                                      $id_surat_izin = $data['id_surat_izin'];
									  $keperluan = $data['keperluan'];
                                      $verifikasi = $data['verifikasi'];
								  ?>

								<tr>
								  <td><?= $i++; ?></td>
								  <td><?= $nama_lengkap; ?></td>
								  <td><?= $tanggal; ?></td>
								  <td><?= $jam_pergi; ?></td>
								  <td><?= $jam_kembali; ?></td>
                                  <td><?= $id_jenis_izin; ?></td>
								  <td><?= $keperluan; ?></td>
                                </tr>

								<?php
								  }
								?>
							  </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
			
			<div class="row row-cols-1 row-cols-md-1 g-4 mt-1" id="datadiri">
                <div class="col">
                    <div class="card rounded-4 ">
                        <div class="card-body">
                            <p class="text-center" id="title1">Status Perizinan</p>
                            <?php if ($verifikasi == 'Disetujui') {
                                $color = 'green';
                            } else if ($verifikasi == 'Ditolak') {
                                $color = 'red';
                            } else{
                                $color = 'orange';
                            }?>
                            <h2 class="mb-3" style="color:<?php echo $color ?>; text-align:center;">
                                <?php echo $verifikasi; ?></h2>
                                <div style="display: flex; justify-content: center; align-items: center; height: 10px; padding-top: 20px; padding-bottom: 20px;">
                                    <a href="printable.php">
                                        <button id="btnSubmit" type="button" class="btn btn-primary">Print</button>
                                    <a>             
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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