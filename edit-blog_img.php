<?php
# 啟動 session
if (!isset($_SESSION)) {
  # 如果沒有設定 $_SESSION，才啟動
  session_start();
}
require __DIR__ . '/config/pdo-connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (empty($id)) {
  header('Location: favorite_blog.php');
  exit; # 結束 php 程式, die()
}

$sql = sprintf("SELECT blog_img.id, `img_name`, `blog_id`, blog.title FROM `blog_img` JOIN blog on blog_id = blog.id where blog_img.id =$id ");
$rows = $pdo->query($sql)->fetch();


$sql2 = "SELECT `id`, `title` FROM `blog`";
$result2 = $pdo->query($sql2);
$numRows2 = $result2->rowCount();
$selectedValue2 = $rows['blog_id'];
?>
<?php include __DIR__ . "/parts/html-head.php" ?>
<?php include __DIR__ . "/parts/navbar.php" ?>
<style>
    .card{
      display: inline-block;
      width: 300px;
      padding: 5px;
      border: 1px solid blue;
      border-radius: 5px;

    }
    .card img{
      width: 100%;
    }
  </style>

<main class="main-content p-3">
  <!-- 大標 -->
  <div class="d-flex justify-content-between align-items-center">
    <!-- 將h1自帶的margin消除 -->
    <h1 class="m-0">推廣文圖片管理</h1>
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
  <h2>推廣文圖片編輯<?=$id?></h2>
  <!-- 表格 -->
  <div class="row">
    <div class="col-6">
  <form name="form1" onsubmit="sendData(event)">
  <div class="mb-3">
    <label for="id" class="form-label"> 編號</label>
    <input type="text" class="form-control" id="id" name="" value="<?= $rows['id'] ?>" disabled>
    
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
<br>
<button type="button" onclick="photosField .click()">上傳多張圖</button>
<br>
<input  name="filenames" value="<?= empty($rows['img_name']) ? '[]' :htmlentities(json_encode($rows['img_name']))?>" data-info="圖檔的名稱" style="width: 100%;" >
<div class="row">
                <div style="display: flex; flex-wrap: wrap;" id="photo_container">
                  <?php /*
                  <?php foreach ($row['photos'] as $p) : ?>
                    <div class="my-card">
                      <img src="./../uploads/<?= $p ?>" alt="">
                    </div>
                  <?php endforeach; ?>
                  */ ?>
                </div>
              </div>
              <input type="hidden" name="id" value="<?= $rows['id'] ?>">
<button type="submit" class="btn btn-primary">編輯</button>
 </form>
 </div>

 <!-- 上傳圖檔的表單 -->
  <form name="upload_form1" hidden>

    
  
    <input type="file" name="photos[]" multiple accept="image/*">
   
  </form>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">資料編輯結果</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="alert alert-success" role="alert">
      編輯新增成功
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
        <a href="blog_img.php" class="btn btn-primary">到blog_img列表頁</a>
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
  資料編輯失敗,部落格標題不能重複,或是資料沒有變動，請上傳至少一張圖片
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續編輯</button>
        <a href="blog_img.php" class="btn btn-primary">到favorite_blog列表頁</a>
      </div>
    </div>
  </div>

</main>
 
<?php include __DIR__ . "/parts/scripts.php" ?>
<script>
  
  const row = <?= json_encode($rows) ?>;
  let photos = JSON.parse(row.img_name);
const photosField  =document.upload_form1.elements[0]; //欄位的參照
const photoTpl = (f) => `
  <div class="card">
    <img src="./uploads/blog_img/${f}" alt="">
  </div>
  `;
 


  const genPhotos = () => {
    let str = '';
    for (let p of photos) {
      str += photoTpl(p);
    }
    photo_container.innerHTML = str;

  };
  genPhotos();
  

  photosField .addEventListener("change", (event) =>{
      const fd = new FormData(document.upload_form1);
      fetch('blog_img-multiple-uploads.php',{
        method: 'post',
        body: fd,
      }).then((r) =>r.json())
      .then((result) =>{
        // if(result.files && result.files.length){
          
        // }
        // 有或沒有 ?
        if (result.files?.length) {
          photos = [...photos, ...result.files];
          document.form1.filenames.value =JSON.stringify(photos);
          genPhotos();
        }
      })

    })

    const sendData= e =>{
      e.preventDefault()


 

let isPass = true; //有沒有通過檢查


if(isPass){
  document.form1.filenames.value =JSON.stringify(photos);
  const fd = new FormData(document.form1) //建立一個只有資料沒有外觀的表單
  
  fetch('edit-blog_img-api.php',{
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
};

const myModal = new bootstrap.Modal("#exampleModal");
const myModal2 = new bootstrap.Modal("#exampleModal2");

  </script>
<?php include __DIR__ . "/parts/html-foot.php" ?>
