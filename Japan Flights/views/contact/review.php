<section class="container">
    <h1>Your review</h1>
    
    <!-- Paragraph to display as long as the form is not submitted -->
    <?php if(!$_POST) : ?>
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
    
    <!-- Review form -->
    <form action="index.php?p=review" method="post">
        <div>
            <label for="articleSelect">Select the subject of your review:</label>

            <select name="articleSelect" id="articleSelect">
                <option value="" selected>[select subject]</option>
                <!-- Finding the articles from the database, and displaying them in the options -->
                <?php foreach($articles as $article) : ?>
                <option value="<?= htmlspecialchars($article['id']) ?>"><?= htmlspecialchars(trim($article['name'])) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div>
            <label for="title">Title of your review:</label>
            <textarea id="title" name="title" maxlength="40"></textarea>
        </div>

        <div>
            <label for="content">Your review:</label>
            <textarea id="content" name="content" rows="8" cols="40" maxlength="200"></textarea>
        </div>
        
        <p class="rate">Your rating:</p>
        
        <div class="stars">
            <!-- Inserting comments between the stars, to delete the spaces between them -->
            <i class="fas fa-star" data-value="1"></i><!--
            --><i class="fas fa-star" data-value="2"></i><!--
            --><i class="fas fa-star" data-value="3"></i><!--
            --><i class="fas fa-star" data-value="4"></i><!--
            --><i class="fas fa-star" data-value="5"></i>
        </div>
        
        <input type="hidden" name="rating" id="rating" value="0">

        <div>
            <input type="submit" name="sendReview" id="sendReview" value="Post review">
        </div>
    </form>
    
    <!-- Displaying the success message, if the form was submitted with all the requirements -->
    <?php else : ?>
    <p class="success"><?= $messages['success'][0] ?></p>
    <?php endif; ?>
    
    <p class="redirect">Back to the <a href="index.php?p=home">Homepage</a></p>
</section>