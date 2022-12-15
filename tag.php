<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <title>GOING NEWS.</title>
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
    JOIN tag ON tag.id = news.tag_id WHERE tag.id = '$id' ORDER BY news.id DESC;";
    
    if(isset($_GET['cari'])){
      $pencarian = $_GET['cari'];
      $sql = "SELECT news.id, news.title, news.author_id, authors.id as authorsID, authors.name, 
      news.date, news.category_id, categories.id as categoryID, news.foto, categories.category, news.headline, news.content, news.tag_id, tag.id as tagID, tag.name_tag FROM news 
      JOIN authors ON authors.id = news.author_id
      JOIN categories ON categories.id = news.category_id
      JOIN tag ON tag.id = news.tag_id WHERE title like '%".$pencarian."%'";
    }

    $datas = $conn->query($sql);
    $tag_sql = "SELECT * FROM tag ORDER BY id DESC;";
    $tags = $conn->query($tag_sql);

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

    function make_query($conn){
      $query = "SELECT id, title, foto, headline FROM news ORDER BY id DESC LIMIT 3";
      $result = mysqli_query($conn, $query);
      return $result;
    }

    function make_slide_indicators($conn){
      $output = '';
      $count = 0;
      $result = make_query($conn);
      while($row = mysqli_fetch_array($result)){
        if($count ==0){
          $output .= '
          <button type="button" data-bs-target="#dynamic_slide_show" data-bs-slide-to="'.$count.'" class="active" aria-current="true"></button>
          ';
        }else{
          $output .= '
          <button type="button" data-bs-target="#dynamic_slide_show" data-bs-slide-to="'.$count.'"></button>
          ';
        }
        $count = $count + 1;
      }
      return $output;
    }

    function make_slides($conn){
      $output = '';
      $count = 0;
      $result = make_query($conn);
      while($row = mysqli_fetch_array($result)){
        if($count == 0){
          $output .= '<div class="carousel-item active c-item">';
        }else{
          $output .= '<div class="carousel-item c-item">';
        }
        $output .= '
          <img src="assets/upload/'.$row["foto"].'" class="d-block w-100 c-img" alt="...">
          <div class="carousel-caption d-none d-md-block">
              <h2>'.$row["title"].'</h2>
              <p>'.$row["headline"].'</p>
              <a href="show_detail.php?id='.$row['id'].'"><button class="btn btn-primary">Selengkapnya</button></a>
            </div>
          </div>
        ';
        $count = $count + 1;
      }
      return $output;
    }
  ?>

    <nav class="navbar navbar-expand-lg fixed-top">
      <div class="container container-fluid">
        <a class="navbar-brand" href="index.php"><img src="assets/img/LOGO1.png" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="me-auto"></div>
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="d-flex" role="search">
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

    <div id="dynamic_slide_show" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
         <?php echo make_slide_indicators($conn); ?>
      </div>
      <div class="carousel-inner">
        <?php echo make_slides($conn); ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#dynamic_slide_show" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#dynamic_slide_show" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <div class="container" style="margin-top: 40px;">
    <h3 style="color: #1f3072; text-weight: bold;">HASIL PENCARIAN</h3>
    <hr>
    
      <div class="row row-cols-1 row-cols-md-4 g-4">
      <?php
        foreach($datas as $data):?>
        <div class="col">
          <div class="card" style="width: 20rem; height:19rem;">
            <img src="assets/upload/<?php echo $data['foto'];?>" class="card-img-top n-img" alt="...">
            <div class="card-body">
              <p><small style="color: red;"><?php echo $data['category']; ?></small><small class="text-muted"> • <?php echo date( "d M Y | H:i", strtotime($data['date']));?></small></p>
              <h5 class="card-title"><a href="<?='show_detail.php?id='.$data['id'].''?>" class="judul"><?php echo $data['title']; ?></a></h5>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <h3 style="color: #1f3072; text-weight: bold; margin-top: 50px;">CARI BERDASARKAN TAG</h3>
      <hr>
      <div class="row row-cols-1 row-cols-md-5 g-4 center">
        <?php
          foreach($tags as $tag):
        ?>
        <div class="col"><a href="<?= 'tag.php?id='.$tag['id'];?>"><button class="btn-tag">#<?php echo $tag['name_tag']; ?></button></a></div>
        <?php endforeach; ?>
      </div>
    </div>
    
    <footer class="py-5" style="margin-top: 30px;">
      <div class="container">
        <div class="row row-cols-4 " style="color: white;">
          <div class="col d-flex justify-content-start" style="padding-bottom: 10px;"><img src="assets/img/LOGO1.png" alt=""></div>
            <div class="col"> </div>
            <div class="col-6">
              <ul class="nav justify-content-end">
                <li class="nav-item"><a href="#" class="nav-link px-2" style="color: white;">Home</a></li>
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