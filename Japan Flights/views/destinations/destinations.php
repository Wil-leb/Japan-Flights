<head>
	<meta name="description" content="Welcome to Japan Flights' Destinations page. Happy browsing and choose well!">
</head>
    
<section class="container">
    <h1>Our destinations</h1>
    
    <!-- Div to display a modal created with JavaScript, if a user clicks on a buying button -->
    <div id="booking-modal"></div>
    
    <div class="products">
        <!-- Finding the articles from the database, and displaying them in the article tag -->
        <?php foreach($articles as $article) : ?>
        <article class="buy" data-id="<?= htmlspecialchars($article['id']) ?>" id="<?= htmlspecialchars(trim($article['name'])) ?>">
            
            <figure>
                <img src="assets/img/articles/<?= htmlspecialchars($article['id']) ?>/<?= htmlspecialchars($article['picture']) ?>" alt="Photo of <?= htmlspecialchars(trim($article['name'])) ?>">
                
                <figcaption>
                    <h2 data-name="<?= htmlspecialchars(trim($article['name'])) ?>"><?= htmlspecialchars($article['name']) ?></h2>
                    <p data-description="<?= htmlspecialchars(trim($article['description'])) ?>"><?= htmlspecialchars($article['description']) ?></p>
                    <h3 data-price="<?= htmlspecialchars($article['price']) ?>">&#36;<?= htmlspecialchars(number_format($article['price'], 2)) ?>&#42;</h3>
                </figcaption>
            </figure>
            
            <div>Average rating:
                <div class="average-rating<?= htmlspecialchars($article['id']) ?>"></div>
            </div>
                    
            <a href="index.php?p=destinationReviews&articleId=<?= htmlspecialchars($article['id']) ?>&page=1">See all the reviews for this destination</a>
            
            <!-- Hiding the buying buttons, if an admin is connected -->
            <?php if(!$session::online() || $session::online() && !$session::admin()) : ?>
            <button type="button">Buy flight to <?= htmlspecialchars(trim($article['name'])) ?></button>
            <?php endif; ?>
        </article>
        <?php endforeach; ?>
    </div>
    
    <p><em>&#42;The indicated prices correspond with a round-trip ticket for one person.</em></p>
</section>