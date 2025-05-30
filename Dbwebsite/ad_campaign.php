<?php
// Include the database connection file
include 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $campaign_name = $_POST["campaign_name"];
    $campaign_budget = $_POST["campaign_budget"];
    $email = $_POST["email"];
    $campaign_description = $_POST["campaign_description"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    // Prepare and bind SQL statement
    $sql = "INSERT INTO Campaigns (campaign_name, campaign_budget, email, campaign_description, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssss", $campaign_name, $campaign_budget, $email, $campaign_description, $start_date, $end_date);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "New record created successfully";
        // Redirect to another page or display a success message
        header("Location: advertisement.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DigiMarketing - We're available for marketing</title>

  <script>
    function scrollToContact() {
      // Scroll to the "Let's Contact With Us" section
      document.getElementById('contact').scrollIntoView({ behavior: 'smooth' });
    }
  </script>
  
  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@500;700&family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet">
</head>

<body id="top">

  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <a href="#" class="logo">DigiMarketing</a>

      <nav class="navbar container" data-navbar>
        <ul class="navbar-list">

          <li>
            <a href="index.php" class="navbar-link" data-nav-link>Home</a>
          </li>

          <li>
            <a href="index.php#service" class="navbar-link" data-nav-link>Services</a>
          </li>

          <li>
            <a href="index.php#project" class="navbar-link" data-nav-link>Project</a>
          </li>

          <li>
            <a href="index.php#about" class="navbar-link" data-nav-link>About Us</a>
          </li>

          <li>
            <a href="index.php#blog" class="navbar-link" data-nav-link>Blog</a>
          </li>

          <li>
            <a href="index.php#contact" class="navbar-link" data-nav-link>Contact Us</a>
          </li>

          <li>
            <a href="#" class="btn btn-primary" onclick="scrollToContact()">Get Started</a>

          </li>

        </ul>
      </nav>

      <button class="nav-toggle-btn" aria-label="Toggle menu" data-nav-toggler>
        <ion-icon name="menu-outline" class="open"></ion-icon>
        <ion-icon name="close-outline" class="close"></ion-icon>
      </button>

    </div>
  </header>


<!-- 
        - #CLIENT
      -->

      <section class="section contact" id="contact" aria-label="contact">
        <div class="container">

          <h2 class="h2 section-title">Let's Contact With Us</h2>

          <p class="section-text">
            Have questions or want to discuss your project? Reach out to us today, and let's start the conversation.
          </p>

          <form action="" method="POST" class="contact-form">
    <div class="input-wrapper">
        <input type="text" name="campaign_name" aria-label="Campaign Name" placeholder="Campaign Name*" required class="input-field">
        <input type="number" name="campaign_budget" aria-label="Campaign Budget" placeholder="Campaign Budget*" required class="input-field">
    </div>

    <div class="input-wrapper">
        <input type="email" name="email" aria-label="Email" placeholder="Email Address*" required class="input-field">
        <input type="date" name="start_date" aria-label="Start Date" placeholder="Start Date*" required class="input-field">
        <input type="date" name="end_date" aria-label="End Date" placeholder="End Date*" required class="input-field">
    </div>

    <textarea name="campaign_description" aria-label="Campaign Description" placeholder="Description of the campaign...*" required class="input-field"></textarea>

    <button type="submit" class="btn btn-primary">Confirm</button>
</form>


          <!-- <form action="advertisement.php" class="contact-form" method="POST">

            <div class="input-wrapper">
              <input type="text" name="client_budget" aria-label="budget" placeholder="Client budget for campaign*" required class="input-field">
              <input type="text" name="campaign_name" aria-label="name" placeholder="Campaign name*" required class="input-field">
            </div>

            <div class="input-wrapper">
              <input type="email" name="email_address" aria-label="email" placeholder="Email address*" required
                class="input-field">

              <input type="date" name="start_date" aria-label="contract" placeholder="Start date*" required class="input-field">
              <input type="date" name="end_date" aria-label="contract" placeholder="End date*" required class="input-field">
            </div>

            <textarea name="campaign_description" aria-label="message" placeholder="Description of the campaign...*" required
              class="input-field"></textarea> -->

              <!-- Inside the form element -->
            <!-- <div class="input-wrapper">
                <input type="number" name="client_budget" aria-label="client budget" placeholder="Client Budget for Campaign*" required class="input-field">
            </div>
            <div class="input-wrapper">
                <input type="text" name="campaign_name" aria-label="campaign name" placeholder="Campaign Name*" required class="input-field">
            </div>
            <div class="input-wrapper">
                <input type="date" name="start_date" aria-label="start date" placeholder="Start Date*" required class="input-field">
                <input type="date" name="end_date" aria-label="end date" placeholder="End Date*" required class="input-field">
            </div>
            <textarea name="campaign_description" aria-label="campaign description" placeholder="Description of the Campaign*" required class="input-field"></textarea> -->
            
            <!-- <button type="submit" class="btn btn-primary">Confirm</button>

          </form> -->

          <ul class="contact-list">

            <li class="contact-item">
              <div class="contact-card">

                <div class="card-icon">
                  <ion-icon name="mail-outline" aria-hidden="true"></ion-icon>
                </div>

                <div class="card-content">

                  <h3 class="h3 card-title">Mail Here</h3>

                  <a href="mailto:hello@luaz.com" class="card-link">digiMarketing@gmail.com</a>
                  <a href="mailto:info@luaz.com" class="card-link">Vit@gmail.com</a>

                </div>

              </div>
            </li>

            <li class="contact-item">
              <div class="contact-card">

                <div class="card-icon">
                  <ion-icon name="map-outline" aria-hidden="true"></ion-icon>
                </div>

                <div class="card-content">

                  <h3 class="h3 card-title">Visit Here</h3>

                  <address class="card-address">
                    Mahesh Society, Bibwewadi,<br>
                    Pune, 411037, Maharashtra
                  </address>

                </div>

              </div>
            </li>

            <li class="contact-item">
              <div class="contact-card">

                <div class="card-icon">
                  <ion-icon name="headset-outline" aria-hidden="true"></ion-icon>
                </div>

                <div class="card-content">

                  <h3 class="h3 card-title">Call Here</h3>

                  <a href="tel:+1234567890" class="card-link">+9174567890</a>
                  <a href="tel:+2414524526" class="card-link">+9114524526</a>

                </div>

              </div>
            </li>

          </ul>

        </div>
      </section>

    </article>
  </main>





  <!-- 
    - #FOOTER
  -->

  <!-- <footer class="footer">
    <div class="container">

      <p class="copyright">
        &copy; 2022 All Rights Reserved by <a href="#" class="copyright-link">codewithsadee</a>
      </p>

    </div>
  </footer>  -->





  <!-- 
    - #BACK TO TOP
  -->

  <a href="#top" aria-label="back to top" data-back-top-btn class="back-top-btn">
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js" defer></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
