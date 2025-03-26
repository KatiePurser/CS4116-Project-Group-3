<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Artist Harbour</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3eef5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            max-width: 1200px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .profile {
            display: flex;
            align-items: center;
            background-color: #c5a6d4;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .profile img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            margin-right: 20px;
        }
        .services, .reviews {
            background-color: #e6dfe5;
            padding: 20px;
            border-radius: 10px;
        }
        .services h3, .reviews h3 {
            margin-bottom: 15px;
        }
        .service-card, .review {
            display: flex;
            align-items: center;
            background-color: #ddd2f1;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            justify-content: space-between;
        }
        .service-card img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            margin-right: 15px;
        }
        .service-card div {
            flex-grow: 1;
        }
        .service-card span {
            font-weight: bold;
            color: #4a2c5d;
        }
        .service-card button {
            background-color: #82689A;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .service-card button:hover {
            background-color: #70578c;
        }
        .reviews .review {
            flex-direction: column;
            align-items: flex-start;
        }
        .review h4 {
            margin: 0;
            font-size: 1.1em;
            color: #4a2c5d;
        }
        .review p {
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="container">
       
        <section class="profile">
            <img src="artist.jpg" alt="Sarah Crane">
            <div>
                <h2>SARAH CRANE CROCHET</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
            </div>
        </section>
        <section class="services">
            <h3>Services</h3>
            <div class="service-card">
                <img src="amigurumi.jpg" alt="Amigurumi Masterclass">
                <div>
                    <h4>Amigurumi Masterclass</h4>
                    <p>Lorem ipsum dolor sit amet...</p>
                    <span>€25-€40</span>
                </div>
                <button>Request</button>
            </div>
            <div class="service-card">
                <img src="crochet.jpg" alt="Crochet Wearables Masterclass">
                <div>
                    <h4>Crochet Wearables Masterclass</h4>
                    <p>Lorem ipsum dolor sit amet...</p>
                    <span>€80</span>
                </div>
                <button>Request</button>
            </div>
        </section>
        <section class="reviews">
            <h3>Recent Reviews</h3>
            <div class="review">
                <h4>Jane Doe</h4>
                <p>Lorem ipsum dolor sit amet...</p>
            </div>
            <div class="review">
                <h4>Conor Ryan</h4>
                <p>Odio phasellus eget penatibus...</p>
            </div>
            <div class="review">
                <h4>Sohaila Awaga</h4>
                <p>Cura turpis habitant ornare...</p>
            </div>
        </section>
    </div>
    </div>
</body>
</html>
