<?php

$title = '新增會員帳號';
?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<?php include __DIR__ . '/parts/navbar.php' ?>
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
  <h2>會員帳號</h2>
  <div class="card" style="width: 50%;">
    <div class="card-body">
      <h5 class="card-title">新增會員帳號</h5>
      <form name="form1" onsubmit="sendData(event)" method="post" enctype="application/x-www-form-urlencoded">
        <div class="mb-3">
          <label for="email" class="form-label"><span class="required">**</span>電子郵件(帳號)</label>
          <input type="text" class="form-control" id="email" name="email">
          <div class="form-text"></div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label"><span class="required">**</span>密碼</label>
          <input type="password" class="form-control" id="password" name="password">
          <div class="form-text"></div>
        </div>
        <button type="submit" class="btn btn-primary">新增</button>
      </form>
    </div>
  </div>
</main>
<!--Modal-->


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">帳號新增結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          帳號新增成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
        <a href="customers.php" class="btn btn-primary">到列表頁</a>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const emailField = document.form1.email;
  const passwordField = document.form1.password;

  function validateEmail(email) {
    var re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  };
  const sendData = e => {
    e.preventDefault();

    emailField.style.border = '1px solid #cccccc';
    emailField.nextElementSibling.innerHTML = '';
    passwordField.style.border = '1px solid #cccccc';
    passwordField.nextElementSibling.innerHTML = '';
    // TODO: 要做欄位資料檢查
    let isPass = true;

    if (!validateEmail(emailField.value)) {
      isPass = false;
      emailField.style.border = '1px solid red';
      emailField.nextElementSibling.innerHTML = '請填寫正確的信箱';
    } else {
      emailField.style.border = '1px solid #cccccc';
      emailField.nextElementSibling.innerHTML = '';
    }

    if (passwordField.value.length < 6 || passwordField.value.length > 10) {
      isPass = false;
      passwordField.style.border = '1px solid red';
      passwordField.nextElementSibling.innerHTML = '請填寫6~10位密碼';
    }

    if (isPass) {
      const fd = new FormData(document.form1); //建立一個只有資料的表單物件
      fetch('customers-add-api.php', {
          method: 'POST',
          body: fd,
        })
        .then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModal.show();
          } else {
            console.log(`帳號新增失敗`);
          }
        }).catch(ex => {
          console.log(`fetch() 發生錯誤, 回傳的JSON格式是錯的`);
          console.log(ex);
        })
    }
  }
  const myModal = new bootstrap.Modal('#exampleModal');
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>