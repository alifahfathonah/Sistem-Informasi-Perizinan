<?php
require '../db_login.php';
require('fpdf185/fpdf.php');

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
    $verifikasi = $data['verifikasi'];}

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',14);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130	,5,'PT PLN Indonesia Power Semarang PGU',0,0);
$pdf->Cell(59	,5,'Form Approval',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130	,5,'Komplek Pelabuhan Jl. Ronggowarsito No.1',0,0);
$pdf->Cell(59	,5,'',0,1);//end of line

$pdf->Cell(130	,5,'Kota Semarang, Jawa Tengah, 50174',0,0);
$pdf->Cell(25	,5,'',0,0);
$pdf->Cell(34	,5,'',0,1);//end of line

$pdf->Cell(130	,5,'Phone +(024) 3518371',0,0);


//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//billing address
$pdf->SetFont('Arial','B',12);
$pdf->Cell(100	,5,'Keterangan:',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->SetFont('Arial','',12);
$pdf->Cell(40	,5,'Nama Lengkap:',0,0);
$pdf->Cell(90	,5,$nama_lengkap,0,1);

$pdf->Cell(40	,5,'Jam Pergi:',0,0);
$pdf->Cell(90	,5,$jam_pergi,0,1);

$pdf->Cell(40	,5,'Jam kembali:',0,0);
$pdf->Cell(90	,5,$jam_kembali,0,1);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189	,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',12);

$pdf->Cell(125	,5,'Keperluan',1,0);
$pdf->Cell(30	,5,'Tanggal',1,0, 'C');
$pdf->Cell(34	,5,'Jenis Izin',1,1,'C');//end of line

$pdf->SetFont('Arial','',12);

//Numbers are right-aligned so we give 'R' after new line parameter

$pdf->Cell(125	,5,$keperluan,1,0);
$pdf->Cell(30	,5,$tanggal,1,0, 'C');
$pdf->Cell(34	,5,$id_jenis_izin,1,1,'C');//end of line

//summary
$pdf->Cell(130	,5,'',0,0);
$pdf->Cell(25	,5,'Status',0,0, 'C');

$pdf->SetTextColor(0,153,0);
$pdf->Cell(34	,5,$verifikasi,1,1,'C');//end of line

$pdf->Output();
?>