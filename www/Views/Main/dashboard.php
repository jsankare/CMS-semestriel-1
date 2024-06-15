<section class="dashboard">
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <section class="dashboard--main">
        <h2>Statistiques</h2>
        <div class="dashboard--main__charts">
            <div class="dashboard--main__chartUnit dashboard--main__chartUnit--1">
                <div class="dashboard--chart__wrapper dashboard--chart__wrapper--1">
                    <h3>Items créés depuis la création du site</h3>
                    <?php if ($userCount > 0 || $pageCount > 0 || $articleCount > 0 || $commentCount > 0) { ?>
                        <div class="chart" id="itemsInformationTemplate"></div>
                    <?php } else { ?>
                        <p>Aucune donnée disponible pour ce graphique.</p>
                    <?php } ?>
                </div>
                <div class="dashboard--chart__wrapper dashboard--chart__wrapper--2">
                    <h3>Rôle des utilisateurs</h3>
                    <?php if ($guestAmount > 0 || $userAmount > 0 || $editorAmount > 0 || $moderatorAmount > 0 || $adminAmount > 0) { ?>
                        <div class="chart" id="usersPerRoleChartTemplate"></div>
                    <?php } else { ?>
                        <p>Aucune donnée disponible pour ce graphique.</p>
                    <?php } ?>
                </div>
            </div>
            <div class="dashboard--main__chartUnit dashboard--main__chartUnit--2">
                <div class="dashboard--chart__wrapper dashboard--chart__wrapper--3">
                    <h3>Sur les articles</h3>
                    <?php if ($articleCount > 0) { ?>
                        <div class="chart" id="articleCommentChartTemplate"></div>
                    <?php } else { ?>
                        <p>Il n'y a pas encore d'article.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
        <span class="chart--attribution">Graphs powered avec <a href="https://www.amcharts.com/docs/v5/" >AmCharts5</a> !</span>
    </section>
</section>

<script>
    am5.ready(function() {
        function createChart(rootId, data, chartType) {
            let root = am5.Root.new(rootId);
            let chart = root.container.children.push(am5percent.PieChart.new(root, {}));
            let series = chart.series.push(am5percent.PieSeries.new(root, {
                valueField: "value",
                categoryField: "category"
            }));

            series.data.setAll(data);

            series.slices.template.setAll({
                tooltipText: "{category}: {value}",
            });

            series.labels.template.setAll({
                text: "{category}"
            });

            series.appear(2000, 100);
            chart.appear(1000, 100);

            root._logo.dispose();
        }

        <?php if ($userCount > 0 || $pageCount > 0 || $articleCount > 0 || $commentCount > 0) { ?>
        const itemsInformationData = [
            { category: "Utilisateurs", value: <?php echo $userCount; ?> },
            { category: "Pages", value: <?php echo $pageCount; ?> },
            { category: "Articles", value: <?php echo $articleCount; ?> },
            { category: "Commentaires", value: <?php echo $commentCount; ?> }
        ];
        createChart("itemsInformationTemplate", itemsInformationData, "PieChart");
        <?php } ?>

        <?php if ($articleCount > 0) { ?>
        const articleCommentChartData = [
            { category: "Avec commentaires", value: <?php echo $articleWithCommentCount; ?> },
            { category: "Sans commentaires", value: <?php echo ($articleCount - $articleWithCommentCount); ?> }
        ];
        createChart("articleCommentChartTemplate", articleCommentChartData, "PieChart");
        <?php } ?>

        <?php if ($guestAmount > 0 || $userAmount > 0 || $editorAmount > 0 || $moderatorAmount > 0 || $adminAmount > 0) { ?>
        const usersPerRoleChartData = [
            { category: "Utilisateurs non confirmés", value: <?php echo $guestAmount; ?> },
            { category: "Utilisateurs confirmés", value: <?php echo $userAmount; ?> },
            { category: "Editeurs", value: <?php echo $editorAmount; ?> },
            { category: "Modérateurs", value: <?php echo $moderatorAmount; ?> },
            { category: "Administrateurs", value: <?php echo $adminAmount; ?> }
        ];
        createChart("usersPerRoleChartTemplate", usersPerRoleChartData, "PieChart");
        <?php } ?>
    });
</script>
