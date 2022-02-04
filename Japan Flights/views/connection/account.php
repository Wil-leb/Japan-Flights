<section class="container">
    <h1>Your account</h1>
</section>
    
<section class="container">
    <h2>Your information</h2>  
    
    <!-- Displaying error messages, if the form was submitted without all the requirements -->
    <?php if(empty($messages['success'])) : ?>
    <?php if(!empty($messages['errors'])) { ?>
    <ul class="error">
        <?php foreach($messages['errors'] as $error): ?>    
        <li><?= $error ?></li>
        <?php endforeach; ?>    
    </ul>
    <?php } ?>
    
    <!-- Information modification form -->
    <form action="index.php?p=account" method="post">
        <div>
            <label for="newGender">Select your gender:</label>
            
            <select name="newGender" id="newGender">
                <?php if($_SESSION['user']['gender'] === '') : ?>
                <option value="" selected>[select gender]</option>
                <?php else : ?>
                <option value="<?= htmlspecialchars($_SESSION['user']['gender']) ?>" selected><?= htmlspecialchars($_SESSION['user']['gender']) ?></option>
                <?php endif; ?>
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
                <option value="Miss">Miss</option>
                <option value="Ms">Ms</option>
            </select>
        </div>
        
        <div>
            <label for="newBirthdate">Modify your birthdate:</label>
            <input type="date" name="newBirthdate" id="newBirthdate" value="<?= htmlspecialchars($_SESSION['user']['birthdate']) ?>">
        </div>
        
        <div>
            <label for="newLastname">Modify your last name:</label>
            <input type="text" name="newLastname" id="newLastname" value="<?= htmlspecialchars(trim($_SESSION['user']['last_name'])) ?>">
        </div>
        
        <div>
            <label for="newFirstname">Modify your first name:</label>
            <input type="text" name="newFirstname" id="newFirstname" value="<?= htmlspecialchars(trim($_SESSION['user']['first_name'])) ?>">
        </div>

        <div>
            <label for="newAddress">Modify your address:</label>
            <input type="text" name="newAddress" id="newAddress" value="<?= htmlspecialchars(trim($_SESSION['user']['address'])) ?>">
        </div>
        
        <div>
            <label for="newCity">Modify your city:</label>
            <input type="text" name="newCity" id="newCity" value="<?= htmlspecialchars(trim($_SESSION['user']['city'])) ?>">
        </div>
        
        <div>
            <label for="newZipcode">Modify your zipcode:</label>
            <input type="text" name="newZipcode" id="newZipcode" value="<?= htmlspecialchars(trim($_SESSION['user']['zip_code'])) ?>">
        </div>
        
        <div>
            <label for="newCountry">Modify your country:</label>
            <input type="text" name="newCountry" id="newCountry" value="<?= htmlspecialchars(trim($_SESSION['user']['country'])) ?>">
        </div>
        
        <div>
            <label for="newPhone">Modify your phone number:</label>
            <input type="text" name="newPhone" id="newPhone" value="<?= htmlspecialchars(trim($_SESSION['user']['phone'])) ?>">
        </div>

        <div>
            <input type="submit" name="confirmChanges" id="confirmChanges" value="Confirm change(s)">
        </div>
    </form>
    
    <!-- Displaying the success message, if the form was submitted with all the requirements -->
    <?php else : ?>
    <p class="success"><?= $messages['success'][0] ?></p>
    <?php endif; ?>
</section>

<section class="container">    
    <h2>Your email</h2>
    
    <!-- Paragraph to display as long as the form is not submitted -->
    <?php if(!$_POST) : ?>
    <p class="mandatory">All the fields are mandatory.</p>
    <?php endif; ?>
    
    <!-- Displaying error messages, if the form was submitted without all the requirements -->
    <?php if(empty($emailMessages['success'])) : ?>
    <?php if(!empty($emailMessages['errors'])) { ?>
    <ul class="error">
        <?php foreach($emailMessages['errors'] as $error): ?>    
        <li><?= $error ?></li>
        <?php endforeach; ?>    
    </ul>
    <?php } ?>
    
    <!-- Email modification form -->
    <form action="index.php?p=account" method="post">
        <div>
            <label for="currentEmail">Enter your current email:</label>
            <input type="text" name="currentEmail" id="currentEmail">
        </div>
        
        <div>
            <label for="newEmail">Create your new email:</label>
            <input type="text" name="newEmail" id="newEmail">
        </div>
        
        <div>
            <label for="confirmNewemail">Confirm your new email:</label>
            <input type="text" name="confirmNewemail" id="confirmNewemail">
        </div>
        
        <div>
            <input type="submit" name="confirmEmailchange" id="confirmEmailchange" value="Confirm email change">
        </div>
    </form>
    
    <!-- Displaying the success message, if the form was submitted with all the requirements -->
    <?php else : ?>
    <p class="success"><?= $emailMessages['success'][0] ?></p>
    <?php endif; ?>
