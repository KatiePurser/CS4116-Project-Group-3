<?php
session_start();

if (isset($_SESSION["user_id"])) {

    if ($_SESSION["user_type"] === "customer") {
        header("Location: /CS4116-Project-Group-3/the_artist_harbour/public/home_page.php");
    } elseif ($_SESSION["user_type"] === "business") {
        header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/business/profile.php");
    } elseif ($_SESSION["user_type"] === "admin") {
        header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/administration/admin_panel.php");
    }
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Artist Harbour</title>
    <link rel="stylesheet" type="text/css" href="../../public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100 poppins-regular">

<div class="container d-flex flex-column align-items-center justify-content-center">

    <?php include __DIR__ . '/../../templates/login_header.php'; ?>

    <?php if (!empty($_SESSION['error'])) {
        echo("<div class='row mb-2'><div class='alert alert-danger'><span><i class='bi bi-exclamation-triangle'></span></i> {$_SESSION['error']} </div><div class='col-12'></div></div>");
        unset($_SESSION['error']);
    } ?>

    <div class="row mb-2">
        <div class="col-12">
            <h1>Login</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="post" action="loginUser.php" class="w-100">
                <div class="mb-3">
                    <label for="login-email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" placeholder="Enter your Email Address" value="<?php echo $_SESSION['email_address'] ?? ''; ?>" required id="login-email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="login-password" class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Enter your Password" value="<?php echo $_SESSION['password'] ?? ''; ?>" required id="login-password" class="form-control">
                        <span class="input-group-text" style="cursor: pointer;"><i class="bi bi-eye-slash"></i></span>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <input type="submit" value="Login">
                    <p class="mt-3">Do not have an account? <a href="registration.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $_SESSION = []; ?>
<script src="togglePasswordVisibility.js"></script>
</body>
</html>

<style>
    a {
        color: #82689A;
    }
</style>