<?php
    require '../db_login.php';
    require './aksi.php';
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
    function getJenisIzin($id_jenis_izin)
    {
        global $conn;
        $query = mysqli_query($conn, "SELECT * FROM tb_jenis_izin WHERE id_jenis_izin='$id_jenis_izin'");
        $data = mysqli_fetch_assoc($query);
        return $data;
    }

    // get detail karyawan
    $KaryawanDetail = getKaryawanDetail($_SESSION['email']);
    $_SESSION['email'] = $KaryawanDetail['email'];
    $queryjenisizin = mysqli_query($conn, "select * from tb_jenis_izin");
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
       <a class="nav-link " href="edit_profil.php">
         <i class='bx bx-user' ></i>
         <span class="links_name">Edit Profil</span>
       </a>
       <span class="tooltip">Edit Profil</span>
     </li>
     <li>
       <a class="nav-link active" href="formizin.php">
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

  <section class="home-section">
   
      <div class="h4 mt-5 w-100 mb-5 ">Form Pengajuan Cuti

      <a href="karyawan.php">
        <button type="button" class="btn btn-primary float-end" >
          Kembali
        </button></a>
      </div>

      <div class="card p-5 rounded-4 mt-3">

      <form method="POST" autocomplete="on"  name="form">
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="id_surat_izin">NIP Atasan</label>
            <input type="text" name="id_surat_izin" placeholder="NIP Atasan" class="form-control" value="<?php if(isset($id_surat_izin)) {echo $id_surat_izin;} ?>" >
            <div class="error text-danger fst-italic"> <?php if(isset($error_id_surat_izin)) echo $error_id_surat_izin; ?> </div>
        </div>
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control" value="<?php if(isset($nama_lengkap)) {echo $nama_lengkap;} ?>" >
            <div class="error text-danger fst-italic"> <?php if(isset($error_nama_lengkap)) echo $error_nama_lengkap; ?> </div>
        </div>
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" placeholder="Tanggal" class="form-control" value="<?php if(isset($tanggal)) {echo $tanggal;} ?>" >
        </div>
        <div class="form-group  mb-4">
            <label class="h6" for="jam_pergi">Jam Pergi</label>
            <input type="time" name="jam_pergi" placeholder="Jam Pergi" class="form-control" value="<?php if(isset($jam_pergi)) {echo $jam_pergi;} ?>" >
        </div>
        <div class="form-group  mb-4">
            <label class="h6" for="jam_kembali">Jam Kembali</label>
            <input type="time" name="jam_kembali" placeholder="Jam Kembali" class="form-control" value="<?php if(isset($jam_kembali)) {echo $jam_kembali;} ?>" >
        </div>
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="id_jenis_izin">Jenis Izin</label>
            <select name="id_jenis_izin" id="id_jenis_izin" class="form-control"
                onchange="getJenisIzin(this.value)">
                <option value="">Pilih Jenis Izin</option>
                <?php while ($row = $queryjenisizin->fetch_object()) {
                    echo '<option value="' . $row->id_jenis_izin . '">' . $row->nama_izin . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group  mb-4">
            <label class="h6" class="h6" for="keperluan">Keperluan</label>
            <input type="text" name="keperluan" placeholder="Keperluan" class="form-control" value="<?php if(isset($keperluan)) {echo $keperluan;} ?>" >
            <div class="error text-danger fst-italic"> <?php if(isset($error_keperluan)) echo $error_keperluan; ?> </div>
        </div>
        <input type="hidden" name="verifikasi" value="Pending">
        <button type="submit" name="add_surat_izin" value="add_surat_izin" class="btn btn-primary w-100 mb-3">Submit</button>
      </form>

    </div>
  </div>
</body>
</section>
<script src="../library/js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="./script.js"></script>

<script>
  $(function(){
		$('#datepicker').datepicker(
      clearBtn: true;
    );
	});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</html>