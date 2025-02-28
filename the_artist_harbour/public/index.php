<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyApp</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">

    <style>
        /* Makes sure the content takes up full page of space. Without this footer is directly under content not forced to bottom */
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Pushes footer to the bottom of the page all page content must be labelled with this class */
        .content {
            flex: 1;
        }

        .footer {
            background-color: #82689A;
            padding: 15px;
            color: white;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div
        class="content container d-flex flex-column justify-content-center align-items-center text-center amarante-regular">
        <h1>Welcome to The Artist Harbour!</h1>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>

</html>