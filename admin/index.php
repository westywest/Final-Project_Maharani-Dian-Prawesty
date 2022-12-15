<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <style>
        @import url('https://fonts.cdnfonts.com/css/roboto');
        body{
            font-family: 'Roboto Medium', sans-serif;
            height: 100vh;
            width: 100%;
        }
        form{
            max-width: 455px;
        }
        .btn{
            background-color: #1f3072;
            color: white;
            border: 0px;
        }
        .btn:hover{
            background-color: #6EBF8B;
            border: 0px;
        }
        .a{
            color: #1f3072;
        }
        .a:hover{
            color: #6EBF8B;
        }
    </style>

</head>
<body class="d-grid align-content-center" style="background-color: #1f3072">
    <?php
        session_start(); //untuk menyimpan data saat login

        if(isset($_SESSION['status']) && $_SESSION['status'] === "login"){ //jika sudah pernah login maka diarahkan ke dashboard, dan proses dibawahnya tidak dijalankan
            header("location:/FinalProject/admin/dashboard.php");
            die();
        }
        include '../connectDB.php';

        if(isset($_POST['username']) && $_POST['password']){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM admins WHERE username='$username' and password='$password'";
            $data = $conn->query($sql);

            $check = mysqli_num_rows($data);

            if(isset($_POST['submit'])){
                if($check != 0){
                    $_SESSION['username'] = $username;
                    $_SESSION['status'] = "login";
                    header("location:/FinalProject/admin/dashboard.php");
                    die();
                }else{
                    $_SESSION['error'] = "Gagal login, silahkan cek kembali username dan password anda!";
                }
            }
        }
    ?>
    <form class="border rounded mx-auto w-100 p-4 rounded-3" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="background-color: #e9e9dd">
        <h2 class="fw-bold text-center">LOGIN ADMIN</h2>
        <div class="text-center">
            <img src="../assets/img/LOGOLGN.png" class="img-fluid profile-image-pic my-3" width="200px" alt="profile">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" aria_describribedby="emailHelp" require placeholder="Username">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" aria_describribedby="emailHelp" placeholder="*********" require>
        </div>
        <p style="color: red; font-size: 12px;"><?php if(isset($_SESSION['error'])){ echo($_SESSION['error']);} ?>
        </p>
        <button type="submit" name="submit" class="btn btn-color px-5 mb-5 w-100">Login</button>
        <div id="emailHelp" class="form-text text-center mb-4 text-dark">
            Not Registered?
                <a href="#" class="a fw-bold" style="text-decoration:none;">Create an Account</a>
                <br><br>
                <a href="/FinalProject/index.php" class="a fw-bold" style="text-decoration:none;">Back to Home</a>
        </div>
    </form>

    <?php
        unset($_SESSION['error']);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css"></script>
    
</body>
</html>