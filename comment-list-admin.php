<?php
# 啟動 session
if (!isset($_SESSION)) {
  # 如果沒有設定 $_SESSION，才啟動
  session_start();
}

require __DIR__ . '/config/pdo-connect.php';

$title = '評論列表';

$searchKeyword = isset($_GET['search']) ? $_GET['search']:'';# 將輸入搜尋欄的關鍵字存入變數


# 設定每頁顯示的筆數
$perPage = 10;

#預設頁數為第一頁
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
# 取得資料總筆數
$t_sql = 'SELECT COUNT(*) FROM comment';#確認資料總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];


if ($totalRows > 0) {  # 如果有資料才去取得分頁資料
  # 總頁數
  $totalPages = ceil($totalRows / $perPage);  # 無條件進位
  if ($page > $totalPages) {
    header("Location: ?page=" . $totalPages);
    exit;
  }

  # 拿到第n頁的資料
  $sql = sprintf("SELECT * FROM comment
  ORDER BY id 
  LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
  $rows = $pdo->query($sql)->fetchAll();
}

// 搜尋功能

$searchCondition = '';
if (!empty($searchKeyword)) {
  $searchCondition = " WHERE comment.comment_content LIKE '%" . $searchKeyword . "%'";
}# 確認是否有搜尋關鍵字，有則加入 SQL 中
?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>


<main class="main-content p-3">
  <!-- 大標 -->

  <div class="d-flex justify-content-between align-items-center">
    <h2>評論列表</h2>
    <!-- <a href="customers-add.php"><button type="button" class="btn btn-primary">新增會員</button></a> -->
    <!-- 搜尋框 -->
    <form class="form-inline" method="GET" action="">
      <input class="form-control mr-sm-2" type="search" placeholder="搜尋會員姓名" aria-label="搜尋" name="search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">搜尋</button>
    </form>
  </div>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>流水號</th>
        <th>會員ID</th>
        <th>商家ID</th>
        <th>comment_star</th>
        <th>發表時間</th>
        <th>留言內容</th>
        <th>編輯</th>
        <th>刪除</th>
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
          <td>
            <a href="comment-edit.php?id=<?= $r['id'] ?>">
              <i class="fa-solid fa-pen-to-square"></i>
            </a>
          </td>
          <td>
            <a href="javascript: deleteOne(<?= $r['id'] ?>)">
              <i class="fa-solid fa-trash"></i>
            </a>
          </td>
        </tr>
      <?php endforeach ?>
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



<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  // 用假連結做刪除功能
  const deleteOne = id => {
    if (confirm(`是否要刪除第 ${id} 筆資料?`)) {
      location.href = `comment-delete.php?id=${id}`;
    }
  }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>