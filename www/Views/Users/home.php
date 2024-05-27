<p>Liste des utilisateurs :</p>
<ul>
    <?php foreach ($users as $user): ?>
        <li><?php echo htmlspecialchars($user->getId()),' '.  htmlspecialchars($user->getFirstname() . ' ' . $user->getLastname()); ?></li>
    <?php endforeach; ?>
</ul>