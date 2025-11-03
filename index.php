<?php
    include __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "db.php";
    include __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "functions.php";
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body> 
        <h2>Unit Test 1 — Formats</h2>
        <?php 
        // print_r(formats_all());
        $text = "Formats: ";
        $rows = formats_all();
        foreach($rows as $row){
            $text = $text . $row['id'] . $row['name'];
        }
        echo($text);
        ?>
        <hr>

        <h2>Unit Test 2 — Records JOIN</h2>
        <table>

        <?php
            $rows = records_all();
            foreach($rows as $row):
        ?>
        <tr>
            <td><?= $row['title']?></td>
            <td><?= $row['artist']?></td>
            <td><?= $row['price']?></td>

        </tr>

                
        <?php
        endforeach;    
        ?>
        </table>
        <hr>

        <h2>Unit Test 3 — Insert</h2>
        <?php

        ?>
        <hr>
</body>
</html>