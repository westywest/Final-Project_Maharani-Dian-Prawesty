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
        JOIN tag ON tag.id = news.tag_id
        WHERE authors.id = news.author_id and categories.id = news.category_id
        and tag.id = news.tag_id and news.id = '$id';";
        $datas = $conn->query($sql);

        function upload(){
            $namaFile = $_FILES['foto']['name'];
            $ukuranFile = $_FILES['foto']['size'];
            $error = $_FILES['foto']['error'];
            $tmpName = $_FILES['foto']['tmp_name'];

            //cek apakah tdk ada gambar yg diupload
            if($error === 4){
                echo"<script>
                    alert('pilih gambar terlebih dahulu!');
                    </script>";
                    die();
            }

            //cek apakah yg diupload adlh gambar
            $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
            $ekstensiGambar = explode('.', $namaFile);
            $ekstensiGambar = strtolower(end($ekstensiGambar));
            if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
                echo "<script>
                        alert('Yang anda upload bukan Foto!');
                     </script>";
                    die();
            }

            //cek jika ukurannya terlalu besar
            if($ukuranFile > 2048000){
                echo "<script>
                    alert('Ukuran Foto terlalu besar!');
                    </script>";
                die();
            }

            //lolos pengecekan, foto siap diupload
            //generate nama baru
            $namaFileBaru = uniqid();
            $namaFileBaru .= '.';
            $namaFileBaru .= $ekstensiGambar;
            move_uploaded_file($tmpName, '../../assets/upload/' . $namaFileBaru);
            return $namaFileBaru;
        }
        while($data = mysqli_fetch_array($datas)){
            $title = $data['title'];
            $author_id = $data['author_id'];
            $name = $data['name'];
            $category_id = $data['category_id'];
            $category = $data['category'];
            $date = $data['date'];
            $foto = $data['foto'];
            $headline = $data['headline'];
            $content = $data['content'];
            $tag_id = $data['tag_id'];
            $name_tag = $data['name_tag'];
        }
        if(isset($_POST['submit'])){
            $title = $_POST['title'];
            $author_id = $_POST['author_id'];
            $category_id = $_POST['category_id'];
            $fotoLama  = $_POST['fotoLama'];
            $headline = $_POST['headline'];
            $content = $_POST['content'];
            $tag_id = $_POST['tag_id'];

            if($_FILES['foto']['error'] === 4){
                $foto = $fotoLama;
            }else{
                $foto = upload();
            }

            include '../../connectDB.php';
            $sql   = "UPDATE news SET
            title = '$title', 
            author_id = '$author_id',
            category_id = '$category_id',
            foto = '$foto',
            headline = '$headline',
            content = '$content',
            tag_id = '$tag_id' WHERE id = $id;";
            $datas = $conn->query($sql);

            if(mysqli_affected_rows($conn) > 0){
                header("Location:index.php");
            }else{
                $_SESSION['error'] = "Menambah data gagal!";
            }
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
                        <li class="breadcrumb-item active" aria-current="page">Edit Berita</li>
                    </ol>
                </nav>
                <h1 class="h2">Edit Berita</h1>
                <p>Anda sedang mengubah detail Berita dari <b><?php echo $name ?></b></p>

                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']."?id=".$id ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $data['id'];?>">
                            <input type="hidden" name="fotoLama" value="<?= $foto;?>">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Berita</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="title" required value="<?php echo $title ?>">
                            </div>
                            <div class="mb-3">
                                <label for="author_id" class="form-label">Author</label>
                                <select class="form-select" aria-label="Default select example" name="author_id">
                                    <?php
                                        echo "<option value=$author_id>$name</option>";
                                        $query = mysqli_query($conn, "SELECT * FROM authors") or die (mysqli_error($conn));
                                        while($data = mysqli_fetch_array($query)){
                                            echo "<option value=$data[id]> $data[name]</option>";
                                        }
                                    ?>
                                </select>                           
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori Berita</label>
                                <select class="form-select" aria-label="Default select example" name="category_id">
                                    <?php
                                        echo "<option value=$category_id>$category</option>";
                                        $query = mysqli_query($conn, "SELECT * FROM categories") or die (mysqli_error($conn));
                                        while($data = mysqli_fetch_array($query)){
                                            echo "<option value=$data[id]> $data[category]</option>";
                                        }
                                    ?>
                                </select>                           
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto">
                                <img class="img-newslates" src="../../assets/upload/<?php echo $foto ?>" id="foto" alt="">
                            </div>
                            <div class="mb-3">
                                <label for="headline" class="form-label">Headline</label>
                                <textarea type="text" class="form-control" id="headline" name="headline" placeholder="headline"><?php echo $headline ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Isi Berita</label>
                                <textarea type="text" class="form-control" id="content" name="content" placeholder="content"><?php echo $content ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tag_id" class="form-label">Tag</label>
                                <select class="form-select" aria-label="Default select example" name="tag_id">
                                    <?php
                                        echo "<option value=$tag_id>$name_tag</option>";
                                        $query = mysqli_query($conn, "SELECT * FROM tag") or die (mysqli_error($conn));
                                        while($data = mysqli_fetch_array($query)){
                                            echo "<option value=$data[id]> $data[name_tag]</option>";
                                        }
                                    ?>
                                </select>                           
                            </div>
                            <p style="color:red; font-size: 12px;"><?php if(isset($_SESSION['error'])){ echo($_SESSION['error']);} ?></p>
                            <button class="btn btn-primary my-3" type="submit" name="submit" style="color: white;">Save</button>
                        </form>
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
    <?php
        unset($_SESSION['error']);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css"></script>
    
</body>
</html>