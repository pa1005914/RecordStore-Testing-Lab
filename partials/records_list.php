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
            <td>
            <td>
                <form method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                    <input type="hidden" name="action" value="edit">
                    <button class="btn btn-sm btn-outline-primary">Edit</button>
                </form>
                <form method="post" class="d-inline" onsubmit="return confirm('Delete this book?');">
                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                    <input type="hidden" name="action" value="delete">
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </table>