<section>
    <div>
        <h1>Image Update</h1>
        <?= $imageForm ?>
    </div>
    <aside>
        <?php
        $link = $image->getLink();
        $relativeLink = str_replace('/var/www/html/Public', '', $link);
        ?>
        <p>Mon image :</p>
        <img class="gallery--picture__edit" src="<?php echo htmlspecialchars($relativeLink); ?>" alt="<?php echo htmlspecialchars($image->getDescription()); ?>">
    </aside>
</section>



