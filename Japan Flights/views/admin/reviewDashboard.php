<section class="container">
    <h1>Review dashboard</h1>
    <p>Welcome to the review dashboard! Here, you will be able to delete any reviews with unsuitable content.</p>
</section>

<section class="container">
    <h2>Reviews</h2>
    
    <!-- Displaying a confirmation message, after a review was deleted -->
    <?php if(!empty($deleteMessages['success'])) : ?>
    <p class="success"><?= $deleteMessages['success'][0] ?></p>
    <?php endif; ?>
    
   <table>
        <thead>
            <tr>
                <th>Review Id</th>
                <th>User Id</th>
                <th>Article Id</th>
                <th>Title</th>
                <th>Content</th>
                <th>Rating</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        
        <tbody>
            <!-- Finding the reviews from the database, and displaying them in the table's body -->
            <?php foreach($reviews as $review) : ?>
            <tr>
                <td data-label="Review Id"><?= htmlspecialchars($review['id']) ?></td>
                <td data-label="User Id"><?= htmlspecialchars($review['user_id']) ?></td>
                <td data-label="Article Id"><?= htmlspecialchars($review['article_id']) ?></td>
                <td data-label="Title"><?= htmlspecialchars(trim($review['title'])) ?></td>
                <td data-label="Content"><?= htmlspecialchars(trim($review['content'])) ?></td>
                <td data-label="Rating"><?= htmlspecialchars($review['rating']) ?></td>
                <td data-label="Date"><?= htmlspecialchars($review['post_date']) ?></td>
                <td data-label="Action" class="review-deletion">
                    <!-- Small form to delete a selected review -->
                    <form action="index.php?p=reviewDashboard&reviewId=<?= htmlspecialchars($review['id']) ?>" method="post">
                        <input type="submit" name="deleteReview" id="deleteReview" data-id="<?= htmlspecialchars($review['id']) ?>" value="Delete review" >
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <p class="redirect">Back to the <a href="index.php?p=dashboard">Admin dashboard</a></p>
</section>