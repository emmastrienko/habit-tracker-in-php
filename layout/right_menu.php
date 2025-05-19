<nav id="menu" class="hidden">
    <ul>
      <li><a href="index.php">Home Page</a></li>
      <li><a href="index.php?action=about">About Site</a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="index.php?action=logout">Logout</a></li>
        <?php else: ?>
            <li><a href="index.php?action=login">Login</a></li>
        <?php endif; ?>
      <li><a href="index.php?action=registration">Registration</a></li>
      <?php if (!empty($_SESSION['user_id'])): ?>
    <li><a href="index.php?action=profile">Profile</a></li>
    <li><a href="index.php?action=goals">Goals</a></li>
      <?php endif; ?>
    </ul>
</nav>