<?php
require __DIR__ . '/config/pdo-connect.php';
// require __DIR__ .'/parts/admin-required.php';
if(! isset($_SESSION)) {
  #如果沒有設定$_SESSION 才啟動
  session_start();

}
// $title = '新增通訊錄';
// $pageName = 'ab_add';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (empty($id)) {
  header('Location: blog.php');
  exit; # 結束 php 程式, die()
}

$sql = "SELECT * FROM blog WHERE id=$id";
$row = $pdo->query($sql)->fetch();
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
    <h1 class="m-0">推廣文表單管理</h1>
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
  <h2>編輯推廣文<?=$id?></h2>
  <!-- 表格 -->
  <div class="row">
  <div class="col-6">
      <div class="card" >
        
        <div class="card-body">
          <h5 class="card-title">編輯資料</h5>
          <form name="form1" onsubmit="sendData(event)" >
  
  <div class="mb-3">
    <label for="id" class="form-label"> 編號</label>
    <input type="text" class="form-control" id="id" name="" value="<?= $row['id'] ?>" disabled>
    
        </div>
  <div class="mb-3">
    <label for="title" class="form-label"><span class="required">**</span> 標題</label>
    <input type="text" class="form-control" id="title" name="title" value="<?= $row['title'] ?>">
    <div class="form-text"></div>
        </div>
  <div class="mb-3">
    <label for="author" class="form-label">作者</label>
    <input type="text" class="form-control" id="author" name="author" value="<?= $row['author'] ?>">
    <div class="form-text"></div>
        </div>
  <div class="mb-3">
    <label for="tag" class="form-label">標籤</label>
    <input type="text" class="form-control" id="tag" name="tag" value="<?= $row['blog_tag'] ?>">
    <div class="form-text"></div>
        </div>
 
  <div class="mb-3">
    <label for="content" class="form-label">內容</label>
    <textarea class="form-control" id="content" name="content" rows="20" ><?= $row['content'] ?></textarea>
    <div class="form-text"></div>
        </div>
        <div class="mb-3">
    <label for="datetime" class="form-label">修改時間(不填就是預設時間)</label>
    <input type="datetime-local" class="form-control" id="datetime" name="datetime" step="1" value="<?= $row['create_at'] ?>">
    <div class="form-text"></div>
        </div>
        <button type="submit" class="btn btn-primary">新增</button>
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
</form>
      </div>
    </div>
  </div>
  </div>
 
</main>




<!-- <div class="container margin-top:150px"  >
  <div class="row">
    <div class="col-6">
      <div class="card" >
        
        <div class="card-body">
          <h5 class="card-title">編輯資料</h5>
          <form name="form1" onsubmit="sendData(event)" >
  
  <div class="mb-3">
    <label for="id" class="form-label"> 編號</label>
    <input type="text" class="form-control" id="id" name="" value="<?= $row['id'] ?>" disabled>
    
        </div>
  <div class="mb-3">
    <label for="title" class="form-label"><span class="required">**</span> 標題</label>
    <input type="text" class="form-control" id="title" name="title" value="<?= $row['title'] ?>">
    <div class="form-text"></div>
        </div>
  <div class="mb-3">
    <label for="author" class="form-label">作者</label>
    <input type="text" class="form-control" id="author" name="author" value="<?= $row['author'] ?>">
    <div class="form-text"></div>
        </div>
  <div class="mb-3">
    <label for="tag" class="form-label">標籤</label>
    <input type="text" class="form-control" id="tag" name="tag" value="<?= $row['blog_tag'] ?>">
    <div class="form-text"></div>
        </div>
 
  <div class="mb-3">
    <label for="content" class="form-label">內容</label>
    <textarea class="form-control" id="content" name="content" rows="20" ><?= $row['content'] ?></textarea>
    <div class="form-text"></div>
        </div>
        <div class="mb-3">
    <label for="datetime" class="form-label">修改時間(不填就是預設時間)</label>
    <input type="datetime-local" class="form-control" id="datetime" name="datetime" step="1" value="<?= $row['create_at'] ?>">
    <div class="form-text"></div>
        </div>
        <button type="submit" class="btn btn-primary">新增</button>
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
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
        <h5 class="modal-title" id="exampleModalLabel">資料新增結果</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="alert alert-success" role="alert">
  資料新增成功
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
        <a href="blog.php" class="btn btn-primary">到blog列表頁</a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">資料新增結果</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="alert alert-danger" role="alert">
  資料新增失敗,可能是id遺失或是資料沒有變動
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
        <a href="blog.php" class="btn btn-primary">到blog列表頁</a>
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

  const titleField =document.form1.title;
  const authorField =document.form1.author;
  const tagField =document.form1.tag;
  const contentField =document.form1.content;
const sendData= e =>{
e.preventDefault();

//回覆沒有提示的狀態
titleField.style.border ='1px solid #CCCCCC';
  titleField.nextElementSibling.innerHTML='';
  authorField.style.border ='1px solid #CCCCCC';
  authorField.nextElementSibling.innerHTML='';
  tagField.style.border ='1px solid #CCCCCC';
  tagField.nextElementSibling.innerHTML='';
  contentField.style.border ='1px solid #CCCCCC';
  contentField.nextElementSibling.innerHTML='';

let isPass = true; //有沒有通過檢查

// TODO 要做欄位資料檢查

if(titleField.value.length < 1){
  isPass =false
  // 跳提示用戶
  titleField.style.border ='1px solid red';
  titleField.nextElementSibling.innerHTML='標題至少要一個字元'
  
}
if(authorField.value.length < 1){
  isPass =false
  // 跳提示用戶
  authorField.style.border ='1px solid red';
  authorField.nextElementSibling.innerHTML='作者至少要一個字元'
  
}
if(tagField.value.length < 1){
  isPass =false
  // 跳提示用戶
  tagField.style.border ='1px solid red';
  tagField.nextElementSibling.innerHTML='標籤至少要一個字元'
  
}
if(contentField.value.length < 1){
  isPass =false
  // 跳提示用戶
  contentField.style.border ='1px solid red';
  contentField.nextElementSibling.innerHTML='內容至少要一個字元'
  
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
  
  fetch('edit-blog-api.php',{
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
  }).catch( ex =>{console.log(`fetch()發生錯誤,回傳的JSON 格式是錯的`);console.log(ex);})
}

}
const myModal = new bootstrap.Modal("#exampleModal");
const myModal2 = new bootstrap.Modal("#exampleModal2");
</script>
<?php include __DIR__. '/parts/html-foot.php'?>