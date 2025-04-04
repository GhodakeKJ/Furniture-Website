<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer Section</title>
  <style>
    /* Footer Styles */
    footer {
      background-color: #333; /* Dark background for the footer */
      color: white; /* White text color */
      padding: 40px 0;
      border-top: 1px solid #e0e0e0; /* Light border at the top for separation */
    }

    .footer_wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .footer_inner_wrap {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .footer_sections {
      width: 30%; /* Adjust the width as needed */
      margin-bottom: 20px;
    }

    .footer_sections h2 {
      font-size: 1.5em;
      margin-bottom: 15px;
      border-bottom: 2px solid #fff; /* White underline for section headers */
      padding-bottom: 10px;
      color: #f0f0f0;
    }

    .footer_content p {
      font-size: 0.9em;
      line-height: 1.6;
    }

    .footer_social_links {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
    }

    .footer_social_links li {
      margin-right: 15px;
    }

    .footer_social_links li a img {
      width: 30px;
      height: 30px;
      transition: transform 0.3s ease; /* Smooth hover transition for icons */
    }

    .footer_social_links li a img:hover {
      transform: scale(1.1); /* Slight zoom on hover */
    }

    .go_top {
      text-align: center;
      margin-top: 30px;
    }

    .go_top a img {
      width: 40px;
      height: 40px;
      transition: transform 0.3s ease;
    }

    .go_top a img:hover {
      transform: translateY(-10px); /* Lift icon up on hover */
    }

    .copyright_link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.9em;
      color: #aaa; /* Light gray text for copyright */
    }

    footer a {
      color: #f0f0f0; /* Light text for links */
      text-decoration: none;
    }

    footer a:hover {
      color: #ddd; /* Slightly lighter on hover */
    }
  </style>
</head>
<body>

  <!-- Footer of site -->
  <footer>
    <div class="footer_wrap">
      <div class="footer_inner_wrap">
        <div class="footer_sections first_sec">
          <div class="heading_footer">
            <h2>About Us</h2>             
          </div>
          <div class="footer_content">
            <div class="footer_logo_text">
              <p>Discover the latest Furniture in the town. Furniture that will make your home excellent and attractive.</p>
            </div>
          </div>
        </div>  
        <div class="footer_sections scnd_sec">
          <div class="heading_footer">
            <h2>Contact Us</h2>             
          </div>
          <div class="footer_logo_text">
            <p>
              <b>Furniture House</b><br>
              121, Brunel Road<br>
              L6Y 4K2, Brampton<br>
            </p>
          </div>
        </div>  
        <div class="footer_sections thrd_sec">
          <div class="heading_footer">
            <h2>Social Links</h2>             
          </div>
          <div class="footer_content">
            <ul class="footer_social_links">
              <li>
                <a href="https://www.facebook.com/" target="_blank"><img src="furniture images\social_icons\facebook-f-icon-reflection-vector-logo.png" alt="Facebook"></a>
              </li>
              <li>
                <a href="https://www.instagram.com/" target="_blank"><img src="furniture images\social_icons\insta.png" alt="Instagram"></a>
              </li>
              <li>
                <a href="https://www.youtube.com/" target="_blank"><img src="furniture images\social_icons\youtube.png" alt="YouTube"></a>
              </li>
              <li>
                <a href="https://twitter.com/" target="_blank"><img src="furniture images\social_icons\twitter.png" alt="Twitter"></a>
              </li>
              <li>
                <a href="https://www.snapchat.com/" target="_blank"><img src="furniture images\social_icons\snapchat.png" alt="Snapchat"></a>
              </li>
            </ul>
          </div>
        </div>          
      </div>
      
      <div class="go_top">
        <a id="go_to_top" href="javascript:void(0);"><img src="furniture images\social_icons\top.png" alt="Go to Top"></a>
      </div>
      <div class="copyright_link">
        <span>&copy; 2025-2026 Furniture House</span>
  </div>
    </div>
  </footer>
  
</body>
</html>
