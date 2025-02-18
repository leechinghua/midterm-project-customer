<?php

require __DIR__. '/config/pdo-connect.php';

$sql = "SELECT * FROM comment";

$rows = $pdo->query($sql)->fetchAll();

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<div class="div" style="height: 200vh; background-color: white; margin-left: 300px;">
  <table id="myTable" class="display">
    <thead>
      <tr>
        <th>流水號</th>
        <th>會員ID</th>
        <th>商家ID</th>
        <th>comment_star</th>
        <th>發表時間</th>
        <th>留言內容</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($rows as $r) :
      ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><?= $r['customer_id'] ?></td>
          <td><?= $r['store_id'] ?></td>
          <td><?= $r['comment_star'] ?></td>
          <td><?= $r['created_at'] ?></td>
          <td><?= $r['comment_content'] ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<?php include __DIR__ . '/parts/html-foot.php' ?>