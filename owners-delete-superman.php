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
    "SELECT * FROM owners ORDER BY owners_id LIMIT %s,%s",
    ($page - 1) * $perPage,
    $perPage
  );
  
  $rows = $pdo->query($sql)->fetchAll();
  
}


?>

<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<style>
  .picture{
    position: relative;
    img{
      position: absolute; 
    }
  }
  .loginbtn{
    position: absolute;
    z-index: 1  ;
    top: 180px;
    left: 170px;
    font-weight: 900;
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background-color: red;
    color: white;
    text-align: center;
    line-height: 55px;
    font-size: 20px;
    box-shadow:-5px 5px 5px black;
  }
  .loginbtn:hover{
    background-color: red;
    color: white;
  }
</style>
<main class="main-content p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">還敢刪資料阿?</h1>
  </div>
  <hr />
  <div class="picture">
    <img src="images/login.png" alt="" >
    <a href="login.php" class="btn  loginbtn ">登入</a>
    </div>
</main>


<?php include __DIR__ . '/parts/scripts.php' ?>
<?php include __DIR__ . '/parts/html-foot.php' ?>