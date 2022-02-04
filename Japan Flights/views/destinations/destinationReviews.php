<head>
	<meta name="description" content="Welcome to the customers' review page for Japan Flights. Happy reading!">
</head>
    
<section class="container">
    <h1>Reviews for <?= htmlspecialchars(trim($articleName['name'])) ?></h1>
            
    <div class="reviews">
        <?php foreach($reviews as $review) : ?>
        <!-- Finding the article's reviews from the database, and displaying them in the div -->
        <div class="review-content">
            <div class="total-rating<?= htmlspecialchars($review['rating']) ?>">
                <!-- Inserting comments between the stars, to delete the spaces between them -->
                <i class="far fa-star"></i><!--
                --><i class="far fa-star"></i><!--
                --><i class="far fa-star"></i><!--
                --><i class="far fa-star"></i><!--
                --><i class="far fa-star"></i>
            </div>
        
            <q><?= htmlspecialchars(trim($review['title'])) ?></q>
            
            <blockquote><?= htmlspecialchars(trim($review['content'])) ?></blockquote>
            
            <p>Published by <?= htmlspecialchars($review['user_login']) ?>, on <?= htmlspecialchars($review['post_date']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
            
    <p class="redirect">Back to the <a href="index.php?p=destinations">Destinations page</a></p>
</section>