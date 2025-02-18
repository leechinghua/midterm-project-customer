<?php
# 啟動 session
if (!isset($_SESSION)) {
  # 如果沒有設定 $_SESSION，才啟動
  session_start();
}

require __DIR__ . "./config/pdo-connect.php";

$title = "訂單管理";

# 搜尋功能
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

# 設定每頁顯示的筆數
$perPage = 10;

# 預設頁數為第一頁
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

# 確認是否有搜尋關鍵字，有則加入 SQL 中
$searchCondition = '';
if (!empty($searchKeyword)) {
  $searchCondition = " WHERE customers.name LIKE '%" . $searchKeyword . "%'";
}

# 取得符合條件的資料總筆數
$t_sql = "SELECT COUNT(*) FROM orders 
          JOIN customers ON orders.customer_id = customers.id".$searchCondition;
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

if ($totalRows > 0) {
  # 如果有資料才去取得分頁資料

  # 總頁數
  $totalPages = ceil($totalRows / $perPage);
  if ($page > $totalPages) {
    header("Location: ?page=" . $totalPages);
    exit;
  }

  # 拿到第n頁的資料
  $sql = "SELECT
  orders.id AS orders_id,
  order_date,
  payment_status,
  credit_card,
  note,
  checkin_date,
  checkout_date,
  guests,
  total_day,
  total_price,
  rooms_campsites.name AS rooms_campsites_name,
  normal_price,
  stores.name AS stores_name,
  customers.name AS customers_name
FROM
  orders
JOIN rooms_campsites ON orders.room_campsite_id = rooms_campsites.rooms_campsites_id
JOIN stores ON orders.store_id = stores.stores_id
JOIN customers ON orders.customer_id = customers.id" . $searchCondition . "
ORDER BY
  orders_id 
  LIMIT " . ($page - 1) * $perPage . ", " . $perPage;

  $rows5 = $pdo->query($sql)->fetchAll();
}

?>
<?php include __DIR__ . "/parts/html-head.php" ?>
<?php include __DIR__ . "/parts/navbar.php" ?>

<main class="main-content p-3">
  <!-- 大標 -->
  <div class="d-flex justify-content-between align-items-center">
    <!-- 將h1自帶的margin消除 -->
    <h1 class="m-0">訂單管理</h1>
    <!-- 搜尋框 -->
    <form class="form-inline" method="GET" action="">
      <input class="form-control mr-sm-2" type="search" placeholder="搜尋會員姓名" aria-label="搜尋" name="search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜尋</button>
    </form>
  </div>
  <hr />
  <!-- 表格 -->
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>訂購日期</th>
        <th>會員名稱</th>
        <th>訂單狀態</th>
        <th>訂單總價</th>
        <th>備註</th>
        <th><i class="fa-solid fa-pen-to-square"></i></th>
        <th><i class="fa-solid fa-trash"></i></th>
        <th>訂單明細</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows5 as $r5) : ?>
        <tr>
          <td><?= $r5["orders_id"] ?></td>
          <td><?= $r5["order_date"] ?></td>
          <td><?= $r5["customers_name"] ?></td>
          <td><?= $r5["payment_status"] ?></td>
          <td><?= $r5["total_price"] ?></td>
          <td><?= htmlentities($r5["note"]) ?></td>
          <td>
            <a href="orders-edit.php?id=<?= $r5["orders_id"] ?>">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>
          </td>
          <td>
            <!-- 假連結 -->
            <a href="javascript: deleteOrder(<?= $r5["orders_id"] ?>)">
              <i class="fa-solid fa-trash"></i>
            </a>
          </td>
          <td><a href="orders-detail.php?id=<?= $r5["orders_id"] ?>" type="button" class="btn btn-primary">訂單明細</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- 分頁按鈕 -->
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
<?php include __DIR__ . "/parts/scripts.php" ?>
<script>
  const deleteOrder = (id) => {
    if (confirm(`是否要刪除編號為 ${id} 的訂單?`)) {
      location.href = `orders-delete.php?id=${id}`
    }
  }
</script>
<?php include __DIR__ . "/parts/html-foot.php" ?>
