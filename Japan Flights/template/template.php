<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Defining the character encoding to be used, and setting a viewport for responsive display -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Calling the favicon, fonts ant CSS sheets to be used -->
	<link rel="icon" href="assets/img/favicon/favicon.ico">
	<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Roboto:wght@500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/normalize.css">
	<link rel="stylesheet" href="assets/css/style.css">
	
	<!-- Displaying each view's own title -->
	<title><?= $title ?></title>
</head>

<body>
    <!-- Footer -->
	<header>
		<div class="container">

			<nav>
				<ul>
				    <!-- Links to display when no user is connected -->
                    <?php if(!$session::online()) : ?>
					<li><a href="index.php?p=register" <?= $https::active('register') ?>>Registration</a></li>
					<li><a href="index.php?p=login" <?= $https::active('login') ?>>Log in</a></li>
                    <?php else : ?>
                    <!-- Links to display when a user is connected -->
                    <?php if(!$session::admin()) : ?>
                    <li><a href="index.php?p=account" <?= $https::active('account') ?>><i class="fas fa-user-alt"></i>My account</a></li>
                    <li class="review-link"><a href="index.php?p=review">Give a review</a></li>
                    <?php else : ?>
                    <!-- Links to display when an admin is connected -->
                    <li><a href="index.php?p=dashboard" <?= $https::active('dashboard') ?>><i class="fas fa-user-lock"></i>Dashboard</a></li>
                    <?php endif; ?>
                    <!-- Link to display when either a user or an admin is connected -->
					<li><a href="index.php?p=logout" <?= $https::active('logout') ?>>Log out</a></li>
					<?php endif; ?>
				</ul>
			</nav>
            
            <div class="logo">
                <a href="index.php?p=home" class="logo"><img src="assets/img/Logo.png" alt="Logo Japan Flights"></a>
                <p><strong>Memorable flights to the Rising Sun</strong></p>
            </div>

            <nav>
				<ul>
					<li><a href="index.php?p=destinations" <?= $https::active('destinations') ?>>Destinations</a></li>
					<!-- Hiding the link to the contact form, if an admin is connected -->
					<?php if(!$session::online() || $session::online() && !$session::admin()) : ?>
					<li><a href="index.php?p=contact" <?= $https::active('contact') ?>>Contact us</a></li>
					<?php endif; ?>
				</ul>
			</nav>
			
        </div>
	</header>

    <!-- Main content -->
    <main>
        <!-- Div to save a confirmed order's lines, via JavaScript -->
        <div class="info"></div>
        
        <!-- Hiding the cart's icon, if an admin is connected -->
        <?php if(!$session::online() || $session::online()&& !$session::admin()) : ?>
        <div class="shop">
            <a href="index.php?p=cart" title="My cart"><i class="fas fa-cart-arrow-down"></i>&#36;<span>00.00</span></a>
        </div>
        <?php endif; ?>
        
        <!-- Requiring the views, so as to display their own main content -->
        <?php require 'views/'.$path ?>
    </main>

    <!-- Footer -->
	<footer>
		<div class="container">

            <nav>
                <ul>
                    <li><a href="index.php?p=privacyPolicy" <?= $https::active('privacyPolicy') ?>>Privacy Policy</a></li>
                    <li><a href="index.php?p=cookies" <?= $https::active('cookies') ?>>Cookies Policy</a></li>
                    <li><a href="index.php?p=salesConditions" <?= $https::active('salesConditions') ?>>Sales Terms and Conditions</a></li>
                    <li><a href="index.php?p=disclaimer" <?= $https::active('disclaimer') ?>>Disclaimer</a></li>
                </ul>
            </nav>

            <address>
                <p>21 Lincoln Avenue</p>
                <p>Washington,</p>
                <p>DC 20004-9198</p>
                <p>+1-202 515 1561</p>
            </address>

            <nav>
                <ul>
                    <li><a href="https://www.youtube.com"><i class="fab fa-youtube"></i></a>
                    <li><a href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
                    <li><a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
                    <li><a href="https://www.whatsapp.com"><i class="fab fa-whatsapp"></i></a>
                </ul>
            </nav>

        </div>
	</footer>
	
	<!-- Calling the JavasScript files to be used -->
	<script src="https://js.stripe.com/v3/"></script>
	<script src="assets/js/function.js"></script>
	<script type="module" src="assets/js/main.js"></script>
</body>

</html>