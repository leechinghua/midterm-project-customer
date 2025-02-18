<?php
# 啟動 session
if (!isset($_SESSION)) {
  # 如果沒有設定 $_SESSION，才啟動
  session_start();
}

require __DIR__ . "./config/pdo-connect.php";

$title = "訂單明細";

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if (empty($id)) {
  header("Location: orders.php");
  exit;
}

$sql = "SELECT * FROM orders WHERE id = $id";
$row = $pdo->query($sql)->fetch();

// 如果沒有這個編號的資料，轉向回訂單頁面
if (empty($row)) {
  header("Location: orders.php");
  exit;
}

$sql5 = "SELECT
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
JOIN customers ON orders.customer_id = customers.id
WHERE orders.id = $id";

$row5 = $pdo->query($sql5)->fetch();

?>
<?php include __DIR__ . "/parts/html-head.php" ?>
<?php include __DIR__ . "/parts/navbar.php" ?>

<main class="main-content p-3">
  <!-- 大標 -->
  <div class="d-flex justify-content-between align-items-center">
    <!-- 將h1自帶的margin消除 -->
    <h1 class="m-0">訂單明細</h1>
    <!-- button用div包起來 -->
    <!-- <div>
      <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
        <button type="button" class="btn btn-outline-secondary">
          Share
        </button>
        <button type="button" class="btn btn-outline-secondary">
          Export
        </button>
      </div>
      <div class="btn-group">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-calendar3 me-1"></i>This week
        </button>
      </div>
    </div> -->
  </div>
  <hr />
  <div class="d-flex justify-content-between">
    <h2>訂單明細</h2>
    <div>
      <a href="orders-edit.php?id=<?= $row5["orders_id"] ?>" type="button" class="btn btn-warning">修改</a>
      <!-- 假連結 -->
      <a href="javascript: deleteOrderDetail(<?= $row5["orders_id"] ?>)" type="button" class="btn btn-warning">刪除</a>
    </div>
  </div>
  <!-- 表格 -->
  <table class="table table-bordered table-striped">
    <tbody>
      <tr>
        <td>會員名稱</td>
        <td><?= $row5["customers_name"] ?></td>
      </tr>
      <tr>
        <td>訂購日期</td>
        <td><?= $row5["order_date"] ?></td>
      </tr>
      <tr>
        <td>訂單狀態</td>
        <td><?= $row5["payment_status"] ?></td>
      </tr>
      <tr>
        <td>訂單明細</td>
        <!-- 明細 table -->
        <td>
          <table class="table">
            <thead>
              <tr>
                <th scope="col"></th>
                <th scope="col">營地名稱</th>
                <th scope="col">房型</th>
                <th scope="col">入住日期</th>
                <th scope="col">退宿日期</th>
                <th scope="col">人數</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row"></th>
                <td><?= $row5["stores_name"] ?></td>
                <td><?= $row5["rooms_campsites_name"] ?></td>
                <td><?= $row5["checkin_date"] ?></td>
                <td><?= $row5["checkout_date"] ?></td>
                <td><?= $row5["guests"] ?></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td>訂單總價</td>
        <td><?= $row5["total_price"] ?></td>
      </tr>
      <tr>
        <td>備註</td>
        <td><?= htmlentities($row5["note"]) ?></td>
      </tr>
    </tbody>
  </table>

</main>
<?php include __DIR__ . "/parts/scripts.php" ?>
<script>
  const deleteOrderDetail = (id) => {
    if (confirm(`是否要刪除編號為 ${id} 的訂單?`)) {
      location.href = `orders-delete.php?id=${id}`
    }
  }
</script>
<?php include __DIR__ . "/parts/html-foot.php" ?>