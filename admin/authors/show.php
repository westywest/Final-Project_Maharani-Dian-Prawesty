<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="../../assets/style_admin.css">
    <title>Author | Admin Panel</title>
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
                        <a href="#" class="nav-link active">
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
                        <a href="/FinalProject/admin/news/index.php" class="nav-link link-dark">
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
                        <li class="breadcrumb-item"><a href="index.php">Daftar Author</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Author</li>
                    </ol>
                </nav>
                <h1 class="h2">Detail Author</h1>
                <p>Anda sedang melihat detail author dari <b><?php echo $name ?></b>.</p>

                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <img class="img-author" src="../../assets/upload/<?php echo $foto ?>" id="foto" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" placeholder="Nama" required value="<?php echo $name ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="jk" class="form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="jk" placeholder="jk" required value="<?php echo $jk ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" placeholder="name@example.com" required value="<?php echo $phone ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Email" required value="<?php echo $email ?>" disabled>
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