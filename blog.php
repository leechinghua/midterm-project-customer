<?php
require __DIR__ . '/config/pdo-connect.php';

$t_sql = "SELECT COUNT(*) FROM blog";

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

  $sql = sprintf("SELECT b.id, b.title, b.author, b.blog_tag, b.content, b.create_at, COUNT(fb.blog_id) AS favorite_count FROM blog b LEFT JOIN favorite_blog fb ON b.id = fb.blog_id GROUP BY b.id, b.title ORDER BY b.id DESC limit %s, %s", ($page - 1) * $perPage, $perPage);
  $rows = $pdo->query($sql)->fetchALL();
}


?>
<?php include __DIR__. '/parts/html-head.php'?>
<?php include __DIR__. '/parts/navbar.php'?>
<style>
    table{
        /* table-layout: fixed;
        width: 100%; */
    }
    .line-clamp{
        /* table-layout: fixed;
/* -webkit-line-clamp: 4; 
-webkit-box-orient: vertical;  
overflow: hidden;
text-overflow: ellipsis; */

    }
</style>
<main class="main-content p-3">
  <!-- 大標 -->
  <div class="d-flex justify-content-between align-items-center ">
    <!-- 將h1自帶的margin消除 -->
    <h1 class="m-0 ">推廣文表單管理</h1>
    <!-- button用div包起來 -->
    <div>
      <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
        <button type="button" class="btn btn-outline-secondary">
        <a href="./add-blog.php"><i class="bi bi-calendar3 me-1"></i>新增blog</a>
        </button>
        <button type="button" class="btn btn-outline-secondary">
          Export
        </button>
      </div>
      <div class="btn-group">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          
          
        </button>
      </div>
    </div>
  </div>
  <hr />
  <h2>推廣文列表</h2>
  <!-- 表格 -->
  <div class="row">
    <div class="col">
      <table class="table table-bordered table-striped">
      <thead>
        <tr>
        <th><i class="fa-solid fa-trash-can"></i></th>
            <th>id</th>
            <th>標題</th>
            <th>作者</th>
            <th>標籤</th>
            <th >內容</th>
            <th>修改日期</th>
            <th>收藏數</th>

            <th>編輯</th>
            
        </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
        <td><a href="javascript: deleteOne(<?= $r['id']?>)"><i class="fa-solid fa-trash-can"></i></a></td>
            <td><?= $r['id']?></td>  
            <td><?= htmlentities($r['title'])?></td>  
            <td><?= htmlentities($r['author'])?></td>  
            <td><?= htmlentities($r['blog_tag'])?></td>  
            <td class="line-clamp"><?= htmlentities($r['content'])?></td>    
            <td><?= htmlentities($r['create_at'])?></td>    
            <td><?= $r['favorite_count']?></td>    
            <td><a href="edit-blog.php?id=<?=$r['id']?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
        </tr>
        <?php endforeach  ?>
     
    </tbody>
      </table>
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
    </div>
  </div>

</main>


<!-- <div class="div" style=" background-color: pink; margin-left: 300px;margin-top:150px " >
    <table id="myTable" class="display"  >
    <thead>
        <tr>
        <th><i class="fa-solid fa-trash-can"></i></th>
            <th>id</th>
            <th>標題</th>
            <th>作者</th>
            <th>標籤</th>
            <th >內容</th>
            <th>修改日期</th>
            <th>編輯</th>
            
        </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
        <td><a href="javascript: deleteOne(<?= $r['id']?>)"><i class="fa-solid fa-trash-can"></i></a></td>
            <td><?= $r['id']?></td>  
            <td><?= $r['title']?></td>  
            <td><?= $r['author']?></td>  
            <td><?= $r['blog_tag']?></td>  
            <td class="line-clamp"><?= $r['content']?></td>    
            <td><?= $r['create_at']?></td>    
            <td><a href="edit-blog.php?id=<?=$r['id']?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
        </tr>
        <?php endforeach  ?>
     
    </tbody>
</table>
  </div> -->
  <?php include __DIR__. '/parts/scripts.php'?>
  <script>
  const deleteOne = id =>{
    if(confirm(`是否要刪除編號為 ${id} 的資料?`)){
      location.href =`delete-blog.php?id=${id}`;
    }
  }
</script>
<?php include __DIR__. '/parts/html-foot.php'?>