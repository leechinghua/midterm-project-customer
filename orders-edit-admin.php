<?php

require __DIR__ . "./config/pdo-connect.php";

$title = "訂單編輯";

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

// 最終版
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
room_campsite_id,
total_price,
rooms_campsites.name AS rooms_campsites_name,
normal_price,
store_id,
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

<style>
  .required {
    color: red;
  }
</style>

<main class="main-content p-3">
  <!-- 大標 -->
  <div class="d-flex justify-content-between align-items-center">
    <!-- 將h1自帶的margin消除 -->
    <h1 class="m-0">訂單編輯</h1>
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
  <!-- 表單 -->
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">訂單編輯</h3>
            <form name="form1" onsubmit="sendData(event)">
              <!-- 隱藏欄位，資料跟著表單送出去，但是不要讓用戶看到 -->
              <!-- 訂單id -->
              <input type="hidden" name="id" value="<?= $row5["orders_id"] ?>">

              <!-- 提示用戶 -->
              <div class="mb-3">
                <label for="" class="form-label">會員姓名</label>
                <input type="text" class="form-control" value="<?= $row5["customers_name"] ?>" disabled>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">訂購日期</label>
                <input type="text" class="form-control" value="<?= $row5["order_date"] ?>" disabled>
              </div>

              <div class="mb-3">
                <label for="payment_status" class="form-label"><span class="required">**</span> 訂單狀態</label>
                <select class="form-select" name="payment_status" id="payment_status">
                  <option value="<?php if ($row5["payment_status"] == "已付款") {
                                    echo "已付款";
                                  } else {
                                    echo "未付款";
                                  } ?>" selected><?= $row5["payment_status"] ?></option>

                  <option value="<?php if ($row5["payment_status"] == "未付款") {
                                    echo "已付款";
                                  } else {
                                    echo "未付款";
                                  } ?>"><?php if ($row5["payment_status"] == "已付款") {
                                          echo "未付款";
                                        } else {
                                          echo "已付款";
                                        }
                                        ?></option>
                </select>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">信用卡卡號</label>
                <input type="text" class="form-control" value="<?= $row5["credit_card"] ?>" disabled>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">訂單明細</label>
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>營地名稱</th>
                      <th>房型</th>
                      <th>入住日期</th>
                      <th>退宿日期</th>
                      <th>人數</th>
                      <th>天數</th>
                      <th class="d-none">隱藏計算、送出天數</th>
                      <th>單日價格</th>
                      <th>總價</th>
                      <th class="d-none">總價計算、送出</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?= $row5["stores_name"] ?></td>
                      <!-- 房型 -->
                      <td>
                        <select name="rooms_campsites_name" id="rooms_campsites_name" class="">
                          <?php
                          // 在此迴圈中將房型名稱生成為下拉式選單的選項
                          $selected_room_campsite_id = $row5["room_campsite_id"]; // 獲取當前訂單的房型ID
                          $sql_rooms = "SELECT rooms_campsites_id, name FROM rooms_campsites WHERE stores_id = :store_id"; // 查詢特定營地名稱的房型
                          $stmt_rooms = $pdo->prepare($sql_rooms);
                          $stmt_rooms->execute(array(':store_id' => $row5["store_id"])); // 使用當前訂單的營地ID作為查詢條件
                          while ($room_row = $stmt_rooms->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($selected_room_campsite_id === $room_row['rooms_campsites_id']) ? 'selected' : '';
                            echo "<option value='{$room_row['rooms_campsites_id']}' {$selected}> {$room_row['name']} </option>";
                          }
                          ?>
                        </select>
                      <td><input type="date" name="checkin_date" value="<?= $row5["checkin_date"] ?>"></td>
                      <td><input type="date" name="checkout_date" value="<?= $row5["checkout_date"] ?>"></td>
                      <td><input type="number" name="guests" value="<?= $row5["guests"] ?>"></td>
                      <!-- 天數 顯示用 -->
                      <td id="days"><?= $row5["total_day"] ?></td>
                      <!-- 送出用 -->
                      <td class="d-none">
                        <input type="number" name="total_day" value="<?= $row5["total_day"] ?>">
                      </td>
                      <td id="normal_price"><?= $row5["normal_price"] ?></td>
                      <!-- 總價 顯示用 -->
                      <td id="total_price_cell"><?= $row5["total_price"] ?></td>
                      <td class="d-none">
                        <input type="number" name="total_price" value="<?= $row5["total_price"] ?>"></input>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="mb-3">
                <label for="note" class="form-label">備註</label>
                <textarea class="form-control" id="note" name="note" rows="3"><?= $row5["note"] ?></textarea>
                <div class="form-text"></div>
              </div>

              <button type="submit" class="btn btn-primary">修改</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Modal1 -->
<!-- 提示視窗 lightbox(光箱效果) -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">訂單修改結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          訂單修改成功
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續修改</button> -->
        <a href="orders-edit.php?id=<?= $id ?>" class="btn btn-secondary">繼續修改</a>
        <a href="orders.php" class="btn btn-primary">回到訂單管理頁</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal2 -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel2">資料修改結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" role="alert">
          資料沒有修改
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續修改</button> -->
        <a href="orders-edit.php?id=<?= $id ?>" class="btn btn-secondary">繼續修改</a>
        <a href="list.php" class="btn btn-primary">到列表頁</a>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . "/parts/scripts.php" ?>

<script>
  const sendData = (e) => {
    e.preventDefault();

    const fd = new FormData(document.form1);

    fetch("orders-edit-api.php", {
        method: "POST",
        body: fd
      })
      .then((r) => r.json())
      .then((data) => {
        console.log(data);
        if (data.success) {
          myModal.show();
        } else {
          myModal2.show();
        }
      })
      .catch(ex => {
        console.log("fetch() 發生錯誤，回傳的 JSON 格式是錯的");
        console.log(ex);
      })
  }

  // 計算天數
  function calculateDays() {
    const day1 = new Date(document.form1.checkin_date.value);
    const day2 = new Date(document.form1.checkout_date.value);

    var timeDiff = Math.abs(day2.getTime() - day1.getTime());

    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

    // console.log('兩個日期之間的天數為：', diffDays);

    // input值，設定(會變動)
    document.form1.total_day.value = diffDays + 1;

    const days = document.getElementById("days");
    days.innerHTML = diffDays + 1;
  }
  document.form1.checkin_date.addEventListener('change', calculateDays);
  document.form1.checkout_date.addEventListener('change', calculateDays);

  // 計算總價
  function calculateTotalPrice() {
    const days = parseInt(document.form1.total_day.value);
    const pricePerDay = parseInt(document.getElementById("normal_price").textContent);

    const totalPrice = days * pricePerDay;
    const totalPriceCell = document.querySelector("#total_price_cell");
    totalPriceCell.textContent = totalPrice;

    // input值，設定(會變動)
    document.form1.total_price.value = totalPrice;
  }
  document.form1.checkin_date.addEventListener('change', calculateTotalPrice);
  document.form1.checkout_date.addEventListener('change', calculateTotalPrice);

  const myModal = new bootstrap.Modal('#exampleModal');
  const myModal2 = new bootstrap.Modal('#exampleModal2');
</script>

<?php include __DIR__ . "/parts/html-foot.php" ?>