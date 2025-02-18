<?php
if (!isset($_SESSION)) {
  # 如果沒有設定 $_SESSION，才啟動
  session_start();
}
$title = '新增資料';
$pageName = 'owners_add_list';
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

  .card{
    width: 60%;
    margin: 30px 0 0 15px;
  }


  /* 必填要設定 */
</style>
<main class="main-content p-3">
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">新增資料</h1>
    
  </div>
  <hr />



  <div class="card">
    <div class="card-body">
      <!-- <h5 class="card-title">新增資料</h5> -->
      <form name="owners_add_form" onsubmit="sendData(event)">
        <!-- 是否要大頭照-->
        <!-- <div class="mb-3">
          <label for="account" class="form-label">
            <span class="required">**</span>帳號</label>
          <input type="text" class="form-control" id="account" name="account">
          <div class="form-text"></div>
        </div> -->
<div class="row">
        <div class="mb-3 col">
          <label for="email" class="form-label"><span class="required">**</span>帳號(email)</label>
          <input type="text" class="form-control" id="email" name="email" placeholder="請輸入帳號(email)">
          <div class="form-text"></div>
        </div>
        </div>
        <div class="row">
        <div class="mb-3 col">
          <label for="password" class="form-label"><span class="required">**</span>密碼</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="請輸入6-12 個字元、含大小寫字母、至少一個數字">
          <div class="form-text"></div>
        </div>
        </div>
        <div class="row">
        <div class="mb-3 col">
          <label for="name" class="form-label"><span class="required">**</span>姓名</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="請輸入姓名">
          <div class="form-text"></div>
        </div>
        <div class="mb-3 col">
          <label for="id_card" class="form-label"><span class="required">**</span>身分證字號</label>
          <input type="text" class="form-control" id="id_card" name="id_card" placeholder="請輸入身分證字號">
          <div class="form-text"></div>
        </div>
        </div>
        <div class="row">
        <div class="mb-3 col">
          <label for="account" class="form-label"><span class="required">**</span>性別</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="gender1" value="male" checked>
            <label class="form-check-label" for="gender1">
              男
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="gender2" value="female">
            <label class="form-check-label" for="gender2">
              女
            </label>
          </div>
          <!-- <div class="form-text"></div> -->
        </div>
        <div class="mb-3 col">
          <label for="birthday" class="form-label">生日</label>
          <input type="date" class="form-control" id="birthday" name="birthday">
          <div class="form-text"></div>
        </div>
        </div>



<div class="row">
        <div class="mb-3 col">
          <label for="mobile" class="form-label"><span class="required">**</span>手機</label>
          <input type="text" class="form-control" id="mobile" name="mobile" placeholder="請輸入手機">
          <div class="form-text"></div>
        </div>
        </div>
        <div class="row">
        <div class="mb-3 col">
          <label for="address" class="form-label">地址</label>
          <input type="text" class="form-control" id="address" name="address" placeholder="請輸入地址">
          <div class="form-text"></div>
        </div>
        </div>
        <div class="row">
        <div class="mb-3 col">
          <label for="bank_account" class="form-label"><span class="required">**</span>銀行帳戶</label>
          <input type="text" class="form-control" id="bank_account" name="bank_account" placeholder="請輸入銀行帳戶">

          <div class="form-text"></div>
        </div>
        </div>
        <div class="row">
        <div class="mb-3 col">
          <label for="member_status" class="form-label">狀態</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="member_status" id="member_status1" value="1" checked>
            <label class="form-check-label" for="member_status1">
              使用中
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="member_status" id="member_status2" value="0" disabled>
            <label class="form-check-label" for="member_status2">
              封鎖
            </label>
          </div>
          <div class="form-text"></div>
        </div>
        </div>
        <button type="submit" class="btn btn-primary">新增</button>

        <a href="owners-list.php" class="btn btn-primary">取消</a>
    </div>

    </form>


  </div>

