<?php
include("db.php");
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture Store - Home</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Header and Slider */
        header {
            position: relative;
            width: 100%;
            height: 100vh; /* Full viewport height */
            overflow: hidden;
        }

        .slider-wrapper {
            width: 500%; /* Number of images * 100% */
            height: 100%;
            display: flex;
            animation: slideBackground 25s infinite; /* Total duration = 5 images * 5s */
        }

        .slider-wrapper div {
            width: 20%; /* 100% / number of images */
            height: 100%;
            background-size: cover;
            background-position: center;
        }

        @keyframes slideBackground {
            0% { transform: translateX(0); }
            20% { transform: translateX(0); }  /* Pause on the first image */
            25% { transform: translateX(-20%); }
            45% { transform: translateX(-20%); }  /* Pause on the second image */
            50% { transform: translateX(-40%); }
            70% { transform: translateX(-40%); }  /* Pause on the third image */
            75% { transform: translateX(-60%); }
            95% { transform: translateX(-60%); }  /* Pause on the fourth image */
            100% { transform: translateX(-80%); }  /* Pause on the fifth image */
        }

        .ei-title {
            position: absolute;
            bottom: 30px;
            left: 50px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            border-radius: 5px;
        }

        /* Product Grid */
        .sections_wraps {
            padding: 40px;
            text-align: center;
        }

        .sec_header h2 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }

        .sec_header .sub_title {
            font-size: 18px;
            color: #777;
        }

        .ch-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 30px;
        }

        .ch-item {
            width: 250px;
            height: 250px;
            margin: 15px;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .ch-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .ch-item:hover {
            transform: scale(1.05);
        }

        .ch-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 18px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .ch-grid {
                flex-direction: column;
                align-items: center;
            }

            .ch-item {
                width: 90%;
                height: 200px;
            }

            .ei-title {
                font-size: 18px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="slider-wrapper">
        <div style="background-image: url('furniture images/office_furniture.jpg');"></div>
        <div style="background-image: url('furniture images/outdoor_furniture.jpg');"></div>
        <div style="background-image: url('furniture images/kitchen_furniture.jpg');"></div>
        <div style="background-image: url('furniture images/icons/sofas.jpg');"></div>
        <div style="background-image: url('furniture images/banner3.jpg');"></div>
    </div>
    <div class="ei-title">Furniture Store</div>
</header>

<main>
    <section class="sections_wraps" id="sec_scnd">
        <div class="sec_header">
            <h2>TOP SELLING PRODUCTS OF OUR STORE</h2>
            <p class="sub_title">Choose the product as you like</p>
        </div>
        <ul class="ch-grid">
            <li><a href="single-product-detail.php">
                <div class="ch-item"><img src="furniture images/images (38).jpeg" alt="OUTDOOR FURNITURE">
                    <div class="ch-info"><h3>OUTDOOR FURNITURE</h3></div>
                </div>
            </a></li>
            <li><a href="single-product-detail.php">
                <div class="ch-item"><img src="furniture images/download (4).jpeg" alt="Queen Size Bed">
                    <div class="ch-info"><h3>Queen Size Bed</h3></div>
                </div>
            </a></li>
            <li><a href="single-product-detail.php">
                <div class="ch-item"><img src="furniture images/images (48).jpeg" alt="KITCHEN FURNITURE">
                    <div class="ch-info"><h3>KITCHEN FURNITURE</h3></div>
                </div>
            </a></li>
            <li><a href="single-product-detail.php">
                <div class="ch-item"><img src="furniture images/images (15).jpeg" alt="DINNER TABLE">
                    <div class="ch-info"><h3>DINNER TABLE</h3></div>
                </div>
            </a></li>
        </ul>
        <ul class="ch-grid">
            <li><a href="single-product-detail.php">
                <div class="ch-item"><img src="furniture images/download (13).jpeg" alt="OFFICE FURNITURE">
                    <div class="ch-info"><h3>OFFICE FURNITURE</h3></div>
                </div>
            </a></li>
            <li><a href="single-product-detail.php">
                <div class="ch-item"><img src="furniture images/images (23).jpeg" alt="Bed and Mattress">
                    <div class="ch-info"><h3>Bed and Mattress</h3></div>
                </div>
            </a></li>
            <li><a href="single-product-detail.php">
                <div class="ch-item"><img src="furniture images/img2.jpg" alt="INDOOR FURNITURE">
                    <div class="ch-info"><h3>Sofa</h3></div>
                </div>
            </a></li>
            <li><a href="single-product-detail.php">
                <div class="ch-item"><img src="furniture images/img18.jpg" alt="Sofa">
                    <div class="ch-info"><h3>INDOOR FURNITURE</h3></div>
                </div>
            </a></li>
        </ul>
    </section>
</main>

<?php include("footer.php"); ?>
</body>
</html>
