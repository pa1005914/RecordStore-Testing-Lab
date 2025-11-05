<?php
    $rows = records_all();
?>
    <table>
        <tr>
            <th>Title</th>
            <th>Artist</th>
            <th>Price</th>
            <th>Format (from JOIN)</th>
        </tr>
        <?php foreach($rows as $row):?>
        <tr>
            <td><?= htmlspecialchars($row['title'])?></td>
            <td><?= htmlspecialchars($row['artist'])?></td>
            <td><?= htmlspecialchars($row['price'])?></td>
            <td><?= htmlspecialchars($row['name'])?></td>
        </tr>
        <?php endforeach ?>
    </table>