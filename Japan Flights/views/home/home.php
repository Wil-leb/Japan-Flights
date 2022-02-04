<head>
	<meta name="description" content="Welcome to Japan Flights, the site for booking top-quality flights to the Empire of the Rising Sun!">
</head>
    
<section class="container">
    <h1>About us</h1>
    
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates veritatis rerum sapiente tenetur et optio illum provident quasi voluptatem quaerat, unde sed culpa vero sint nobis nisi quo impedit fuga dolorem dolorum? Totam provident sed, exercitationem reprehenderit fugit, vero neque consequuntur iste facilis, modi asperiores?</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia, animi autem hic obcaecati doloribus cum tenetur. Assumenda illo accusamus ad suscipit totam nam laudantium. Nostrum, odio, deleniti, nemo voluptatum illum reprehenderit beatae placeat quis odit ut accusantium quo suscipit similique. Ipsum, officiis explicabo quasi praesentium!</p>
</section>

<section class="container">
    <h2>Our destinations</h2>
    
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat, sunt, molestiae odit modi fuga blanditiis atque quae nostrum provident ea laboriosam quaerat commodi repellendus! Error, sequi, vero molestias dicta perspiciatis ratione ad cumque molestiae eius possimus. Inventore nostrum quo esse quod temporibus voluptatibus consectetur blanditiis.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat, sunt, molestiae odit modi fuga blanditiis atque quae nostrum provident ea laboriosam quaerat commodi repellendus! Error, sequi, vero molestias dicta perspiciatis ratione ad cumque molestiae eius possimus. Inventore nostrum quo esse quod temporibus voluptatibus consectetur blanditiis.</p>
    
    <!-- Link to the Destinations page, for the mobile format -->
    <a href="index.php?p=destinations" class="mobile-more">See more</a>
    
    <!-- Slider with images and links for each destination, for the tablet format and superior -->
    <div class="scroll-slider">
        
        <!-- Finding the articles from the database, and displaying them in the slider -->
        <?php foreach($articles as $article) : ?>
        <div class="content" data-id="<?= htmlspecialchars($article['id']) ?>">
            <figure>
                <img src="assets/img/articles/<?= htmlspecialchars($article['id']) ?>/<?= htmlspecialchars($article['picture']) ?>" alt="Photo of <?= htmlspecialchars(trim($article['name'])) ?>">
                
                <figcaption>
                    <h2><?= htmlspecialchars(trim($article['name'])) ?></h2>
                    <a href="index.php?p=destinations#<?= htmlspecialchars(trim($article['name'])) ?>">See more</a>
                </figcaption>
            </figure>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="container">
    <h2>Contact us</h2>
    
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellat tempora enim dolorem eos consequatur. Officia exercitationem velit est, ipsam eum aut quia, rem eaque fuga eos aspernatur deserunt vitae quis commodi. Soluta iusto numquam officia!</p>
    
    <!-- Hiding the link to the contact form, if an admin is connected -->
    <?php if($session::admin()) : ?>
    <p>Contact us and we will get back to you within 24 hours!</p>
    <?php else : ?>
    <p>Click <a href="index.php?p=contactForm" id="contact-link">here</a> to contact us and we will get back to you within 24 hours!</p>
	<?php endif; ?>
</section>