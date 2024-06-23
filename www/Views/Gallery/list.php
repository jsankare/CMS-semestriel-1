<h2>Liste des images en back</h2>

<?php if (!empty($images)): ?>
    <div class="gallery">
        <?php foreach ($images as $image): ?>
            <div class="image-item">
                <h3><?php echo htmlspecialchars($image->getTitle()); ?></h3>
                <p><?php echo htmlspecialchars($image->getDescription()); ?></p>
                <?php 
                    $link = $image->getLink();
                    $relativeLink = str_replace('/var/www/html/Public', '', $link);
                ?>
                <img src="<?php echo htmlspecialchars($relativeLink); ?>" alt="<?php echo htmlspecialchars($image->getDescription()); ?>">
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Aucune image trouvée.</p>
<?php endif; ?>
