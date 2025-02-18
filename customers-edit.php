<?php
require __DIR__ . "/config/pdo-connect.php";

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if (empty($id)) {
  header('Location: customers.php');
  exit;
}
$sql = "SELECT * FROM `customers` WHERE `id`=$id";
$row = $pdo->query($sql)->fetch();

if (empty($row)) {
  header('Location: customers.php');
  exit;
}

?>

<?php

$title = '修改會員資料';
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
  <h2>會員資料</h2>
  <div class="card" style="width: 50%;">
    <div class="card-body">
      <h5 class="card-title">修改會員資料</h5>
      <form name="form1" onsubmit="sendData(event)" enctype="application/x-www-form-urlencoded">
        <div class="mb-3">
          <label for="email" class="form-label">電子郵件(帳號)</label>
          <input type="text" class="form-control" id="email" name="email" value="<?= $row['email'] ?>" disabled>
          <div class="form-text"></div>
        </div>
        <div class="mb-3">
          <label for="name" class="form-label">姓名</label>
          <input type="text" class="form-control" id="name" name="name" value="<?= $row['name'] ?>">
          <div class="form-text"></div>
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">電話</label>
          <input type="tel" class="form-control" id="phone" name="phone" value="<?= $row['phone'] ?>">
          <div class="form-text"></div>
        </div>
        <div class="mb-3">
          <label for="gender" class="form-label">性別
          </label>
          <select name="gender" id="gender">
            <option value="male" <?= ($row['gender'] == 'male') ? 'selected' : '' ?>>男性</option>
            <option value="female" <?= ($row['gender'] == 'female') ? 'selected' : '' ?>>女性</option>
            <option value="other" <?= ($row['gender'] == 'other') ? 'selected' : '' ?>>其他</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="birthday" class="form-label">生日</label>
          <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $row['birthday'] ?>">
          <div class="form-text"></div>
        </div>
        <div class="mb-3">
          <label for="address" class="form-label">地址</label>
          <input type="text" class="form-control" id="address" name="address" value="<?= $row['address'] ?>">
        </div>
        <div class="mb-3">
          <label for="introduction" class="form-label">自我介紹</label>
          <textarea name="introduction" id="introduction" class="form-control" rows="4" cols="50"><?= $row['introduction'] ?></textarea>
        </div>
        <div class="mb-3">
          <label for="id_card" class="form-label">身分證字號</label>
          <input type="text" class="form-control" id="id_card" name="id_card" value="<?= $row['id_card'] ?>">
          <div class="form-text"></div>
        </div>
        <input type="hidden" class="form-control" id="id" name="id" value="<?= $row['id'] ?>">
        <button type="submit" class="btn btn-primary">修改</button>
      </form>
    </div>
  </div>
</main>
<!--Modal-->


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
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button> -->
        <a href="customers.php" class="btn btn-primary">到列表頁</a>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const nameField = document.form1.name;
  const phoneField = document.form1.phone;
  const idCardField = document.form1.id_card;

  function validatePhoneNumber(phoneNumber) {
    // 如果電話號碼為空值，直接通過驗證
    if (phoneNumber.trim() === '') {
      return true;
    }
    var phonePattern = /^\d{10}$/;
    return phonePattern.test(phoneNumber);
  }

  // function validateTWID(id) {
  //   const pattern = /^[A-Z][1-2]\d{8}$/;
  //   const letters = 'ABCDEFGHJKLMNPQRSTUVXYWZIO';
  //   if (!pattern.test(id)) return false;
  //   const letterIndex = letters.indexOf(id.charAt(0)) + 10;
  //   const sum = Math.floor(letterIndex / 10) + letterIndex % 10 * 9;
  //   for (let i = 1; i < 9; i++) {
  //     sum += parseInt(id.charAt(i)) * (9 - i);
  //   }
  //   return sum % 10 === 0;
  // }

  //建立一個只有資料的表單物件
  const sendData = e => {
    e.preventDefault();
    nameField.style.border = '1px solid #cccccc';
    nameField.nextElementSibling.innerHTML = '';
    phoneField.style.border = '1px solid #cccccc';
    phoneField.nextElementSibling.innerHTML = '';
    // TODO: 要做欄位資料檢查
    let isPass = true;
    if (nameField.value.trim() !== '' && nameField.value.trim().length < 2) {
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerHTML = '姓名長度需至少2個字';
      isPass = false;
    }

    if (phoneField.value.trim() !== '' && !validatePhoneNumber(phoneField.value.trim())) {
      phoneField.style.border = '1px solid red';
      phoneField.nextElementSibling.innerHTML = '請輸入有效的10位數字電話號碼';
      isPass = false;
    }

    // if (idCardField.value.trim() !== '' && !validateTWID(idCardField.value.trim())) {
    //   idCardField.style.border = '1px solid red';
    //   idCardField.nextElementSibling.innerHTML = '請輸入有效的台灣身分證字號';
    //   isPass = false;
    // } else {
    //   idCardField.style.border = '1px solid #cccccc';
    //   idCardField.nextElementSibling.innerHTML = '';
    // }


    if (isPass) {
      const fd = new FormData(document.form1);
      fetch('customers-edit-api.php', {
          method: 'POST',
          body: fd,
        })
        .then(r => r.json())
        .then(data => {
          console.log(data);
          if (data.success) {
            myModal.show();
          } else {
            console.log(`資料修改失敗`);
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