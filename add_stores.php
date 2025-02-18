<?php

# 啟動 session
if (!isset($_SESSION)) {
    # 如果沒有設定 $_SESSION, 才啟動
    session_start();
}

$title = "場地管理";

?>
<?php include __DIR__ . './parts/html-head.php' ?>
<?php include __DIR__ . './parts/navbar.php' ?>

<main class="main-content p-5">
    <div class="d-flex justify-content-between align-items-center">
        <!-- 將h1自帶的margin消除 -->
        <h1 class="m-0 fs-5">
            <a class="fs-1" href="stores.php" style="text-decoration:none; color:black">Product-Add</a>
        </h1>
        <!-- button用div包起來 -->
    </div>
    <hr />

    <div class="px-5">

        <form name="form1" onsubmit="sendData(event)" style="margin: 20px">

            <div class="pb-3">
                <label for="owners_id" class="form-label">賣家編號</label>
                <input class="form-control" type="number" id="owners_id" name="owners_id">
            </div>

            <div class="pb-3">
                <label for="name" class="form-label">場地名稱</label>
                <input class="form-control" type="text" id="name" name="name">
            </div>

            <div class="pb-3">
                <label for="mobile" class="form-label">電話號碼</label>
                <input class="form-control" type="text" id="mobile" name="mobile">
            </div>

            <div class="pb-3">
                <label for="address" class="form-label">地址</label>
                <input class="form-control" type="text" id="address" name="address">
            </div>

            <div class="pb-3">
                <label for="longitude" class="form-label">經度</label>
                <input class="form-control" type="text" id="longitude" name="longitude">
            </div>

            <div class="pb-3">
                <label for="latitude" class="form-label">緯度</label>
                <input class="form-control" type="text" id="latitude" name="latitude">
            </div>

            <div class="pb-3">
                <label for="altitude" class="form-label">高度</label>
                <input class="form-control" type="text" id="altitude" name="altitude">
            </div>

            <div class="pb-3">
                <label for="precautions" class="form-label">注意事項</label>
                <textarea class="form-control" id="precautions" name="precautions" rows="5"></textarea>
            </div>

            <div class="pb-3">
                <label for="introduction" class="form-label">場地簡介</label>
                <textarea class="form-control" id="introduction" name="introduction" rows="5"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">確定新增</button>
        </form>
    </div>
</main>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">資料新增結果</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    增加成功
                </div>
            </div>
            <div class="modal-footer">
                <a href="stores.php?" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModa2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabe2">資料新增結果</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    增加失敗
                </div>
            </div>
            <div class="modal-footer">
                <a href="stores.php" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . './parts/scripts.php' ?>
<script>
    const sendData = e => {

        e.preventDefault();

        //只有資料的表單物物件
        const file = new FormData(document.form1);
        fetch('add_store_api.php', {
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