<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <title>GOING NEWS</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <?php
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
            $id_tag = $data['tagID'];
            $name_tag = $data['name_tag'];
        }
    ?>
    
    <nav class="navbar navbar-expand-lg">
      <div class="container container-fluid">
        <a class="navbar-brand" href="index.php"><img src="assets/img/LOGO1.png" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="me-auto"></div>
          
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <form  action="index.php" method="GET" class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Cari Berita" name="cari" value="<?php if(isset($_GET['cari'])){ echo $_GET['cari'];} ?>" autocomplete="off">
                <button type="submit" style="border: 0px; background-color: transparent; background-repeat: no-repeat; overflow: hidden; outline: none; width: 50px; height: 40px;">
                  <a class="nav-link" style="color: white;">
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </a>
                </button>
              </form>
            </li>
            <li class="nav-item">
              <a class="nav-link active" style="color: #f9f9f9;" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #f9f9f9;">
                <i class="fa-solid fa-circle-user"></i>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/FinalProject/admin/index.php">Admin</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container" style="margin-top: 50px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/FinalProject/index.php" style="text-decoration:none; color: #1f3072;">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $title ?></li>
            </ol>
        </nav>
        <div class="pb-5">
            <div class="bg-white p-4 rounded-4">
                <h2 class="titleContent"><?php echo $title ?></h2><br>
                <div class="author">
                  <p class="card-text text-center" style="color: red; font-weight: bold;"><small style="color: #707070;"><?php echo $name ?> -</small> <?php echo $category ?></p>
                </div>
                <div class="text-center">
                  <small class="text-muted"><?php echo date( "l, d M Y | H:i", strtotime($date));?></small>
                </div>
                <div class="center"><img src="assets/upload/<?php echo $foto;?>" class="det-img" alt=""></div>
                <br>
                <p class="content"><b style="color: #1f3072;">Going News, </b><?php echo $content ?></p>
            </div>
            <div class="d-flex flex-row-reverse" style="margin-top: 20px;">
              <div class="p-2"><a href="#"><i class="fa-brands fa-facebook fa-xl" style="color: #1f3072;"></i></a></div>
              <div class="p-2"><a href="#"><i class="fa-brands fa-twitter fa-xl" style="color: #1f3072;"></i></a></div>
              <div class="p-2"><a href="whatsapp://send?text=/FinalProject/show_detail.php"><i class="fa-brands fa-whatsapp fa-xl" style="color: #1f3072;"></i></a></div>
              <div class="p-2"><a href="#"><i class="fa-solid fa-link fa-xl" style="color: #1f3072;"></i></a></div>
              <div class="p-2">SHARE</div>
              <div class="col"><a href="<?= 'tag.php?id='.$id_tag;?>"><button class="btn-tag">#<?php echo $name_tag; ?></button></div>
            </div>
        </div>
    </div>
    
    <footer class="py-5" style="margin-top: 30px;">
      <div class="container">
        <div class="row row-cols-4 " style="color: white;">
          <div class="col d-flex justify-content-start" style="padding-bottom: 10px;"><img src="assets/img/logo1.png" alt=""></div>
            <div class="col"> </div>
            <div class="col-6">
              <ul class="nav justify-content-end">
                <li class="nav-item"><a href="/FinalProject/index.php" class="nav-link px-2" style="color: white;">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2" style="color: white;">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2" style="color: white;">About</a></li>
              </ul>
            </div>
            <div class="col col-md-2">
              <ul class="nav flex-column justify-content-start">
                <li><br></li>
                <li class="nav-item mb-2"><p>FOLLOW US</p></li>
                <li class="nav-item mb-2">
                  <a href="#"><i class="fa-brands fa-square-twitter fa-2xl" style="color: white; margin-right: 10px;"></i></a>
                  <a href="#"><i class="fa-brands fa-instagram fa-2xl" style="color: white; margin-right: 10px;"></i></a>
                  <a href="#"><i class="fa-brands fa-square-facebook fa-2xl" style="color: white; margin-right: 10px;"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <p class="text-center" style="color: white;">© 2022 GOING NEWS. All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css"></script>

</body>
</html>