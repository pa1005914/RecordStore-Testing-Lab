<!-- it comes from bellow the switch statment in the index page 
$records_in_cart is needed because it provides the to be displayed in the cart -->
<h2>Your Cart</h2>

<?php $records = $records_in_cart ?? []; ?>

<?php if (empty($records)): ?>
  <p>Your cart is empty.</p>
<?php else: ?>

  <table class="table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Artist</th>
        <th>Format</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($records as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['title'])?></td>
            <td><?= htmlspecialchars($row['artist'])?></td>
            <td><?= htmlspecialchars($row['name'])?></td>
            <td><?= htmlspecialchars($row['price'])?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <form method="post">
    <input type="hidden" name="action" value="checkout">
    <button class="btn btn-success">Complete Purchase</button>
  </form>

<?php endif; ?>