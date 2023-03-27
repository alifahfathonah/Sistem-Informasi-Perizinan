<?php
  session_start();
  include('db_login.php');
  $gagal = '';
  if (isset($_GET['pesan'])) {
    $gagal = "Email atau Password salah";
  }

  if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
  
    if ($email == '') {
      $error_email = "Email is required";
      $valid = FALSE;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error_email = "Invalid email format";
      $valid = FALSE;
    }
    //cek validasi password
    $password = ($_POST['password']);
    if ($password == '') {
      $error_password = "Password is required";
      $valid = FALSE;
    }
  
    if (!$email == '' && !$password == '') {
      $query = mysqli_query($conn, "select * from tb_user where email='$email' and password='$password'");
      $cek = mysqli_num_rows($query);
  
      if ($cek > 0) {
  
        $data = mysqli_fetch_assoc($query);
  
        // cek jika user login sebagai superadmin
        if ($data['status_user'] == "superadmin") {
          // buat session login dan username
          $_SESSION['email'] = $email;
          $_SESSION['status_user'] = "superadmin";
          header("location:./superadmin/superadmin.php");
  
  
          // cek jika user login sebagai atasan
        } else if ($data['status_user'] == "atasan") {
          // buat session login dan email
          $_SESSION['email'] = $email;
          $_SESSION['status_user'] = "atasan";
          header("location: ./atasan/atasan.php");
  
          // cek jika user login sebagai karyawan
        } else if ($data['status_user'] == "karyawan") {
          // buat session login dan email
          $_SESSION['email'] = $email;
          $_SESSION['status_user'] = "karyawan";
          header("location:./karyawan/karyawan.php");
        } else {
  
          // alihkan ke halaman login kembali
          header("location:index.php?pesan=gagal");
        }
      } else {
        header("location:index.php?pesan=gagal");
      }
    }
  }
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="asset/favicon.ico">
    <title>PT PLN Indonesia Power</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <style>
    .gradient-custom {
        background: rgb(131, 58, 180);
        background: linear-gradient(90deg, rgba(131, 58, 180, 1) 0%, rgba(253, 29, 29, 1) 50%, rgba(252, 176, 69, 1) 100%);
    }
    </style>
</head>

<body>

    <!-- Section: Design Block -->
    <section class="background-radial-gradient overflow-hidden">
        <style>
        .background-radial-gradient {
            background-color: hsl(218, 41%, 15%);
            background-image: radial-gradient(650px circle at 0% 0%,
                    hsl(218, 41%, 35%) 15%,
                    hsl(218, 41%, 30%) 35%,
                    hsl(218, 41%, 20%) 75%,
                    hsl(218, 41%, 19%) 80%,
                    transparent 100%),
                radial-gradient(1250px circle at 100% 100%,
                    hsl(218, 41%, 45%) 15%,
                    hsl(218, 41%, 30%) 35%,
                    hsl(218, 41%, 20%) 75%,
                    hsl(218, 41%, 19%) 80%,
                    transparent 100%);
        }
        .bg-glass {
            background-color: hsla(0, 0%, 100%, 0.9) !important;
            backdrop-filter: saturate(200%) blur(25px);
        }
        .waves {
          position:relative;
          width: 100%;
          height:15vh;
          margin-bottom:-7px; /*Fix for safari gap*/
          min-height:100px;
          max-height:150px;
        }
        .parallax > use {
          animation: move-forever 25s cubic-bezier(.55,.5,.45,.5)     infinite;
        }
        .parallax > use:nth-child(1) {
          animation-delay: -2s;
          animation-duration: 7s;
        }
        .parallax > use:nth-child(2) {
          animation-delay: -3s;
          animation-duration: 10s;
        }
        .parallax > use:nth-child(3) {
          animation-delay: -4s;
          animation-duration: 13s;
        }
        .parallax > use:nth-child(4) {
          animation-delay: -5s;
          animation-duration: 20s;
        }
        @keyframes move-forever {
          0% {
          transform: translate3d(-90px,0,0);
          }
          100% { 
          transform: translate3d(85px,0,0);
          }
        }
        /*Shrinking for mobile*/
        @media (max-width: 768px) {
          .waves {
          height:40px;
          min-height:40px;
          }
          .content {
          height:30vh;
          }
          h1 {
          font-size:24px;
          }
        }

        @font-face {
          font-family: customFonts;
          src: url(big_river_sample.ttf);
          h2{
            font-family: customFonts;
          }
        }

        @font-face{
          font-family: customFonts2;
          src: url(helvetica.ttf);
          h3{
            font-family: customFonts2
          }
        }
        </style>


        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                        Sistem Informasi <br />
                        <span style="color: #01B9EF">Surat Izin</span><br>
                        <span style="font-size:45px"> PT PLN INDONESIA POWER</span>
                    </h1>
                    <p class="mb-4 opacity-70" style="color: #01B9EF">
                        Sistem informasi ini digunakan untuk mengatur perizinan karyawan <br>
                        PT PLN INDONESIA POWER SEMARANG PGU untuk meninggalkan kantor. 
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
                    <style>
                    * {
                        text-align: c;
                    }
                    </style>

                    <div class="card bg-glass rounded-4">
                        <div class="card-body px-3 py-4 px-md-5 rounded-4">
                            <div class="mx-auto"><img src="asset/pln.png"
                                    style=" display: block; margin-left: auto; margin-right: auto; width: 30%;" alt="">
                            </div>
                            <h2 class="mx-auto" style="text-align:center; font-weight: bold; color:#01B9EF;">PLN</h2>
                            <h3 class="mx-auto" style="text-align:center; color:#245B6E; margin-bottom: 50px;">Indonesia Power</h3>
                            <form method="POST" autocomplete="on"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="form-outline form-white mb-4">
                                    <input type="email" id="email" name="email" class="form-control form-control-lg"
                                        value="<?php if (isset($email)) echo $email; ?>" />
                                    <label class="form-label" for="email">Email</label>
                                    <div class="text-danger"><?php if (isset($error_email)) echo $error_email; ?></div>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="password" value="" name="password"
                                        class="form-control form-control-lg" />
                                    <label class="form-label" for="password">Password</label>
                                    <div class="text-danger"><?php if (isset($error_password)) echo $error_password; ?>
                                    </div>
                                </div>
                                <p style="color:red;"><?php echo $gagal ?></p>

                                <button class="btn btn-primary btn-lg px-5 w-100" type="login" name="login"
                                    value="login">Login</button><br>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div>
			<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
				viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
			<defs>
			<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
			</defs>
			<g class="parallax">
				<use xlink:href="#gentle-wave" x="18" y="0" fill="rgba(255,255,255,0.7)" />
				<use xlink:href="#gentle-wave" x="18" y="3" fill="#01B9EF" />
				<use xlink:href="#gentle-wave" x="18" y="5" fill="rgba(255,255,255,0.3)" />
				<use xlink:href="#gentle-wave" x="18" y="7" fill="#fff" />
			</g>
			</svg>
		</div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
</body>
</html>
