
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
    <img src="./images/login.png" alt="" >
    <a href="login.php" class="btn  loginbtn ">登入</a>
    </div>
</main>


<?php include __DIR__ . '/parts/scripts.php' ?>
<?php include __DIR__ . '/parts/html-foot.php' ?>