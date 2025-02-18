<?php
require __DIR__ . '/config/pdo-connect.php';
$title = '會員帳號';

$t_sql = "SELECT COUNT(*) FROM customers";

$perPage = 10;

$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

# 取得資料總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];


if ($totalRows > 0) {
  # 如果有資料才去取得分頁資料

  # 總頁數
  # 無條件進位
  $totalPages = ceil($totalRows / $perPage);
  if ($page > $totalPages) {
    header("Location: ?page=" . $totalPages);
    exit;
  }

  # 拿到第n頁的資料
  $sql = sprintf("SELECT*
  FROM
  customers
  ORDER BY id 
  LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

  $rows = $pdo->query($sql)->fetchAll();
}

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<main class="main-content p-3">
  <!-- 大標 -->
  
  <div class="d-flex justify-content-between align-items-center">
    <h2>會員帳號</h2>
    <a href="customers-add.php"><button type="button" class="btn btn-primary">新增會員</button></a>
    
  </div>
  
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>會員編號</th>
        <th>電子郵件（帳號）</th>
        <th>密碼</th>
        <th>姓名</th>
        <th>電話</th>
        <th>性別</th>
        <th>生日</th>
        <th>地址</th>
        <th>自我介紹</th>
        <th>身分證字號</th>
        <th>註冊時間</th>
        <th>刪除</th>
        <th>編輯</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($rows as $r) :
      ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><?= $r['email'] ?></td>
          <td><?= $r['password'] ?></td>
          <td><?= $r['name'] ?></td>
          <td><?= $r['phone'] ?></td>
          <td><?= $r['gender'] ?></td>
          <td><?= $r['birthday'] ?></td>
          <td><?= $r['address']?></td>
          <td><?= $r['introduction'] ?></td>
          <td><?= $r['id_card'] ?></td>
          <td><?= $r['created_at'] ?></td>
          <td>
            <a href="javascript: deleteOne(<?= $r['id'] ?>)"><i class="fa-solid fa-trash-can"></i>
            </a>
          </td>
          <td>
            <a href="customers-edit.php?id=<?= $r['id'] ?>">
              <i class="fa-solid fa-pen-to-square"></i>
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
  const deleteOne = id =>{
    if(confirm(`是否要刪除編號為${id}的會員?`)){
      location.href =`customers-delete.php?id=${id}`
    }
  }

  
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>