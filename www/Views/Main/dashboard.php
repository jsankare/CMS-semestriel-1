<section class="dashboard">
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <h2>Hello Dashboard</h2>
    <section class="dashboard--main">
        <p>main :</p>
        <div id="chartdiv" style="width: 100%; height: 250px;"></div>
    </section>
    <aside class="dashboard--aside">
        <p>aside</p>
        <?php if (!empty($pages)) : ?>
            <ul>
                <?php foreach ($pages as $page) : ?>
                    <li>Page : <?php echo htmlspecialchars($page->getTitle()); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucune page disponible</p>
        <?php endif; ?>
    </aside>
    <a href="/profile">Profil</a>
</section>
<script>
    am5.ready(function() {
        var root = am5.Root.new("chartdiv");

        var chart = root.container.children.push(am5percent.PieChart.new(root, {}));

        var series = chart.series.push(am5percent.PieSeries.new(root, {
            valueField: "value",
            categoryField: "category"
        }));

        var data = [
            {
                category: "Users",
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
                category: "Comments",
                value: <?php echo $commentCount; ?>
            }
        ];

        series.data.setAll(data);

        series.appear(2000, 100);
        chart.appear(1000, 100);
    });
</script>

