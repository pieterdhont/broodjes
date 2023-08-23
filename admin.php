<?php
require_once 'GebruikersLijst.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["block"])) {
        GebruikersLijst::blockUser((int) $_POST["userId"]);
    } elseif (isset($_POST["unblock"])) {
        GebruikersLijst::unblockUser((int) $_POST["userId"]);
    }
}

$users = GebruikersLijst::getAllUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
</head>
<body>
<h1>Admin Page</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user->getID(); ?></td>
            <td><?php echo $user->getNaam(); ?></td>
            <td><?php echo $user->getEmail(); ?></td>
            <td><?php echo $user->isBlocked() ? 'Blocked' : 'Active'; ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="userId" value="<?php echo $user->getID(); ?>">
                    <?php if ($user->isBlocked()): ?>
                        <input type="submit" name="unblock" value="Unblock">
                    <?php else: ?>
                        <input type="submit" name="block" value="Block">
                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        <ul>
            <li><a href="index.php">Terug naar Startpagina</a></li>
        </ul>

</body>
</html>
