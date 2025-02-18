<?php
require __DIR__ . "/config/pdo-connect.php";
$title = "場地管理";

$sid = isset($_GET['stores_id']) ? intval($_GET['stores_id']) : 0;

if (empty($sid)) {
    header('Location: edit_stores.php?stores_id=' . $_GET['stores_id']);
    exit; # 結束 php 程式, die()
}

$sql = "SELECT * FROM `stores_informations` WHERE stores_id = $sid";
$storesInformation = $pdo->query($sql)->fetch();

?>


<?php include __DIR__ . './parts/html-head.php' ?>
<?php include __DIR__ . './parts/navbar.php' ?>
<main class="main-content p-5">
    <div class="d-flex justify-content-between align-items-center">
        <!-- 將h1自帶的margin消除 -->
        <h1 class="m-0 fs-5">
            <a class="fs-1" href="stores.php" style="text-decoration:none; color:black">Product</a>
        </h1>
        <!-- button用div包起來 -->
        <ul class="nav nav-underline fs-5">
            <li class="nav-item mx-3 ">
                <a class="nav-link text-warning" href="edit_stores.php?stores_id=<?= $_GET['stores_id'] ?>">修改場地資料</a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-link text-danger " href="edit_stores_information.php?stores_id=<?= $_GET['stores_id'] ?>">增加場地資訊</a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-link text-warning" href="edit_stores_commodity.php?stores_id=<?= $_GET['stores_id'] ?>">修改空間數量</a>
            </li>
        </ul>
    </div>
    <hr />
    <div class="px-5">
        <h2>增加場地資料</h2>

        <form name="form1" onsubmit="sendData(event)" style="margin: 20px">

            <div class="pb-3">
                <label for="stores_id" class="form-label">場地編號</label>
                <input type="hidden" name="stores_id" value="<?= $_GET['stores_id'] ?>">
                <input type="text" class="form-control" value="<?= $_GET['stores_id'] ?>" disabled>
            </div>

            <div class="pb-3">
                <label for="entry_time" class="form-label">最早入場時間</label>
                <input class="form-control" type="time" id="entry_time" name="entry_time">
            </div>

            <div class="pb-3">
                <label for="close_time" class="form-label">最晚入場時間</label>
                <input class="form-control" type="time" id="close_time" name="close_time">
            </div>

            <div class="pb-3">
                <label for="night_time" class="form-label">夜衝開始時間</label>
                <input class="form-control" type="time" id="night_time" name="night_time">
            </div>

            <div class="pb-3">
                <label for="bath_time" class="form-label">開放洗澡時間</label>
                <input class="form-control" type="time" id="bath_time" name="bath_time">
            </div>

            <div class="pb-3">
                <label>飲水機(Yes/No)</label>
                <select class="form-select" name="water" id="water">
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                </select>
            </div>

            <div class="pb-3">
                <label>冰箱(Yes/No)</label>
                <select class="form-select" name="refrigerator" id="refrigerator">
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                </select>
            </div>

            <div class="pb-3">
                <label for="curfew" class="form-label">宵禁時間</label>
                <input class="form-control" type="time" id="curfew" name="curfew" value="<?= isset($storesInformation['curfew']) ? $storesInformation['curfew'] : '' ?>">
            </div>

            <div class="pb-3">
                <label>寵物(Yes/No)</label>
                <select class="form-select" name="pet" id="pet">
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">確定修改</button>
        </form>
    </div>
</main>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">資料編輯結果</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    編輯成功
                </div>
            </div>
            <div class="modal-footer">
                <a href="edit_stores_information.php?stores_id=<?= $_GET['stores_id'] ?>" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModa2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabe2">資料編輯結果</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    資料沒有編輯
                </div>
            </div>
            <div class="modal-footer">
                <a href="add_stores_information.php?stores_id=<?= $_GET['stores_id'] ?>" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>


<?php include __DIR__ . './parts/scripts.php' ?>
<script>
    const nameField = document.form1.name;
    const emailField = document.form1.email;

    const sendData = e => {

        e.preventDefault();

        //只有資料的表單物物件
        const file = new FormData(document.form1);
        fetch('add_stores_information_api.php', {
                method: 'POST',
                body: file, //預設'Content-Type: multipart/form-data'
            })
            .then(r => r.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    console.log("YES");
                    myModal.show();
                } else {
                    console.log("NO");
                    myModa2.show();
                }
            }).catch(error => {
                console.log(`fetch() 發生錯誤, 回傳的 JSON 格式是錯的`);
                console.log(error);
            })
    }

    const myModal = new bootstrap.Modal('#exampleModal');
    const myModa2 = new bootstrap.Modal('#exampleModa2');
</script>



<?php include __DIR__ . './parts/html-foot.php' ?>