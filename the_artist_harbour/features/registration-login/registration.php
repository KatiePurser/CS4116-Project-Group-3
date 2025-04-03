<?php
session_start();

if (isset($_SESSION["user_id"])) {

    if ($_SESSION["user_type"] === "customer") {
        header("Location: /the_artist_harbour/public/home_page.php");
    } elseif ($_SESSION["user_type"] === "business") {
        header("Location: /the_artist_harbour/features/business/profile.php");
    } elseif ($_SESSION["user_type"] === "admin") {
        header("Location: #");
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
            echo ("<div class='row mb-2'><div class='alert alert-danger'><span><i class='bi bi-exclamation-triangle'></span></i> {$_SESSION['error']} </div><div class='col-12'></div></div>");
            unset($_SESSION['error']);
        } ?>
        <div class="row mb-2">
            <div class="col-12">
                <h1>Register</h1>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <ul class="nav nav-pills d-flex justify-content-center" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="register-customer-tab" data-bs-toggle="pill"
                            data-bs-target="#customer-registration-form" type="button" role="tab">Customer</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="register-business-tab" data-bs-toggle="pill"
                            data-bs-target="#business-registration-form" type="button" role="tab">Business</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="tab-content">
                    <div class="tab-pane show active" id="customer-registration-form" role="tabpanel">
                        <form method="post" action="registerUser.php" class="w-100">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer-email" class="form-label">Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" placeholder="Enter your Email Address"
                                            value="<?php echo $_SESSION['email'] ?? ''; ?>" required id="customer-email"
                                            class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="customer-first-name" class="form-label">First Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="first_name" placeholder="Enter your First Name"
                                            value="<?php echo $_SESSION['first_name'] ?? ''; ?>" required
                                            id="customer-first-name" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="customer-last-name" class="form-label">Last Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="last_name" placeholder="Enter your Last Name"
                                            value="<?php echo $_SESSION['last_name'] ?? ''; ?>" required
                                            id="customer-last-name" class="form-control">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer-password" class="form-label">Password <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="password" placeholder="Enter your Password"
                                                value="<?php echo $_SESSION['password'] ?? ''; ?>" required
                                                id="customer-password" class="form-control">
                                            <span class="input-group-text" style="cursor: pointer;"><i
                                                    class="bi bi-eye-slash"></i></span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="customer-confirm-password" class="form-label">Confirm Password <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="confirm_password"
                                                placeholder="Confirm your Password"
                                                value="<?php echo $_SESSION['confirm_password'] ?? ''; ?>" required
                                                id="customer-confirm-password" class="form-control">
                                            <span class="input-group-text" style="cursor: pointer;"><i
                                                    class="bi bi-eye-slash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="text-center mt-3">
                                <input type="hidden" name="user_type" value="customer">
                                <input type="submit" value="Register">
                                <p class="mt-3">Already have an account? <a href="login.php">Log in</a></p>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane" id="business-registration-form" role="tabpanel">

                        <form method="post" action="registerUser.php" class="w-100">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="business-email" class="form-label">Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" placeholder="Enter your Email Address" required
                                            id="business-email" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="business-first-name" class="form-label">First Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="first_name" placeholder="Enter your First Name"
                                            required id="business-first-name" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="business-last-name" class="form-label">Last Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="last_name" placeholder="Enter your Last Name" required
                                            id="business-last-name" class="form-control">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="business-name" class="form-label">Business Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="business_name" placeholder="Enter your Business Name"
                                            required id="business-name" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="business-password" class="form-label">Password <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="password" placeholder="Enter your Password"
                                                required id="business-password" class="form-control">
                                            <span class="input-group-text" style="cursor: pointer;"><i
                                                    class="bi bi-eye-slash"></i></span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="business-confirm-password" class="form-label">Confirm Password <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="confirm_password"
                                                placeholder="Confirm your Password" required
                                                id="business-confirm-password" class="form-control">
                                            <span class="input-group-text" style="cursor: pointer;"><i
                                                    class="bi bi-eye-slash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <input type="hidden" name="user_type" value="business">
                                <input type="submit" value="Register">
                                <p class="mt-3">Already have an account? <a href="login.php">Log in</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="togglePasswordVisibility.js"></script>
</body>

</html>

<style>
    a {
        color: #82689A;
    }

    .nav-pills .nav-link.active {
        background-color: #82689A;
        /*border-color: purple !important;*/
    }

    .nav-pills .nav-link {
        color: #82689A;
    }
</style>