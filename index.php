<?php
    include __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "db.php";
    include __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "functions.php";

    $view   = filter_input(INPUT_GET, 'view') ?: 'list';
    $action = filter_input(INPUT_POST, 'action');

    switch ($action) {
        case 'create':
            $title    = trim((string)(filter_input(INPUT_POST, 'title') ?? ''));
            $artist   = trim((string)(filter_input(INPUT_POST, 'artist') ?? ''));
            $price    = (float)(filter_input(INPUT_POST, 'price') ?? 0);
            $format_id = (int)(filter_input(INPUT_POST, 'format_id') ?? 0);
            
            if ($title && $artist && $format_id) {
                record_insert($title, $artist, $price, $format_id);
                $view = 'created';
            } else {
                $view = 'create';
            }
            break;
        }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php include __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'bootstrapcdnlinks.php'; ?>

    <title>Document</title>
</head>
<body> 
        <?php include __DIR__ . DIRECTORY_SEPARATOR .'components' . DIRECTORY_SEPARATOR . 'nav.php'?>
        <?php
            if ($view === 'list'){
                include __DIR__ . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'records_list.php';
            }
            elseif ($view === 'create'){
                include __DIR__ . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'record_form.php';
            }
            elseif ($view === 'created'){
                include __DIR__ . DIRECTORY_SEPARATOR . 'partials' . DIRECTORY_SEPARATOR . 'record_created.php';
            }
            
            
        ?>
        <!-- <h2>Unit Test 1 — Formats</h2>
        <table>
            <tr>
            <td>Formats:</td>
        <?php
        $rows = formats_all();
        foreach($rows as $row):
        ?>

        <td><?= $row['name'] ?></td>
        <?php
        endforeach
        ?>
        </tr>
        </table>
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
        <?php //record_insert('Playing God', 'Polyphia', 20.99, 3)?>

        <table>
            <tr>
                <th>Title</th>
                <th>Format</th>
                <th>Price</th>
            </tr>
            <?php
                $rows = records_all();
                foreach($rows as $row):
            ?>
        <tr>
            <td><?= $row['title']?></td>
            <td><?= $row['name']?></td>
            <td><?= $row['price']?></td>

        </tr>
        <?php endforeach;?>
        <hr> -->
</body>
</html>