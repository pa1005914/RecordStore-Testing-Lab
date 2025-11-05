<form method="post">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title">
    <label for="artist">Artist:</label>
    <input type="text" name="artist" id="artist">
    <label for="price">Price:</label>
    <input type="text" name="price" id="price">
    <label for="format">Pick a format:</label>
    <select name="format_id" id="format_id">
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