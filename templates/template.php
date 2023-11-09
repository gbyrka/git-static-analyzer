<?php

/**
 * @var string $projectName
 * @var string $currentDate
 * @var string $firstCommit
 * @var string $lastCommit
 * @var Contributor[] $contributors
 * @var int $leftBoundary
 * @var int $width
 * @var int $size
 * @var \GitStaticAnalyzer\File[] $popularFiles
 * @var string $version
 **/

use GitStaticAnalyzer\Contributor;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project analysis</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Helvetica, sans-serif;
            font-size: 1rem;
            color: #333;
        }

        main.wrapper {
            width: 1080px;
            margin: 0 auto;
        }

        table, th, td {
            padding: 10px;
            border: 1px solid rgb(128, 128, 128);
            border-collapse: collapse;
            font-size: 12px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        a {
            color: black;
        }

        .report-header {
            margin-bottom: 2em;
        }

        .report-section {
            margin: 2em 0;
        }

        .report-footer {
            margin-top: 1em;
            border-top: 1px solid #ddd;
            display: flex;
            width: 100%;
        }

        .header__subtitle {
            color: #aaa;
        }

        .report-footer__copyright {
            flex: 1;
        }

        .table--full-width {
            width: 100%;
        }

        #contributors th:hover {
            cursor: pointer;
            color: #666;
        }

    </style>
    <script>
        function sortTable(column, type) {
            let table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("contributors");
            switching = true;

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[column];
                    y = rows[i + 1].getElementsByTagName("TD")[column];
                    switch (type) {
                        case "text":
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                            }
                            break;
                        case "number":
                            if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
                                shouldSwitch = true;
                            }
                            break;
                    }

                    if (shouldSwitch === true) {
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }
    </script>
</head>
<body>

<main class="wrapper">
    <header class="report-header">
        <h1>Report summary: <?= $projectName; ?></h1>
        <section class="header__subtitle">Generated: <?= $currentDate ?></section>
    </header>

    <section class="report-body">
        <section class="report-section">
            <h3>General information</h3>

            <p>First commit: <?= $firstCommit ?></p>
            <p>Last commit: <?= $lastCommit ?></p>
        </section>

        <section class="report-section">
            <h3>Most active contributors</h3>
            <table id="contributors" class="table table--full-width">
                <tr>
                    <th onclick="sortTable(0, 'text')">Contributor</th>
                    <th onclick="sortTable(1, 'number')">Commits</th>
                    <th onclick="sortTable(2, 'text')">From</th>
                    <th onclick="sortTable(3, 'text')">To</th>
                    <th></th>
                </tr>
                <?php foreach ($contributors as $contributor) : ?>
                    <tr>
                        <td><?= $contributor->getName() ?></td>
                        <td><?= $contributor->getCommitCount() ?></td>
                        <td><?= $contributor->getFirstCommit()->format("Y-m-d") ?></td>
                        <td><?= $contributor->getLastCommit()->format("Y-m-d") ?></td>
                        <td>
                            <?php
                            $firstCommitTime = $contributor->getFirstCommit()->getTimestamp();
                            $lastCommitTime = $contributor->getLastCommit()->getTimestamp();

                            $start = (int)(($firstCommitTime - $leftBoundary) * $width / $size);
                            $barWidth = (int)(($lastCommitTime - $leftBoundary) * $width / $size) - $start;

                            if ($barWidth < 3) {
                                $barWidth = 3;
                                if ($start + $barWidth > $width) {
                                    $start = $width - $barWidth;
                                }
                            }
                            ?>

                            <svg width="<?= $width ?>%" height="20">
                                <rect x="<?= $start ?>%" width="<?= $barWidth ?>%" height="20" style="fill:green;"/>
                            </svg>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </section>

        <section class="report-section">
            <h3>Files edited most often</h3>
            <table>
                <tr>
                    <th>File</th>
                    <th>Commits</th>
                </tr>
                <?php foreach ($popularFiles as $popularFile) : ?>
                    <tr>
                        <td><?= $popularFile->getName() ?></td>
                        <td><?= $popularFile->getCommitCount() ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>

    </section>

    <footer class="report-footer">
        <div class="report-footer__copyright">
            <p>Generated with the
                <a href="https://github.com/gbyrka/git-static-analyzer" target="_blank">
                    <strong>Git Static Analyzer</strong>
                </a>
                version
                <strong>0.3.0</strong>
            </p>
        </div>
    </footer>

</main>
</body>
</html>
