<section class="dashboard">
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <section class="dashboard--main">
        <h2>Statistiques</h2>
        <div class="dashboard--main__charts" >
            <div class="dashboard--main__chartUnit dashboard--main__chartUnit--1">
                <div class="dashboard--chart__wrapper dashboard--chart__wrapper--1" >
                    <h3>Items créés depuis la création du site</h3>
                    <div class="chart" id="itemsInformationTemplate"></div>
                </div>
                <div class="dashboard--chart__wrapper dashboard--chart__wrapper--2">
                    <h3>Rôle des <?php echo $userCount ?> utilisateurs</h3>
                    <div class="chart" id="usersPerRoleChartTemplate"></div>
                </div>
            </div>

            <div class="dashboard--main__chartUnit dashboard--main__chartUnit--2">
                <div class="dashboard--chart__wrapper dashboard--chart__wrapper--3">
                    <h3>Sur les <?php echo $articleCount ?> articles</h3>
                    <div class="chart" id="articleCommentChartTemplate"></div>
                </div>
            </div>
        </div>

    </section>
    <aside class="dashboard--aside">
        <p>aside</p>
        <a href="/profile">Profil</a>
        <p>attribution amcharts5</p>
    </aside>
</section>
<script>
    am5.ready(function() {

        let itemsInformation = am5.Root.new("itemsInformationTemplate");
        let itemsInformationTemplate = itemsInformation.container.children.push(am5percent.PieChart.new(itemsInformation, {}));
        let userSeries = itemsInformationTemplate.series.push(am5percent.PieSeries.new(itemsInformation, {
            valueField: "value",
            categoryField: "category"
        }));

        let articleCommentChart = am5.Root.new("articleCommentChartTemplate");
        let articleCommentChartTemplate = articleCommentChart.container.children.push(am5percent.PieChart.new(articleCommentChart, {}));
        let articleCommentSeries = articleCommentChartTemplate.series.push(am5percent.PieSeries.new(articleCommentChart, {
            valueField: "value",
            categoryField: "category"
        }));

        let usersPerRoleChart = am5.Root.new("usersPerRoleChartTemplate");
        let usersPerRoleChartTemplate = usersPerRoleChart.container.children.push(am5percent.PieChart.new(usersPerRoleChart, {}));
        let usersPerRoleSeries = usersPerRoleChartTemplate.series.push(am5percent.PieSeries.new(usersPerRoleChart, {
            valueField: "value",
            categoryField: "category"
        }));

        itemsInformation._logo.dispose();
        articleCommentChart._logo.dispose();
        usersPerRoleChart._logo.dispose();

        const itemsInformationData = [
            {
                category: "Utilisateurs",
                value: <?php echo $userCount; ?>
            },
            {
                category: "Pages",
                value: <?php echo $pageCount; ?>
            },
            {
                category: "Articles",
                value: <?php echo $articleCount; ?>
            },
            {
                category: "Commentaires",
                value: <?php echo $commentCount; ?>
            }
        ];

        const articleCommentChartData = [
            {
                category: "Avec commentaires",
                value: <?php echo $articleWithCommentCount;?>
            },
            {
                category: "Sans commentaires",
                value: <?php echo ($articleCount - $articleWithCommentCount) ?>
            },
        ];

        const usersPerRoleChartData = [
            {
                category: "Utilisateurs non confirmés",
                value: <?php echo $guestAmount; ?>
            },
            {
                category: "Utilisateurs confirmés",
                value: <?php echo $userAmount; ?>
            },
            {
                category: "Editeurs",
                value: <?php echo $editorAmount; ?>
            },
            {
                category: "Modérateurs",
                value: <?php echo $moderatorAmount; ?>
            },
            {
                category: "Administrateurs",
                value: <?php echo $adminAmount; ?>
            }
        ];

        userSeries.data.setAll(itemsInformationData);

        articleCommentSeries.data.setAll(articleCommentChartData);

        articleCommentSeries.labels.template.setAll({
            text: "{category}"
        });

        usersPerRoleSeries.data.setAll(usersPerRoleChartData);

        usersPerRoleSeries.slices.template.setAll({
            tooltipText: "{category}: {value}",
        });

        usersPerRoleSeries.labels.template.setAll({
            text: "{category}"
        });

        userSeries.appear(2000, 100);
        articleCommentSeries.appear(2000, 100);
        usersPerRoleSeries.appear(2000, 100);

        itemsInformationTemplate.appear(1000, 100);
        articleCommentChartTemplate.appear(1000, 100);
        usersPerRoleChartTemplate.appear(1000, 100);

    });
</script>
