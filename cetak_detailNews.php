<?php
    ob_start();
    include 'connectDB.php';

    $id = $_GET['id'];
    $sql = "SELECT news.id, news.title, news.author_id, authors.id as authorsID, authors.name, 
    news.date, news.category_id, categories.id as categoryID, news.foto, categories.category, news.headline, news.content, news.tag_id, tag.id as tagID, tag.name_tag FROM news 
    JOIN authors ON authors.id = news.author_id
    JOIN categories ON categories.id = news.category_id
    JOIN tag ON tag.id = news.tag_id WHERE news.id = '$id';";
    $datas = $conn->query($sql);

    while($data = mysqli_fetch_array($datas)){
        $title = $data['title'];
        $name = $data['name'];
        $category = $data['category'];
        $date = $data['date'];
        $foto = $data['foto'];
        $headline = $data['headline'];
        $content = $data['content'];
        $name_tag = $data['name_tag'];
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Berita - <?= $title ?></title>
    <style>
        .img-cetak{
            width: 200px;
            height: 150px;
            object-fit: cover;
            object-position: 50% 50%;
        }
    </style>
</head>
<body>
    <table border="1" width="100%" cellspacing="0" cellpadding="7"> 
    <tr>
                <td colspan="3" align="center"><b>DETAIL BERITA</b></td>
            </tr>
            <tr>
                <td><b>Judul</b></td>
                <td><?php echo $title; ?></td>
                <td rowspan="8" align="center"><img src="assets/upload/<?php echo $foto; ?>" class="img-cetak" alt=""></td></td>
            </tr>
            <tr>
                <td><b>Author</b></td>
                <td><?php echo $name; ?></td>
            </tr>
            <tr>
                <td><b>Kategori</b></td>
                <td><?php echo $category; ?></td>
            </tr>
            <tr>
                <td><b>Tanggal Publikasi</b></td>
                <td><?php echo $date; ?></td>
            </tr>
            <tr>
                <td><b>Headline</b></td>
                <td><?php echo $headline; ?></td>
            </tr>
            <tr>
                <td><b>Isi Berita</b></td>
                <td><?php echo $content; ?></td>
            </tr>
            <tr>
                <td><b>Tag</b></td>
                <td><?php echo $name_tag; ?></td>
            </tr>
    </table>
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
        
        $content = $mpdf->Output("Cetak Berita - ".$title.".pdf", "D");
    ?>
</body>
</html>
