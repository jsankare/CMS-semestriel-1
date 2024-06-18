<p>Gallerie view</p>

<p>Le but est de recréer <a href="https://codepen.io/dui77/pen/dyEMZxK" target="blank">ça</a></p>

<?= $galleryForm ?>

<?php if (isset($_FILES["image"])) { ?>
    <div>
        <ul>
            <li><?= $_FILES["title"]; ?></li>
            <li><?= $_FILES["description"]; ?></li>
            <li><?= $_FILES["image"]; ?></li>
        </ul>
    </div>
<?php } ?>