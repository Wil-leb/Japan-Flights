<section class="container">
    <h1>Article modification</h1>
    
    <!-- Paragraphs to display as long as the form is not submitted -->
    <?php if(!$_POST) : ?>
    <p>Welcome to the article modification page! Here, you will be able to modify the content of the selected article.</p>
    <p class="mandatory">All the fields are mandatory.</p>
    <?php endif; ?>
    
    <!-- Displaying error messages, if the form was submitted without all the requirements -->
    <?php if(empty($messages['success'])) : ?>
    <?php if(!empty($messages['errors'])) { ?>
    <ul class="error">
        <?php foreach($messages['errors'] as $error) : ?>    
        <li><?= $error ?></li>
        <?php endforeach; ?>    
    </ul>
    <?php } ?>

    <!-- Article modification form -->
    <form enctype="multipart/form-data" action="index.php?p=modifyArticle&articleId=<?= htmlspecialchars($findArticle['id']) ?>" method="post">
        <div>
            <label for="newName">Article name:</label>
            <input type="text" name="newName" id="newName" value="<?= htmlspecialchars(trim($findArticle['name'])) ?>">
        </div>
        
        <div>
            <label for="newDescription">Article description:</label>
            <textarea name="newDescription" id="newDescription" rows="8" cols="60" maxlength="500"><?= htmlspecialchars(trim($findArticle['description'])) ?></textarea>
        </div>
        
        <div>
            <label for="newPrice">Article price:</label>
            <input type="text" name="newPrice" id="newPrice" value="<?= htmlspecialchars($findArticle['price']) ?>">
        </div>
        
        <div>
            <label for="newPicture">Article picture:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
            <input type="file" class="form-control-file" name="newPicture" id="newPicture" value="<?= htmlspecialchars($findArticle['picture']) ?>">
        </div>
        
        <div>
            <input type="submit" name="confirmArticlechanges" id="confirmArticlechanges" value="Confirm changes">
        </div>
    </form>
    
    <!-- Displaying the success message, if the form was submitted with all the requirements -->
    <?php else : ?>
    <p class="success"><?= $messages['success'][0] ?></p>
    <?php endif; ?>
    
    <p class="redirect">Back to the <a href="index.php?p=articleDashboard">Article dashboard</a></p>
</section>