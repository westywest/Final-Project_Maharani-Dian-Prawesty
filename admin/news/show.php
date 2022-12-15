<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="../../assets/style_admin.css">
    <title>Berita | Admin Panel</title>
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION['status']) != "login"){
            header("location:/FinalProject/admin");
        }
        if(isset($_POST['logout'])){
            session_destroy();
            header("location:/FinalProject/admin");
        }
        if(isset($_POST['home'])){
            header("location:/FinalProject/index.php");
        }
        include '../../connectDB.php';

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

    <div class="container-fluid">
        <div class="row">
            <div class="d-flex flex-column flex-shrink-0 p-3 sidebar" style="width: 260px;">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <span class="fs-4">ADMIN PANEL</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="/FinalProject/admin/dashboard.php" class="nav-link link-dark" aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/FinalProject/admin/authors/index.php" class="nav-link link-dark">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                            Author
                        </a>
                    </li>
                    <li>
                        <a href="/FinalProject/admin/categories/index.php" class="nav-link link-dark">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                            Kategori
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link active">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                            Berita
                        </a>
                    </li>
                    <li>
                        <a href="/FinalProject/admin/tag/index.php" class="nav-link link-dark">
                            <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                            Tag
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>
                        <strong style="text-transform:uppercase; margin-left: 9px;"><?php echo($_SESSION['username']) ?></strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow" data-popper-placement="top-start" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(0px, -33.6px, 0px);">
                        <li>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <button class="dropdown-item" type="submit" name="home">Home</button>
                                <button class="dropdown-item" type="submit" name="logout">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Daftar Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Berita</li>
                    </ol>
                </nav>
                <h1 class="h2">Detail</h1>
                <p>Anda sedang melihat detail Berita dari author <b><?php echo $name ?></b>.</p>

                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <img class="img-news" src="../../assets/upload/<?php echo $foto ?>" id="foto" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Berita</label>
                            <input type="text" class="form-control" id="title" placeholder="title" required value="<?php echo $title ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Author</label>
                            <input type="text" class="form-control" id="name" placeholder="Nama" required value="<?php echo $name ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori Berita</label>
                            <input type="text" class="form-control" id="category" placeholder="category" required value="<?php echo $category ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal Publikasi</label>
                            <input type="text" class="form-control" id="date" placeholder="date" required value="<?php echo $date ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Headline</label>
                            <textarea class="form-control" id="deskripsi" placeholder="deskripsi" disabled><?php echo $headline ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Isi Berita</label>
                            <textarea class="form-control" id="content" placeholder="content" disabled><?php echo $content ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="name_tag" class="form-label">Tag</label>
                            <input type="text" class="form-control" id="name_tag" placeholder="name_tag" required value="<?php echo $name_tag ?>" disabled>
                        </div>
                    </div>
                </div>
                <footer class="pt-5 d-flex justify-content-between">
                    <span>Copyright © 2022 <a href="#">GOINGNEWS.</a></span>
                    <ul class="nav m-0">
                        <li class="nav-item">
                            <a class="nav-link text-secondary"href="#">Hubungi Kami</a>
                        </li>
                    </ul>
                </footer>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css"></script>
    
</body>
</html>