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
            } else {
                $messages[] = "User details updated successfully!";
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
            } else {
                $messages[] = "Password updated successfully!";
            }
        }
    }

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadMessage = ImageHandler::uploadAndStoreImage('profile_picture', 'users', 'profile_picture', 'id', $user_id);
        $messages[] = $uploadMessage;
        // Refresh the page to show the new profile picture
        header("Location: user_profile.php");
        exit();
    }
    
    // Handle profile picture deletion
    if (isset($_POST['delete_profile_picture'])) {
        $query = "UPDATE users SET profile_picture = NULL WHERE id = $user_id";
        if (DatabaseHandler::make_modify_query($query) === null) {
            $messages[] = "Failed to delete profile picture. Please try again.";
        } else {
            $messages[] = "Profile picture deleted successfully!";
            $profile_picture = null;
        }
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
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
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
            background-color: #E2D4F0; 
            min-height: calc(100vh - 73.6px);
            padding: 10px;
            border-right: #B3AABA 2px solid;
            display: flex;
            flex-direction: column;
        }
        .profile-system-container {
            display: flex;
            flex-grow: 1;
            height: calc(100vh - 73.6px);
        }
        .profile-content-container {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 73.6px);
            overflow: auto;
        }
        .profile-title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #E2D4F0;
            border-bottom: #B3AABA 2px solid;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .profile-title {
            font-weight: bold;
            font-size: 1.5rem;
            color: #49375a;
            margin: 20px;
        }
        .content-padding {
            padding: 20px !important; /* Add padding to the content container only */
        }
        .input-group-text {
            background-color: #ac8ebf;
            border-color: #ac8ebf;
            color: white;
            cursor: pointer;
        }
        .image-preview {
            max-width: 150px;
            max-height: 150px;
            margin-top: 10px;
            border-radius: 5px;
            display: none;
        }
        .profile-picture-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .profile-picture-container {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            border: 3px solid #9074a8;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            background-color: #f8f9fa;
        }
        .profile-picture-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-picture-icon {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ac8ebf;
        }
        .user-info-container {
            text-align: center;
            padding: 20px;
            flex-grow: 1;
            overflow-y: auto;
            margin-top: 20px;
        }
        .user-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #49375a;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .user-email {
            color: #6c757d;
            font-size: 0.9rem;
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
        </div>
        
        <div class="row g-0 flex-grow-1 profile-system-container">
            <div class="col-md-1 d-none d-md-block">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>
            
            <!-- Sub-sidebar with user info -->
            <div class="col-4 col-md-2 sub-sidebar">
                <div class="profile-title-container">
                    <h5 class="profile-title">User Info</h5>
                </div>
                <div class="user-info-container">
                    <div class="profile-picture-container">
                        <?php if ($profile_picture): ?>
                            <img src="get_image.php?id=<?= $user_id ?>" alt="Profile Picture">
                        <?php else: ?>
                            <div class="profile-picture-icon text-white">
                                <i class="bi bi-person-fill" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <h4 class="user-name"><?php echo htmlspecialchars($first_name . " " . $last_name); ?></h4>
                    <p class="user-email"><?php echo htmlspecialchars($email); ?></p>
                </div>
            </div>
        
            <!-- Main content area -->
            <div class="col-8 col-md-9 profile-content-container">
                <div class="profile-title-container">
                    <h5 class="profile-title">Profile Settings</h5>
                </div>
                
                <div class="content-padding">
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
                            <div class="input-group mb-2">
                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required>
                                <span class="input-group-text" onclick="togglePasswordVisibility('new_password')">
                                    <i class="bi bi-eye-slash" id="new_password_toggle"></i>
                                </span>
                            </div>
                            <div class="input-group mb-2">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                <span class="input-group-text" onclick="togglePasswordVisibility('confirm_password')">
                                    <i class="bi bi-eye-slash" id="confirm_password_toggle"></i>
                                </span>
                            </div>
                            <button class="btn btn-secondary" type="submit">Update Password</button>
                        </form>
                    </div>

                    <!-- Profile Picture Card -->
                    <div class="card p-3 mb-3">
                        <h5>Profile Picture</h5>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-2">
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" onchange="previewImage()">
                                <img id="image_preview" class
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" onchange="previewImage()">
                                <img id="image_preview" class="image-preview" src="#" alt="Image Preview">
                            </div>
                            <div class="profile-picture-actions">
                                <button type="submit" class="btn btn-secondary">Upload Picture</button>
                                <?php if ($profile_picture): ?>
                                    <button type="submit" name="delete_profile_picture" class="btn btn-danger">Delete Picture</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(inputId + '_toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        }

        // Preview image before upload
        function previewImage() {
            const fileInput = document.getElementById('profile_picture');
            const imagePreview = document.getElementById('image_preview');
            
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                imagePreview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
