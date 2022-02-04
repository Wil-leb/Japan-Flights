<head>
	<meta name="description" content="Log into your account to Japan Flights!">
</head>
    
<section class="container">
    <h1>Login page</h1>
    
    <!-- Paragraphs to display as long as the form is not submitted -->
    <?php if(!$_POST) : ?>
    <p class="center">You can log in here, if you already have an account.</p>
    <p class="mandatory">All the fields are mandatory.</p>
    <?php endif; ?>
    
    <!-- Displaying error messages, if the form was submitted without all the requirements -->
    <?php if(empty($messages['success'])) : ?>
    <?php if(!empty($messages['errors'])) { ?>
    <ul class="error">
        <?php foreach($messages['errors'] as $error): ?>    
        <li><?= $error ?></li>
        <?php endforeach ?>    
    </ul>
    <?php } ?>

    <!-- Login form -->
    <form action="index.php?p=login" method="post">
        <div>
            <label for="login">Enter your login:</label>
            <input type="text" name="login" id="login" <?= $cookie::checkCookie('login') ?>>
        </div>

        <div>
            <label for="password">Enter your password:</label>
            <input type="password" name="password" id="password" <?= $cookie::checkCookie('password') ?>>
        </div>
        
        <div class="remember-user">
		    <label for="rememberMe">Remember me</label>	
            <input type="checkbox" value="true" id="rememberMe" name="rememberMe" checked>
	    </div>

        <div>
            <input type="submit" value="Log in">
        </div>
    </form>

    <!-- Displaying the success message, if the form was submitted with all the requirements -->
    <?php else : ?>
    <p class="connected"><?= $messages['success'][0] ?></p>
    
    <!-- Displaying a link to the Homepage, if a user logged in -->
    <?php if($session::online() && !$session::admin()) : ?>
    <p class="redirect">Go to the <a href="index.php?p=home">Homepage</a></p>
    
    <!-- Displaying a link to the Admin dashboard page, if an admin logged in -->
    <?php elseif($session::admin()) : ?>
    <p class="redirect">Go to the <a href="index.php?p=dashboard">Admin dashboard</a></p>
    <?php endif; ?>
    <?php endif; ?>
    
    <!-- Link to display as long as the form is not submitted -->
    <?php if(!$_POST) : ?>
    <p class="center">Not registered yet? Click <a href="index.php?p=register">here</a> to create an account!</p>
    <?php endif; ?>
</section>