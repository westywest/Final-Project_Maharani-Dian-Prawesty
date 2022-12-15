<?php
    ob_start();
    include 'connectDB.php';

    $id = $_GET['id'];
    $sql = "SELECT * FROM authors WHERE id='$id'";
    $datas = $conn->query($sql);

    while($data = mysqli_fetch_array($datas)){
        $name = $data['name'];
        $phone = $data['phone'];
        $foto = $data['foto'];
        $jk = $data['jk'];
        $email = $data['email'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Author - <?= $name ?></title>
    <style>
        .img-cetak{
            width: 110px;
            height: 140px;
            object-fit: cover;
            object-position: 50% 50%;
        }
    </style>
</head>
<body>
    <center>
        <table border="1" width="100%" cellspacing="0" cellpadding="7"> 
            <tr>
                <td colspan="3" align="center"><b>DETAIL AUTHOR</b></td>
            </tr>
            <tr>
                <td><b>Nama</b></td>
                <td><?php echo $name; ?></td>
                <td rowspan="8" align="center"><img src="assets/upload/<?php echo $foto; ?>" class="img-cetak" alt=""></td></td>
            </tr>
            <tr>
                <td><b>Jenis Kelamin</b></td>
                <td><?php echo $jk; ?></td>
            </tr>
            <tr>
                <td><b>Phone</b></td>
                <td><?php echo $phone; ?></td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><?php echo $email; ?></td>
            </tr>
        </table>
    </center>
    <?php
        require './mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(
            ['mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_top' => 25,
            'margin_bottom' => 25,
            'margin_left' => 25,
            'margin_right' => 25]
        );
        $html = ob_get_contents();

        ob_end_clean();
        $mpdf->WriteHTML(utf8_encode($html));
        
        $content = $mpdf->Output("Cetak Author - ".$name.".pdf", "D");
    ?>
</body>
</html>
