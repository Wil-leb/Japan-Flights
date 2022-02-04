<!-- Finding each article's average rating from the database, to be displayed in the Destinations page -->
<?php foreach($ratings as $rating) : ?>
<div class="global-rating<?= htmlspecialchars(floor($rating['rate'])) ?>">
    <!-- Inserting comments between the stars, to delete the spaces between them -->
    <i class="far fa-star"></i><!--
    --><i class="far fa-star"></i><!--
    --><i class="far fa-star"></i><!--
    --><i class="far fa-star"></i><!--
    --><i class="far fa-star"></i>
</div>
<?php endforeach; ?>