<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project analysis</title>
    <meta charset="UTF-8">
    <style>
        table, th, td {
            padding: 10px;
            border: 1px solid gray;
            border-collapse: collapse;
            font-size: 12px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        a {
            color: black;
            font-weight: bold;
        }

    </style>
    <script>
        function sortTable(column, type) {
            var table, rows, switching, i, x, y, shouldSwitch;
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

<h1><?php echo $parameters->getProjectName(); ?></h1>

<h3>General information</h3>

<p>First commit: <?php echo $firstCommit->format("Y-m-d") ?></p>
<p>Last commit: <?php echo $lastCommit->format("Y-m-d") ?></p>

<h3>Most active contributors</h3>
<table id="contributors">
    <tr>
        <th onclick="sortTable(0, 'text')">Contributor</th>
        <th onclick="sortTable(1, 'number')">Commits</th>
        <th onclick="sortTable(2, 'text')">From</th>
        <th onclick="sortTable(3, 'text')">To</th>
        <th>
            <svg width="<?php echo $width ?>" height="20">
                <rect width="<?php echo $width ?>" height="20" style="fill:white;"/>
            </svg>
        </th>
    </tr>
    <?php foreach ($contributors as $contributor) { ?>
        <tr>
            <td><?php echo $contributor->getName() ?></td>
            <td><?php echo $contributor->getCommitCount() ?></td>
            <td><?php echo $contributor->getFirstCommit()->format("Y-m-d") ?></td>
            <td><?php echo $contributor->getLastCommit()->format("Y-m-d") ?></td>
            <td>
                <?php
                $start = (int) (($contributor->getFirstCommit()->getTimestamp() - $leftBoundry) * $width / $size);
                $barWidth = (int) (($contributor->getLastCommit()->getTimestamp(
                            ) - $leftBoundry) * $width / $size) - $start;

                if ($barWidth < 3) {
                    $barWidth = 3;
                    if ($start + $barWidth > $width) {
                        $start = $width - $barWidth;
                    }
                }
                ?>

                <svg width="<?php echo $width ?>" height="20">
                    <rect x="<?php echo $start ?>" width="<?php echo $barWidth ?>" height="20" style="fill:green;"/>
                </svg>
            </td>
        </tr>
    <?php } ?>
</table>

<h3>Files edited most often</h3>
<table>
    <tr>
        <th>File</th>
        <th>Commits</th>
    </tr>
    <?php foreach ($popularFiles

    as $popularFile) { ?>
    <tr>
        <td><?php echo $popularFile->getName() ?></td>
        <td><?php echo $popularFile->getCommitCount() ?></td>
        <?php } ?>
</table>

<hr/>

<p align="center">
    Generated with the
    <a href="https://github.com/gbyrka-fingo/git-static-analyzer" target="_blank">Git Static Analyzer</a>
    version <b><?php echo $version?></b>
</p>

<div style="float: right; width: 200px">
    <p align="center"> Powered by: <br/>
        <a href="https://www.fingo.pl" target="_blank">
            <svg viewBox="0 0 164 61" width="164px">
                <g>
                    <path fill="#878787" d="M163,5.5V1h-51.8c-8,0-14.5,2.7-19.8,8C89,11.7,87.2,15,86,19c-0.8,2.4-1.4,6-2.1,10.8l-0.1,1
			c-0.7,5.1-1.5,7.7-2.4,7.9c-0.9,0.2-2.3-1.6-4.2-5.2l-6.2-12c-1.3-2.5-2.4-4.4-3.3-5.3c-0.5-0.5-1-1-1.6-1.3
			c-1.2-0.8-2.4-1-3.8-0.7c-2,0.3-3.4,1.6-4.2,3.7c-0.6,1.3-1.2,3.8-1.7,7.6l-0.1,0.4c-0.5,3.4-1,6.5-1.7,9.1
			c-1.4,5.3-3.1,9.3-5.2,11.7c-0.5,0.6-1,1.1-1.6,1.6c0.9,1.4,1.3,2.9,1.4,4.5c1.3-0.9,2.5-1.9,3.6-3.1c2.1-2.5,3.8-5.9,5.2-9.9
			c0.4-1.4,0.9-3.1,1.3-4.8c0.5-2.4,1-5.3,1.5-8.5l0.1-0.4c0.7-4.9,1.5-7.4,2.3-7.6c0.6-0.1,1.7,1,3.1,3.3c0.3,0.5,0.6,1,1,1.7
			l6.2,11.9c1.4,2.7,2.7,4.7,3.8,5.9c1.5,1.5,3.2,2.2,5.1,1.8c2.1-0.3,3.6-1.7,4.5-4.1c0.5-1.4,1-3.9,1.7-7.6l0.1-0.9
			c0.6-4.4,1.2-7.6,1.8-9.7c1-3.6,2.5-6.5,4.6-8.6c4.2-4.5,9.6-6.7,16.4-6.7L163,5.5L163,5.5z"/>
                    <path fill="#555555" d="M151.2,38.8c2.4-2.5,3.7-5.9,3.7-10.1s-1.2-7.5-3.7-10c-2.4-2.4-5.8-3.7-10-3.7c-4.2,0-7.5,1.2-10,3.7
			c-2.4,2.4-3.6,5.8-3.6,10s1.1,7.6,3.6,10.1s5.8,3.7,10,3.7C145.5,42.4,148.8,41.2,151.2,38.8z M145.8,21.9c0.6,0.7,1,1.7,1.4,2.7
			c0.3,1.1,0.5,2.4,0.5,4c0,1.5-0.2,2.8-0.4,3.9c-0.3,1-0.9,2.1-1.5,2.9c-0.6,0.7-1.3,1.2-2,1.5c-0.9,0.3-1.7,0.5-2.5,0.5
			c-0.9,0-1.7-0.2-2.4-0.5c-0.8-0.3-1.4-0.8-2.1-1.5c-0.5-0.7-1-1.6-1.4-2.7c-0.3-1.1-0.5-2.4-0.5-4.1c0-1.5,0.2-2.8,0.5-4
			c0.3-1.2,0.9-2.1,1.4-2.7c0.6-0.7,1.4-1.2,2.2-1.5c0.8-0.3,1.5-0.4,2.4-0.4c0.9,0,1.7,0.2,2.4,0.4
			C144.5,20.8,145.2,21.3,145.8,21.9z"/>
                    <path fill="#555555" d="M112.4,20c1,0,2,0.2,3,0.4c0.9,0.3,1.7,0.6,2.4,1c0.5,0.3,1.1,0.7,1.8,1.1c0.6,0.4,1.1,0.8,1.4,1h0.8v-6.2
			c-1.9-0.9-3.7-1.5-5.2-1.8c-1.6-0.3-3.2-0.5-5-0.5c-4.6,0-8.1,1.3-10.7,3.8c-2.5,2.5-3.8,5.8-3.8,9.9c-0.1,4.3,1.2,7.7,3.8,10.1
			c2.5,2.4,5.9,3.6,10.5,3.6c1.8,0,3.8-0.3,5.9-0.7c1.9-0.4,3.5-1,4.6-1.4V27.4h-6.8v10.1c-0.3,0.1-0.5,0.1-0.9,0.1
			c-0.3,0-0.6,0-0.9,0c-3.1,0-5.3-0.8-6.8-2.3c-1.6-1.7-2.4-3.9-2.3-6.8c0-1.4,0.3-2.6,0.7-3.7c0.3-1,1-2,1.7-2.7
			c0.8-0.7,1.7-1.1,2.6-1.6C110.1,20.1,111.2,20,112.4,20z"/>
                    <path fill="#555555" d="M16.4,25.5v-4.9h11.8v-5.1H9.7v26.3h6.7V30.6h11.8v-5.2L16.4,25.5z"/>
                    <path fill="#555555" d="M42.9,15.6h-6.8v26.3h6.8V15.6z"/>
                    <path fill="#86AE25" d="M39.4,46.9c-1.7,0-3.2,0.6-4.5,1.8C33.6,50,33,51.5,33,53.3c0,1.7,0.6,3.1,1.8,4.4
			c1.3,1.3,2.8,1.9,4.5,1.9s3.2-0.6,4.5-1.9c1.3-1.2,1.9-2.7,1.9-4.4c0-1.7-0.6-3.2-1.9-4.5C42.6,47.5,41.1,46.9,39.4,46.9z"/>
                    <path fill="#878787" d="M29.8,53.3c0-0.5,0-1.2,0.1-2H1v4.5h28.9C29.8,54.7,29.8,53.9,29.8,53.3z"/>
                </g>
            </svg>
        </a>
    </p>
</div>
</body>
</html>