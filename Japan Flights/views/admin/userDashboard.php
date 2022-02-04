<section class="container">
    <h1>User dashboard</h1>
    <p>Welcome to the user dashboard! Here, you will be able to delete any users who asked the deletion of their account, or who had an unsuitable behavior.</p>
</section>

<section class="container">
    <h2>Users</h2>
    
    <!-- Displaying a confirmation message, after a user was deleted -->
    <?php if(!empty($deleteMessages['success'])) : ?>
    <p class="success"><?= $deleteMessages['success'][0] ?></p>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Login</th>
                <th>Action</th>
            </tr>
        </thead>
        
        <tbody>
            <!-- Finding the users from the database, and displaying them in the table's body -->
            <?php foreach($users as $user) : ?>
            <tr>
                <td data-label="Id"><?= htmlspecialchars($user['id']) ?></td>
                <td data-label="Email"><?= htmlspecialchars($user['email']) ?></td>
                <td data-label="Login"><?= htmlspecialchars($user['login']) ?></td>
                <td data-label="Action" class="user-deletion">
                    <!-- Small form to delete a selected user -->
                    <form action="index.php?p=userDashboard&userId=<?= htmlspecialchars($user['id']) ?>" method="post">
                        <input type="submit" name="deleteUser" id="deleteUser" data-id="<?= htmlspecialchars($user['id']) ?>" value="Delete user" >
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <p class="redirect">Back to the <a href="index.php?p=dashboard">Admin dashboard</a></p>
</section>