</main>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">資料新增結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">
          資料新增成功
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
        <a href="owners-list.php." class="btn btn-primary">到列表頁</a>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/parts/scripts.php' ?>
<script>
  const nameField = document.owners_add_form.name;
  const emailField = document.owners_add_form.email;
  const passwordField = document.owners_add_form.password;
  const id_cardField = document.owners_add_form.id_card;
  const mobileField = document.owners_add_form.mobile;
  const bankAccountField = document.owners_add_form.bank_account;

  function validateEmail(email) {
    var re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  function validatePassword(password) {
    var rules = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,12}$/;
    return rules.test(password);
  }

  function validateIdcard(id_card) {
    var rules = /^[A-Z]{1}[1-2]{1}[0-9]{8}$/
    return rules.test(id_card);
  }

  function validateMobile(mobile) {
    var rules = /^09\d{8}$/
    return rules.test(mobile);
  }

  function validateBankAccount(bank_account) {
    var rules = /^[0-9]{13,21}$/
    return rules.test(bank_account);
  }

  const sendData = e => {

    e.preventDefault();

    nameField.style.border = '1px solid #CCCCCC';
    nameField.nextElementSibling.innerHTML = '';
    emailField.style.border = '1px solid #CCCCCC';
    emailField.nextElementSibling.innerHTML = '';
    passwordField.style.border = '1px solid #CCCCCC';
    passwordField.nextElementSibling.innerHTML = '';
    id_cardField.style.border = '1px solid #CCCCCC';
    id_cardField.nextElementSibling.innerHTML = '';
    mobileField.style.border = '1px solid #CCCCCC';
    mobileField.nextElementSibling.innerHTML = '';
    bankAccountField.style.border = '1px solid #CCCCCC';
    bankAccountField.nextElementSibling.innerHTML = '';


    let isPass = true;
    //email驗證
    if (!validateEmail(emailField.value)) {
      isPass = false;
      emailField.style.border = '1px solid red';
      emailField.nextElementSibling.innerHTML = '請填寫正確的Email';
    }
    //密碼驗證，至少 8-16 個字元、要有大小寫字母、至少一個數字
    if (!validatePassword(passwordField.value)) {
      isPass = false;
      passwordField.style.border = '1px solid red';
      passwordField.nextElementSibling.innerHTML = '請輸入6-12 個字元、含大小寫字母、至少一個數字';
    }

    //name驗證
    if (nameField.value.length < 2) {
      isPass = false;
      nameField.style.border = '1px solid red';
      nameField.nextElementSibling.innerHTML = '請填寫正確的姓名';
    }

    //身分證字號驗證
    if (!validateIdcard(id_cardField.value)) {
      isPass = false;
      id_cardField.style.border = '1px solid red';
      id_cardField.nextElementSibling.innerHTML = '請填寫正確的身分證字號';
    }

    //手機驗證
    if (!validateMobile(mobileField.value)) {
      isPass = false;
      mobileField.style.border = '1px solid red';
      mobileField.nextElementSibling.innerHTML = '請填寫正確的手機號碼';
    }

    //銀行帳戶驗證，可以使用下拉選單，7+14碼

    if (!validateBankAccount(bankAccountField.value)) {
      isPass = false;
      bankAccountField.style.border = '1px solid red';
      bankAccountField.nextElementSibling.innerHTML = '請填寫正確的銀行帳戶';
    }

    if (isPass) {
      const fd = new FormData(document.owners_add_form)

      fetch('owners-add-api.php', {
          method: 'POST',
          body: fd
        })
        .then(r => r.json())
        .then(data => {
          console.log(data);
          if(data.success){
            myModal.show();
          }else{
            console.log(`資料新增失敗`);
          }
        }).catch(ex=>{
          console.log(`fetch() 發生錯誤,回傳的JSON格式錯誤`);
          console.log(ex);
        })
    }


  }

  const myModal = new bootstrap.Modal('#exampleModal');
</script>
<?php include __DIR__ . '/parts/html-foot.php' ?>