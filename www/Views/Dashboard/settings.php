<main class="settings">
    <h1 class="settings--title">Paramètres</h1>
    <section class="settings--section">
        <div class="settings--section__current">
            <?php
            $backgroundColor = isset($currentSetting) ? $currentSetting->getBackgroundColor() : $_ENV["BACKGROUND_COLOR"];
            $fontColor = isset($currentSetting) ? $currentSetting->getFontColor() : $_ENV["FONT_COLOR"];
            $fontStyle = isset($currentSetting) ? $currentSetting->getFontStyle() : $_ENV["FONT_STYLE"];
            ?>
            <div class="settings--section__color">
                <h3>Votre couleur de fond actuelle : <?= htmlspecialchars($backgroundColor); ?></h3>
                <div class='settings--section--currentColor' style='background-color: <?= htmlspecialchars($backgroundColor); ?>;'></div>
            </div>
            <div class="settings--section__color">
                <h3>Votre couleur de police actuelle : <?= htmlspecialchars($fontColor); ?></h3>
                <div class='settings--section--currentColor' style='background-color: <?= htmlspecialchars($fontColor); ?>;'></div>
            </div>
            <h3>Votre police actuelle : <?= htmlspecialchars($fontStyle); ?></h3>
        </div>
        <div>
            <h2>Changer vos préférences</h2>
            <?= $settingsForm ?>
        </div>
    </section>
</main>
