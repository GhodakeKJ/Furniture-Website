<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Furniture House</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        header {
            background-image: url('images/banner_about.jpg');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        header h1 {
            font-size: 50px;
            text-transform: uppercase;
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }

        .main-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }

        .about-section {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-bottom: 30px;
            transition: all 0.3s ease-in-out;
        }

        .about-section:hover {
            transform: scale(1.05);
        }

        .about-section img {
            width: 45%;
            border-radius: 10px;
        }

        .about-content {
            max-width: 50%;
        }

        .about-content h2 {
            font-size: 36px;
            color: #ff9900;
            margin-bottom: 20px;
        }

        .about-content p {
            font-size: 18px;
            color: #666;
            line-height: 1.8;
        }

        .about-content p span {
            color: #ff9900;
            font-weight: bold;
        }

        .mission {
            background: #ff9900;
            color: white;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .mission h3 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .mission p {
            font-size: 18px;
            max-width: 900px;
            margin: 0 auto;
            line-height: 1.8;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-top: 30px;
        }

        footer p {
            font-size: 14px;
        }

        /* Button to contact */
        .contact-button {
            display: inline-block;
            background-color: #333;
            color: white;
            padding: 12px 25px;
            margin-top: 20px;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .contact-button:hover {
            background-color: #ff9900;
            color: #fff;
        }

        /* Responsive Design */
        @media(max-width: 768px) {
            .about-section {
                flex-direction: column;
                text-align: center;
            }

            .about-section img {
                width: 100%;
                margin-bottom: 20px;
            }

            .about-content {
                max-width: 100%;
            }

            .mission {
                padding: 30px;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>About Furniture House</h1>
    </header>

    <div class="main-container">
        <div class="about-section">
            <img src="furniture images\images (35).jpeg" alt="About Us Image">
            <div class="about-content">
                <h2>Who We Are</h2>
                <p>
                    Welcome to <span>Furniture House</span>, your trusted partner for modern, elegant, and high-quality furniture. We’re passionate about turning your house into a home, offering the finest collection of furniture that brings beauty and comfort together.
                </p>
                <p>
                    Since <span>2005</span>, we have been serving our customers with exceptional craftsmanship and innovative designs. From small apartments to large homes, we have furniture to suit every space and style.
                </p>
                <a href="contact.php" class="contact-button">Contact Us</a>
            </div>
        </div>

        <div class="mission">
            <h3>Our Mission</h3>
            <p>
                Our mission is to create stylish yet functional furniture that caters to every lifestyle. We believe that furniture is not just an item, but an expression of your style, personality, and comfort.
            </p>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Furniture House. All rights reserved.</p>
    </footer>

</body>
</html>
