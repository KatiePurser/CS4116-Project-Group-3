<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyApp</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        div {
            padding: 0 !important;
        }

        .request-title-container {
            background-color: #E2D4F0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 93.82px;
            border-bottom: #B3AABA 2px solid;
        }

        .request-title-container p {
            font-size: 1.5rem;
            color: #49375a;
            font-weight: bold;
            margin: 0;
            padding: 0;
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

        <div class="row g-0">
            <div class="col-2 col-md-1">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>

            <div class="col-10 col-md-11 request-title-container">
                <p>Service Requests</p>
            </div>

        </div>
    </div>
</body>

</html>