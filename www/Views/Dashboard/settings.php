<main class="settings">
    <h1 class="settings--title">Paramètres</h1>
    <section class="settings--section">
        <div>
            <h3>Votre code couleur actuelle : <?= isset($settings) ? $settings->getColor() : $_ENV["BASE_COLOR"]; ?></h3>
            <h3>Votre police actuelle : <?= isset($settings) ? $settings->getFont() : $_ENV["BASE_FONT"]; ?></h3>
        </div>
        <?= $settingsForm ?>
    </section>
</main>