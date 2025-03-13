<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyApp</title>

    <link rel="stylesheet" href="/public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include __DIR__ . '/../../templates/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 px-0">
                <?php include __DIR__ . '/../../templates/sidebar.php'; ?>
            </div>

            <div class="col-md-3 border-end">
                <h2>Inbox</h2>
                <ul class="list-group">
                    <li class="list-group-item">Message 1</li>
                    <li class="list-group-item">Message 2</li>
                    <li class="list-group-item">Message 3</li>
                    <li class="list-group-item">Message 4</li>
                </ul>
            </div>

            <div class="col-md-7">
                <h2>Chat</h2>
                <div class="chat-box border p-3 mb-3" style="height: 400px; overflow-y: scroll;">
                    <div class="message mb-2">
                        <strong>User 1:</strong> Hello!
                    </div>
                    <div class="message mb-2">
                        <strong>User 2:</strong> Hi!
                    </div>
                    <!-- Add script to retrieve messages from the db -->
                </div>
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Type a message">
                        <button class="btn btn-primary" type="button">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>