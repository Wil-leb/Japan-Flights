<section class="container">
    <h1>Your request</h1>
    
    <!-- Paragraph to display as long as the form is not submitted -->
    <?php if(!$_POST) : ?>
    <p class="mandatory">All the fields are mandatory.</p>
    <?php endif; ?>
    
    <!-- Displaying error messages, if the form was submitted without all the requirements -->
    <?php if(empty($messages['success'])) : ?>
    <?php if(!empty($messages['errors'])) { ?>
    <ul class="error">
        <?php foreach($messages['errors'] as $error) : ?>    
        <li><?= $error ?></li>
        <?php endforeach ?>    
    </ul>
    <?php } ?>
    
    <!-- Customer request form -->
    <form action="index.php?p=customerRequests&orderId=<?= htmlspecialchars($findOrder['id']) ?>" method="post">
        <div>
            <label for="requestSelect">Select the subject of your request:</label>
            
            <select name="requestSelect" id="requestSelect">
                <option value="" selected>[select subject]</option>
                <option value="cancellation">Order cancellation</option>
                <option value="repayment">Repayment request</option>
                <option value="other">Other request</option>
            </select>
        </div>

        <div>
            <label for="customerRequest">Your request:</label>
            <textarea name="customerRequest" id="customerRequest" rows="8" cols="40" maxlength="500"></textarea>
        </div>

        <div>
            <input type="submit" name="sendRequest" id="sendRequest" value="Send request">
        </div>
    </form>
    
    <!-- Displaying the success message, if the form was submitted with all the requirements -->
    <?php else : ?>
    <p class="success"><?= $messages['success'][0] ?></p>
    <?php endif; ?>
    
    <p class="redirect">Back to your <a href="index.php?p=account">account</a></p>
</section>