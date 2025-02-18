<?php
require __DIR__ . '/config/pdo-connect.php';
// require __DIR__ .'/parts/admin-required.php';
if(! isset($_SESSION)) {
  #如果沒有設定$_SESSION 才啟動
  session_start();

}
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (empty($id)) {
  header('Location: favorite_blog.php');
  exit; # 結束 php 程式, die()
}
$sql = sprintf("SELECT favorite_blog.id, `customer_id`, `blog_id`,blog.title  ,customers.email FROM `favorite_blog` join customers on customer_id=customers.id join blog on blog_id = blog.id where favorite_blog.id=$id ");
$rows = $pdo->query($sql)->fetch();

$selectedValue1 = $rows['customer_id'];
$selectedValue2 = $rows['blog_id'];

$sql1 = "SELECT `id`, `email` FROM `customers`";
$result1 = $pdo->query($sql1);
$numRows1 = $result1->rowCount();


$sql2 = "SELECT `id`, `title` FROM `blog`";
$result2 = $pdo->query($sql2);
$numRows2 = $result2->rowCount();
// $title = '新增通訊錄';
// $pageName = 'ab_add';

?>

<?php include __DIR__. '/parts/html-head.php'?>
<?php include __DIR__. '/parts/navbar.php'?>
<style>
  .required {
    color: red;
  }
  .form-text {
    color: red;
  }
</style>

<main class="main-content p-3">
  <!-- 大標 -->
  <div class="d-flex justify-content-between align-items-center">
    <!-- 將h1自帶的margin消除 -->
    <h1 class="m-0">最愛推廣文表單管理</h1>
    <!-- button用div包起來 -->
    <div>
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
    </div>
  </div>
  <hr />
  <h2>編輯最愛推廣文<?=$id?></h2>
  <!-- 表格 -->
  <div class="row">
    
  </div>
  <div class="col-6">
      <div class="card" >
        
        <div class="card-body">
          <h5 class="card-title">修改資料</h5>
          <form name="form1" onsubmit="sendData(event)" enctype="application/x-www-form-urlencoded">
          <div class="mb-3">
    <label for="id" class="form-label"> 編號</label>
    <input type="text" class="form-control" id="id" name="" value="<?= $rows['id'] ?>" disabled>
    
        </div>

  <div class="mb-3">
    <label for="customerId" class="form-label">消費者email</label>
   
    <select name="customerId" id="customerId" class="form-select" >
   
    
   <?php
   
   // 將資料庫中的資料用於生成選項
   if ($numRows1 > 0) {
       while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
           echo "<option value='" . $row1["id"] . "'" .($selectedValue1 == $row1["id"]  ? 'selected' : '') .">" .$row1["id"].":". $row1["email"] . "</option>";
       }
   }
   ?>
</select>
    <div class="form-text"></div>
        </div>
  <div class="mb-3">
    <label for="blogId" class="form-label">部落格標題</label>
    
    <select name="blogId" id="blogId" class="form-select">
   
    
    <?php
    
    // 將資料庫中的資料用於生成選項
    if ($numRows2 > 0) {
        while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row2["id"] . "'".($selectedValue2 == $row2["id"]  ? 'selected' : '') .">" . $row2["title"] . "</option>";
        }
    }
    ?>
</select>
    
    <div class="form-text"></div>
        </div>
        <input type="hidden" name="id" value="<?= $rows['id'] ?>">
  
        <button type="submit" class="btn btn-primary">新增</button>
</form>
      </div>
    </div>
  </div>
</main>



<!-- <div class="container margin-top:150px"  >
  <div class="row">
    <div class="col-6">
      <div class="card" >
        
        <div class="card-body">
          <h5 class="card-title">新增資料</h5>
          <form name="form1" onsubmit="sendData(event)" enctype="application/x-www-form-urlencoded">
  
  <div class="mb-3">
    <label for="title" class="form-label"><span class="required">**</span> 標題</label>
    <input type="text" class="form-control" id="title" name="title">
    <div class="form-text"></div>
        </div>
  <div class="mb-3">
    <label for="author" class="form-label">作者</label>
    <input type="text" class="form-control" id="author" name="author">
    <div class="form-text"></div>
        </div>
  <div class="mb-3">
    <label for="tag" class="form-label">標籤</label>
    <input type="text" class="form-control" id="tag" name="tag">
    <div class="form-text"></div>
        </div>
 
  <div class="mb-3">
    <label for="content" class="form-label">內容</label>
    <textarea class="form-control" id="content" name="content" rows="10"></textarea>
    <div class="form-text"></div>
        </div>
        <div class="mb-3">
    <label for="datetime" class="form-label">修改時間(不填就是預設時間)</label>
    <input type="datetime-local" class="form-control" id="datetime" name="datetime" step="1">
    <div class="form-text"></div>
        </div>
        <button type="submit" class="btn btn-primary">新增</button>
</form>
      </div>
    </div>
  </div>
</div> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">資料編輯結果</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="alert alert-success" role="alert">
  資料編輯成功
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
        <a href="favorite_blog.php" class="btn btn-primary">到favorite_blog列表頁</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">資料編輯結果</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="alert alert-danger" role="alert">
  資料編輯失敗,最愛部落格不能重複添加
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
        <a href="favorite_blog.php" class="btn btn-primary">到favorite_blog列表頁</a>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__. '/parts/scripts.php'?>
<!-- 可以用到jquery的功能 -->
<script>
//   function validateEmail(email) {
// var re =
// /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
// return re.test(email);
//   }

  const customerIdField =document.form1.customerId;
  const blogIdField =document.form1.blogId;
 
const sendData= e =>{
e.preventDefault()

//回覆沒有提示的狀態
customerIdField.style.border ='1px solid #CCCCCC';
  customerIdField.nextElementSibling.innerHTML=''
  blogIdField.style.border ='1px solid #CCCCCC';
  blogIdField.nextElementSibling.innerHTML='';
 

let isPass = true; //有沒有通過檢查

// TODO 要做欄位資料檢查

if(customerIdField.value.length < 1){
  isPass =false
  // 跳提示用戶
  customerIdField.style.border ='1px solid red';
  customerIdField.nextElementSibling.innerHTML='消費者編號至少要一個字元'
  
}
if(blogIdField.value.length < 1){
  isPass =false
  // 跳提示用戶
  blogIdField.style.border ='1px solid red';
  blogIdField.nextElementSibling.innerHTML='作者至少要一個字元'
  
}


// if(!validateEmail(emailField.value)){
//   isPass =false
//   // 跳提示用戶
//   emailField.style.border ='1px solid red';
//   emailField.nextElementSibling.innerHTML='請填寫正確的email';
 
// }

//如果每個欄位都有通過檢查
if(isPass){
  
  const fd = new FormData(document.form1) //建立一個只有資料沒有外觀的表單
  
  fetch('edit-favorite_blog-api.php',{
    method: 'POST',
    body: fd, //Content-type: multipart/form-data
  })
  .then(r =>r.json())
  .then(data =>{
    console.log(data);
    if(data.success){
      myModal.show();
    }else{
      console.log(`資料新增錯誤`);
      myModal2.show();
    }
  }).catch(ex =>{console.log(`fetch()發生錯誤,回傳的JSON 格式是錯的`);console.log(ex);}) 
}

}
const myModal = new bootstrap.Modal("#exampleModal");
const myModal2 = new bootstrap.Modal("#exampleModal2");
</script>
<?php include __DIR__. '/parts/html-foot.php'?>