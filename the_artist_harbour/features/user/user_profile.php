<?php
session_start();
// Include the necessary files (for database connection, image handling, etc.)
include_once __DIR__ . '/../../utilities/databaseHandler.php';
include_once __DIR__ . '/../../utilities/imageHandler.php';  // Include the ImageHandler class

// Initialise error/success messages array
$messages = [];

if (!isset($_SESSION['user_id'])) {
    header("Location: /CS4116-Project-Group-3/the_artist_harbour/features/registration-login/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch user data from the database
$query = "SELECT * FROM users WHERE id = $user_id";
$userData = DatabaseHandler::make_select_query($query);

// Check if user data exists before using it
if ($userData && count($userData) > 0) {
    $first_name = $userData[0]['first_name'];
    $last_name = $userData[0]['last_name'];
    $email = $userData[0]['email'];
    $profile_picture = $userData[0]['profile_picture'];
    $user_type = $userData[0]['user_type'];
} else {
    // Default data in case the query fails or no user data is found
    $first_name = "John";
    $last_name = "Doe";
    $email = "johndoe@example.com";
    $profile_picture = "#";
    $user_type = "customer";
}


// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data for user details
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])) {
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        // Check if any field is empty
        if (empty($first_name) || empty($last_name) || empty($email)) {
            $messages[] = "All fields are required!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Validate email format
            $messages[] = "Please enter a valid email address!";
        } else {
            // Create update query for user details
            $query = sprintf(
                "UPDATE users SET first_name='%s', last_name='%s', email='%s' WHERE id='%d'",
                $first_name,
                $last_name,
                $email,
                $user_id
            );
            if (DatabaseHandler::make_modify_query($query) === null) {
                $messages[] = "Failed to update user details. Please try again.";
            }
        }
    }

    // Handle updating password
    if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
        $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);

        // Check if passwords match
        if (empty($new_password) || empty($confirm_password)) {
            $messages[] = "Password fields cannot be empty!";
        } elseif ($new_password !== $confirm_password) {
            $messages[] = "Passwords do not match!";
        } else {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Create update query for password
            $query = sprintf(
                "UPDATE users SET password='%s' WHERE id='%d'",
                $hashed_password,
                $user_id
            );
            if (DatabaseHandler::make_modify_query($query) === null) {
                $messages[] = "Failed to update password. Please try again.";
            }
        }
    }

    // Handle profile picture upload
    if (isset($_FILES['profile_picture'])) {
        $uploadMessage = ImageHandler::uploadAndStoreImage('profile_picture', 'users', 'profile_picture', 'id', $user_id);
        $messages[] = $uploadMessage;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #fff;
        }
        .profile-container {
            background-color: #e6dfe5;
            padding: 20px;
        }
        .card {
            background-color: #ddd2f1;
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #82689A;
            border-color: #9074a8;
        }
        .btn-secondary {
            background-color: #ac8ebf;
            border-color: #ac8ebf;
        }
        .sidebar-container {
            background-color: #9074a8;
            min-height: 100vh;
        }
        .subheader {
            background-color: #ddd2f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            text-align: center;
            border-bottom: 1px solid #49375a;
        }
        .subheader-title {
            padding: 10px;
            font-weight: bold;
            font-size: 1.5rem;
            color: #49375a;
        }
        .sub-sidebar {
            background-color: #ddd2f1; 
            min-height: calc(100vh - 56px - 53px);
            padding: 10px;
        }

        div {
            padding: 0 !important;
        }
        .alert {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-12">
                <?php include __DIR__ . '/../../templates/header.php'; ?>
            </div>
            <div class="col-12 subheader">
                <h>Profile</h>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-1">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>
            
            <!-- Sub-sidebar with user info -->
            <div class="col-2 sub-sidebar">
                <div class="text-center">
                <?php if ($profile_picture): ?>
                    <img src="get_image.php?id=<?= $user_id ?>" class="img-fluid rounded-circle" width="100" height="100">
                <?php else: ?>
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto" style="width:80px; height:80px;">
                        <i class="bi bi-person fs-1"></i>
                    </div>
                <?php endif; ?>

<h4 class="mt-2"><?php echo htmlspecialchars($first_name . " " . $last_name); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($email); ?></p>
                </div>
            </div>
        
            <!-- Main content area -->
            <div class="col-9 p-4">
                <!-- Display error/success messages -->
                <?php if (!empty($messages)): ?>
                    <div class="alert <?= (strpos($messages[0], 'success') !== false) ? 'alert-success' : 'alert-danger' ?>">
                        <ul>
                            <?php foreach ($messages as $message): ?>
                                <li><?php echo htmlspecialchars($message); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- User Details Card -->
                <div class="card p-3 mb-3">
                    <h5>User Details</h5>
                    <form method="POST" action="user_profile.php">
                        <input type="text" class="form-control mb-2" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" placeholder="First Name">
                        <input type="text" class="form-control mb-2" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" placeholder="Last Name">
                        <input type="email" class="form-control mb-2" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Email">
                        <button class="btn btn-secondary" type="submit">Update User Details</button>
                    </form>
                </div>

                <!-- Change Password Card -->
                <div class="card p-3 mb-3">
                    <h5>Change Password</h5>
                    <form method="POST" action="user_profile.php">
                        <input type="password" class="form-control mb-2" name="new_password" placeholder="New Password" required>
                        <input type="password" class="form-control mb-2" name="confirm_password" placeholder="Confirm Password" required>
                        <button class="btn btn-secondary" type="submit">Update Password</button>
                    </form>
                </div>

                <div class="card p-3 mb-3">
                    <h5>Upload Profile Picture</h5>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="file" class="form-control mb-2" name="profile_picture" accept="image/*">
                        <button type="submit" class="btn btn-secondary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
