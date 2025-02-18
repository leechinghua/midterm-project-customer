<?php
require __DIR__ . './config/pdo-connect.php';

$title = "場地管理";

$t_sql = "SELECT COUNT(*) FROM stores";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$perPage = 10;

$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

if ($totalRows > 0) {
  $totalPages = ceil($totalRows / $perPage);

  if ($page > $totalPages) {
    header("Location: ?page=" . $totalPages);
    exit;
  }

  $sql = sprintf("SELECT stores.stores_id, stores.name as 'stores.name', owners.name as 'owners.name', COUNT(rooms_campsites.rooms_campsites_id) as 'space' FROM stores  
  JOIN owners
  ON stores.owners_id = owners.owners_id
  LEFT JOIN rooms_campsites
  ON stores.stores_id = rooms_campsites.stores_id
  GROUP BY stores.stores_id
  ORDER BY stores.stores_id 
  LIMIT %s, %s ", ($page - 1) * $perPage, $perPage);

  $store = $pdo->query($sql)->fetchAll();
}

?>

<?php include __DIR__ . './parts/html-head.php' ?>
<?php include __DIR__ . './parts/navbar.php' ?>

<main class="main-content p-5">
  <div class="d-flex align-items-center">
    <!-- 將h1自帶的margin消除 -->
    <h1 class="m-0"><a href="stores.php" style="text-decoration:none; color:black">Product</a></h1>
    <a class="mx-5 fs-1" href="add_stores.php"><i class="fa-regular fa-square-plus" style="color: #FFD43B;"></i></a>
    <!-- button用div包起來 -->
  </div>

  <hr />

  <!-- 表單 -->
  <div class="table-responsive px-5 text-center">
    <table class="table table-striped table--md">
      <thead>
        <tr class="fs-5">
          <th>刪除鍵</th>
          <th>場地id</th>
          <th>場地名稱</th>
          <th>賣家</th>
          <th>空間數量</th>
          <th>場地內容修改</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($store as $s) : ?>
          <tr>
            <td>
              <a href="javascript: deleteOne(<?= $s['stores_id'] ?>)">
                <i class="fa-solid fa-trash"></i>
              </a>
            </td>
            <td><?= $s['stores_id'] ?></td>
            <td><?= $s['stores.name'] ?></td>
            <td><?= $s['owners.name'] ?></td>
            <td><?= $s['space'] ?></td>
            <td>
              <a href="edit_stores.php?stores_id=<?= $s['stores_id'] ?> ">
                <i class="fa-solid fa-pen-to-square"></i>
              </a>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <div>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=1"><i class="fa-solid fa-angles-left"></i></a>
        </li>
        <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
        </li>

        <?php for ($i = $page - 2; $i <= $page + 2; $i++) :
          if ($i >= 1 and $i <= $totalPages) :
        ?>
            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endif;
        endfor; ?>

        <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $page + 1 ?>"><i class="fa-solid fa-chevron-right"></i></a>
        </li>

        <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $totalPages ?>"><i class="fa-solid fa-angles-right"></i></a>
        </li>
      </ul>
    </nav>
  </div>
</main>
<?php include __DIR__ . './parts/scripts.php' ?>
<script>
  const deleteOne = sid => {

    if (confirm(`是否要刪除${sid}資料?`)) {
      location.href = `stores_delete.php?stores_id=${sid}`;
    }
  }
</script>
<?php include __DIR__ . './parts/html-foot.php' ?>