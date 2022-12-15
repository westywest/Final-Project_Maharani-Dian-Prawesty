<?php
    ob_start();
    include 'connectDB.php';

    $sql = "SELECT * FROM authors;";

    $datas = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author</title>
    </style>
</head>
<body>
    <center>
        <h2 class="text-center">Author GOINGNEWS</h2>
        <table border="1" cellspacing="0" cellpadding="7"> 
            <thead>
                <tr>
                    <th scope="col-2">No</th>
                    <th scope="col-5">Nama</th>
                    <th scope="col-5">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datas as $key => $data):?>
                    <tr>
                        <td><?php echo ($key+1); ?></td>
                        <td><?php echo $data['name']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </center>
    <?php
        require './mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(
            ['mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 25,
            'margin_bottom' => 25,
            'margin_left' => 25,
            'margin_right' => 25]
        );
        $html = ob_get_contents();

        ob_end_clean();
        $mpdf->WriteHTML(utf8_encode($html));
        
        $content = $mpdf->Output("cetak_author.pdf", "D");
    ?>
</body>
</html>
