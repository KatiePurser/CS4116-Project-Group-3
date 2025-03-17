<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyApp</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        div {
            padding: 0 !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php include __DIR__ . '/templates/header.php'; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-1 navbar-left">
                <?php include __DIR__ . '/templates/sidebar.php'; ?>
            </div>

            <!-- Main Content -->
            <div class="col-11">
                <h1>CONTENT</h1>
            </div>
        </div>

    </div>
</body>

</html>