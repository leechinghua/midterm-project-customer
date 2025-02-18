<?php
require __DIR__ . '/config/pdo-connect.php';

$title = '賣家名單';
// $pageName = 'owners_list';

$t_sql = "SELECT COUNT(*) FROM owners";

$perPage = 10;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if($page < 1){
  header('Location: ?page=1');
  exit;
}


$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages =0;
$rows = [];
if($totalRows>0){
  $totalPages = ceil($totalRows / $perPage);
  if($page > $totalPages){
    header('Location: ?page='. $totalPages);
    exit;
  }

  $sql = sprintf(
    "SELECT * FROM owners ORDER BY owners_id DESC LIMIT %s,%s" ,
    ($page - 1) * $perPage,
    $perPage
  );
  
  $rows = $pdo->query($sql)->fetchAll();
  
}


?>

<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<main class="main-content p-3">

  <div class="d-flex justify-content-between align-items-center ">

    <h1 class="m-0">賣家名單</h1>
    
    <a href="owners-add.php" class="btn btn-primary">新增賣家</a>
    
  </div>
  <hr />


  <div>

    <table class="table table-striped" style="width:100%">
      <thead>
        <tr>
          <th>編號</th>
          <th>姓名</th>
          <th>性別</th>
          <th>電子信箱</th>
          <th>密碼</th>
          <th>生日</th>
          <th>身分證字號</th>
          <th>手機</th>
          <th>地址</th>
          <th>銀行帳戶</th>
          <th>狀態</th>
          <th>建立時間</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r) : ?>
          <tr>
            <td><?= $r['owners_id'] ?></td>
            <td><?= htmlentities($r['name']) ?></td>
            <td><?= $r['gender'] ?></td>
            <td><?= $r['email'] ?></td>
            <td><?= $r['password'] ?></td>
            <td><?= $r['birthday'] ?></td>
            <td><?= $r['id_card'] ?></td>
            <td><?= $r['mobile'] ?></td>
            <td><?= htmlentities($r['address']) ?></td>
            <td><?= $r['bank_account'] ?></td>
            <td><?php if ($r['member_status'] == 1) {
                  echo '使用中';
                } else {
                  echo '封鎖';
                } ?>

            </td>
            <td><?= $r['created_at'] ?></td>
            <td><a href="javascript: deleteOne(<?= $r['owners_id'] ?>)">
            <i class="fa-solid fa-trash-can"></i></a></td>
            <td><a href="owners-edit.php?owners_id=<?= $r['owners_id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
          </tr>
        <?php endforeach ?>
        </tr>
      </tbody>
    </table>

<div>
    <nav aria-label="Page navigation example">
  <ul class="pagination">
  <li class="page-item <?= $page==1 ? 'disabled': '' ?>">
      <a class="page-link" href="?page=1"><i class="fa-solid fa-angles-left"></i></a>
    </li>
  <li class="page-item <?= $page==1 ? 'disabled': '' ?>">
      <a class="page-link" href="?page=<?= $page-1?>"><i class="fa-solid fa-chevron-left"></i></a>
    </li>


    <?php for( $i = $page-2; $i <= $page+2; $i++ ) : 
      if($i >=1 and $i<=$totalPages):
      ?>
    <li class="page-item <?= $page==$i ? 'active': '' ?>">
      <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
    </li>
    <?php endif;endfor; ?>


    
    <li class="page-item <?= $page==$totalPages ? 'disabled': '' ?>">
      <a class="page-link" href="?page=<?= $page+1?>"><i class="fa-solid fa-chevron-right"></i></a>
    </li>

    <li class="page-item <?= $page==$totalPages ? 'disabled': '' ?>">
      <a class="page-link" href="?page=<?= $totalPages ?>"><i class="fa-solid fa-angles-right"></i></a>
    </li>
  </ul>
</nav>
</div>

  </div>
</main>


<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  //假連結alert
  const deleteOne = owners_id =>{
    if(confirm(`是否要刪除編號為${owners_id}的資料`)){
      location.href = `owners-delete.php?owners_id=${owners_id}`
    }
  }
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>