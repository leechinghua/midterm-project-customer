<?php
// require __DIR__ . '/parts/admin-required.php';
require __DIR__ . '/config/pdo-connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

# 判斷是否取得編號
if (empty($id)) {
  header('Location: comment-list.php');
  exit;
}
$sql = "SELECT * FROM comment WHERE id=$id";
$row = $pdo->query($sql)->fetch();

# 如果沒有這個編號的資料, 轉向回列表頁
if (empty($row)) {
  header('Location: comment-list.php');
  exit; # 結束 php 程式
}

/*
header('Content-Type: application/json');
echo json_encode($row);
exit;
*/

// 編輯頁面
$title = '編輯留言內容';
?>

<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
<style>
  .required {
    color: red;
  }

  .container {
    position: relative;
    height: 100vh;
  }

  .row {
    width: 50vw;
    height: 70vh;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    /* Center the form within the container */
  }
</style>
<div class="container">
  <div class="row">
    <div class="card ">
      <div class="card-body">
        <h5 class="card-title">編輯評論內容</h5>
        
        <div class="mb-3">
          <label class="form-label">評論編號</label>
          <input type="int" class="form-control" value="<?= $row["id"] ?>" disabled>
        </div>

        <div class="mb-3">
          <label class="form-label">顧客ID</label>
          <input type="int" class="form-control" value="<?= $row["customer_id"] ?>" disabled>
        </div>

        <div class="mb-3">
          <label class="form-label">商家ID</label>
          <input type="int" class="form-control" value="<?= $row["store_id"] ?>" disabled>
        </div>

        <div class="mb-3">
          <label class="form-label">評論時間</label>
          <input type="int" class="form-control" value="<?= $row["created_at"] ?>" disabled>
        </div>

        <form name="form1" onsubmit="sendData(event)">
          <input type="hidden" name="id" value="<?= $row["id"] ?>">
          <label class="form-label">評論內容</label>
          <textarea class="form-control" id="comment_content" name="comment_content" rows="3"><?= $row['comment_content'] ?></textarea>
          <div class="form-text"></div>
      </div>
      <button type="submit" class="btn btn-primary">編輯</button>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">資料修改結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料修改成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續修改</button>
        <a href="comment-list.php" class="btn btn-primary">到列表頁</a>
      </div>
    </div>
  </div>
</div>

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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續修改</button>
        <a href="comment-list.php" class="btn btn-primary">到列表頁</a>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/scripts.php'
?>
<script>
  const sendData = e => {
    e.preventDefault();

    let isPass = true; // 有沒有通過檢查

    // 欄位資料檢查


    // 如果欄位資料都有通過檢查
    if (isPass) {
      const fd = new FormData(document.form1); // 建立一個只有資料的表單物件

      fetch('comment-edit-api.php', {
          method: 'POST',
          body: fd, // 預設的 Content-Type: multipart/form-data
        })
        .then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModal.show();
          } else {
            myModal2.show();
          }
        }).catch(ex => {
          console.log(`fetch() 發生錯誤, 回傳的 JSON 格式是錯的`);
          console.log(ex);
        })
    }
  }

  const myModal = new bootstrap.Modal('#exampleModal');
  const myModal2 = new bootstrap.Modal('#exampleModal2');
</script>
<?php #include __DIR__ . '/parts/html-foot.php' 
?>