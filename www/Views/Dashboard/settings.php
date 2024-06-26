<main class="settings">
    <h1 class="settings--title">Paramètres</h1>
    <section class="settings--section">
        <div>
            <div class="settings--section__color">
                <h3>Votre couleur actuelle : <?= isset($currentSetting) ? $currentSetting->getColor() : $_ENV["BASE_COLOR"]; ?></h3>
                <div class="settings--section--currentColor" style="background-color: <?= $currentSetting->getColor(); ?>"></div>
            </div>
            <h3>Votre police actuelle : <?= isset($currentSetting) ? $currentSetting->getFont() : $_ENV["BASE_FONT"]; ?></h3>
        </div>
        <div>
            <h2>Changer vos préférences</h2>
            <?= $settingsForm ?>
        </div>
    </section>
</main>