</section>

<section class="container">    
    <h2>Your login</h2>
    
    <!-- Paragraph to display as long as the form is not submitted -->
    <?php if(!$_POST) : ?>
    <p class="mandatory">All the fields are mandatory.</p>
    <?php endif; ?>
    
    <!-- Displaying error messages, if the form was submitted without all the requirements -->
    <?php if(empty($loginMessages['success'])) : ?>
    <?php if(!empty($loginMessages['errors'])) { ?>
    <ul class="error">
        <?php foreach($loginMessages['errors'] as $error): ?>    
        <li><?= $error ?></li>
        <?php endforeach; ?>    
    </ul>
    <?php } ?>
    
    <!-- Login modification form -->
    <form action="index.php?p=account" method="post">
        <div>
            <label for="currentLogin">Enter your current login:</label>
            <input type="text" name="currentLogin" id="currentLogin">
        </div>
        
        <div>
            <label for="newLogin">Create your new login:</label>
            <input type="text" name="newLogin" id="newLogin">
        </div>
        
        <div>
            <label for="confirmNewlogin">Confirm your new login:</label>
            <input type="text" name="confirmNewlogin" id="confirmNewlogin">
        </div>
        
        <div>
            <input type="submit" name="confirmLoginchange" id="confirmLoginchange" value="Confirm login change">
        </div>
    </form>
    
    <!-- Displaying the success message, if the form was submitted with all the requirements -->
    <?php else : ?>
    <p class="success"><?= $loginMessages['success'][0] ?></p>
    <?php endif; ?>
</section>

<section class="container">    
    <h2>Your password</h2>
    
    <!-- Paragraph to display as long as the form is not submitted -->
    <?php if(!$_POST) : ?>
    <p class="mandatory">All the fields are mandatory.</p>
    <?php endif; ?>
    
    <!-- Displaying error messages, if the form was submitted without all the requirements -->
    <?php if(empty($passwordMessages['success'])) : ?>
    <?php if(!empty($passwordMessages['errors'])) { ?>
    <ul class="error">
        <?php foreach($passwordMessages['errors'] as $error): ?>    
        <li><?= $error ?></li>
        <?php endforeach; ?>    
    </ul>
    <?php } ?>
    
    <!-- Password modification form -->
    <form action="index.php?p=account" method="post">
        <div>
            <label for="currentPassword">Enter your current password:</label>
            <input type="password" name="currentPassword" id="currentPassword">
        </div>
        
        <div>
            <label for="newPassword">Create your new password:</label>
            <input type="password" name="newPassword" id="newPassword">
        </div>
        
        <div>
            <label for="confirmNewpassword">Confirm your new password:</label>
            <input type="password" name="confirmNewpassword" id="confirmNewpassword">
        </div>
        
        <div>
            <input type="submit" name="confirmPasswordchange" id="confirmPasswordchange" value="Confirm password change">
        </div>
    </form>
    
    <!-- Displaying the success message, if the form was submitted with all the requirements -->
    <?php else : ?>
    <p class="success"><?= $passwordMessages['success'][0] ?></p>
    <?php endif; ?>
</section>

<section class="container">
    <h2>Your orders</h2>
    
    <!-- Displaying a message if a user has no order history -->
    <?php if(empty($orders)) : ?>
    <p>You have not made any order yet.</p>
    <?php else : ?>
    
    <table>
        <thead>
            <tr>
                <th>Order reference</th>
                <th>Total price</th>
                <th>Order date</th>
                <th>Payment status</th>
                <th>Order status</th>
                <th>Action</th>
            </tr>
        </thead>
                    
        <tbody>
        <!-- Finding a user's paid orders from the database, and displaying them in the table's body -->
        <?php foreach($orders as $order) : ?>
            <?php if(htmlspecialchars($order['status']) !== 'Waiting payment') { ?>
            <tr>
                <td data-label="Order reference" data-id="<?= htmlspecialchars($order['id']) ?>"><?= htmlspecialchars($order['id']) ?></td>
                <td data-label = "Total price"><?= htmlspecialchars($order['total_price']) ?></td>
                <td data-label = "Order date"><?= htmlspecialchars($order['order_date']) ?></td>
                <td data-label = "Payment status"><?= htmlspecialchars($order['payment']) ?></td>
                <td data-label = "Order status"><?= htmlspecialchars($order['status']) ?></td>
                <td>
                    <a href="index.php?p=customerRequests&orderId=<?= htmlspecialchars($order['id']) ?>">Send a request for this order</a>
                </td>
            </tr>
            <?php }?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</section>