<head>
	<meta name="description" content="Register with Japan Flights, and book top-quality flights to the Empire of the Rising Sun!">
</head>
    
<section class="container">
    <h1>Registration page</h1>
    
    <!-- Paragraphs to display as long as the form is not submitted -->
    <?php if(!$_POST) : ?>
    <p class="center">You can create your account here, if you are not already registered.</p>
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
    
    <!-- Registration form -->
    <form action="index.php?p=register" method="post">
        <div>
            <label for="email">Enter your email:</label>
            <input type="text" name="email" id="email">
        </div>

        <div>
            <label for="login">Create your login:</label>
            <input type="text" name="login" id="login">
        </div>

        <div>
            <label for="password">Create your password:</label>
            <input type="password" name="password" id="password">
        </div>

        <div>
            <label for="confirmPassword">Confirm your password:</label>
            <input type="password" name="confirmPassword" id="confirmPassword">
        </div>

        <div>
            <input type="submit" value="Register">
        </div>
    </form>
    
    <!-- Displaying the success message, if the form was submitted with all the requirements -->
    <?php else : ?>
    <p class="success"><?= $messages['success'][0] ?></p>
    <p class="redirect"><a href="index.php?p=login">Log in</a></p>
    <?php endif; ?>
    
    <!-- Link to display as long as the form is not submitted -->
    <?php if(!$_POST) : ?>
    <p class="center">Already registered? Click <a href="index.php?p=login">here</a> to log in!</p>
    <?php endif; ?>
</section>