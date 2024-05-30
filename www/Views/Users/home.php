<section class="user--wrapper">
    <h2>Menu Utilisateurs</h2>
    <section class="user--navigation">
        <a href="/users/create"><img class="user--icon" src="/assets/addUser.svg" alt="Créer une utilisateur" ></a>
    </section>
    <ul>
        <?php if (!empty($users)): ?>
            <?php
            usort($users, function($a, $b) {
                return $a->getId() <=> $b->getId();
            });
            ?>
            <section class="user--wrapper__close">
                <?php foreach ($users as $user): ?>
                    <div class="user--wrapper__unit">
                        <li>
                            <h3>Id utilisateur</h3><p><?php echo htmlspecialchars($user->getId()); ?></p>
                        </li>
                        <li>
                            <h3>Prénom</h3><p><?php echo htmlspecialchars($user->getFirstname()); ?></p>
                        </li>
                        <li>
                            <h3>Nom</h3><p><?php echo htmlspecialchars($user->getLastname()); ?></p>
                        </li>
                        <li>
                            <h3>Email</h3><p><?php echo htmlspecialchars($user->getEmail()); ?></p>
                        </li>
                        <li>
                            <h3>Status</h3><p><?php echo htmlspecialchars($user->getStatus()); ?></p>
                        </li>
                        <div class="user--iconsWrapper">
                            <a href="/users/edit?id=<?php echo $user->getId(); ?>"><img class="user--icon user--icon__edit" src="/assets/update.svg" alt="Modifier utilisateur"></a>
                            <a href="/users/delete?id=<?php echo $user->getId(); ?>"><img class="user--icon user--icon__trash" src="/assets/trash.svg" alt="Supprimer utilisateur"></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <li>Il n'y a pas d'utilisateur pour le moment !</li>
        <?php endif; ?>
    </ul>
</section>