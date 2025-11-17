<?php

    $is_edit  = isset($record) && isset($record['id']);
    $action   = $is_edit ? 'update' : 'create';

    $title    = $is_edit ? htmlspecialchars($record['title'])  : '';
    $artist   = $is_edit ? htmlspecialchars($record['artist']) : '';
    $price    = $is_edit ? htmlspecialchars($record['price'])  : '';
    $format_id = $is_edit ? (int)$record['format_id']            : 0;
?>


<form method="post">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="<?php $title ?>">
    <label for="artist">Artist:</label>
    <input type="text" name="artist" id="artist" value="<?php $artist ?>">
    <label for="price">Price:</label>
    <input type="text" name="price" id="price" value="<?php $price ?>">
    <label for="format">Pick a format:</label>
    <select name="format_id" id="format_id" value="<?php $format_id ?>">
        <?php
        $rows = formats_all();
        foreach($rows as $row):
        ?>
        <option value="<?=htmlspecialchars($row['id'])?>"><?= htmlspecialchars($row['name'])?></option>
        <?php endforeach ?>
    </select>

    <input type="hidden" name="action" value="create">

    <button>Create</button>
</form>