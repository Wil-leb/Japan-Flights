<section class="container">
    <h1>Article dashboard</h1>
    <p>Welcome to the article dashboard! Here, you will be able to access a form, so as to modify the content of a selected article.</p>
</section>

<section class="container">
    <h2>Articles</h2>
    
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Picture</th>
                <th>Modify</th>
            </tr>
        </thead>
        
        <tbody>
            <!-- Finding the articles from the database, and displaying them in the table's body -->
            <?php foreach($articles as $article) : ?>
            <tr>
                <td data-label="Id"><?= htmlspecialchars($article['id']) ?></td>
                <td data-label="Name"><?= htmlspecialchars(trim($article['name'])) ?></td>
                <td data-label="Description" id="description"><?= htmlspecialchars(trim($article['description'])) ?></td>
                <td data-label="Price"><?= htmlspecialchars($article['price']) ?></td>
                <td data-label="Picture"><?= htmlspecialchars($article['picture']) ?></td>
                <td data-label="Modify">
                    <!-- Link to modify a selected article -->
                    <a href="index.php?p=modifyArticle&articleId=<?= htmlspecialchars($article['id'])?>">Modify article</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <p class="redirect">Back to the <a href="index.php?p=dashboard">Admin dashboard</a></p>
</section>