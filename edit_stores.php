<?php
require __DIR__ . "/config/pdo-connect.php";
$title = "場地管理";

$sid = isset($_GET['stores_id']) ? intval($_GET['stores_id']) : 0;

if (empty($sid)) {
    header('Location: stores.php');
    exit; # 結束 php 程式, die()
}

$sql = "SELECT * FROM `stores` WHERE stores_id = $sid";
$stores = $pdo->query($sql)->fetch();

if (empty($stores)) {
    header('Location: stores.php');
    exit; # 結束 php 程式, die()
}

$sqlTag = " SELECT * FROM `tag` ";
$tags = $pdo->query($sqlTag)->fetchAll();

$sqlTagStore = "SELECT * FROM `stores_tag` 
JOIN tag ON stores_tag.tag_id = tag.tag_id
WHERE stores_id = $sid";
$tagsStore = $pdo->query($sqlTagStore)->fetchAll();
?>
<style>
    .border-warning {
        height: 200px;
    }
</style>

<?php include __DIR__ . './parts/html-head.php' ?>
<?php include __DIR__ . './parts/navbar.php' ?>

<main class="main-content p-5 ">
    <div class="d-flex justify-content-between align-items-center">
        <!-- 將h1自帶的margin消除 -->
        <h1 class="m-0 fs-5">
            <a class="fs-1" href="stores.php" style="text-decoration:none; color:black">Product</a>
        </h1>
        <!-- button用div包起來 -->
        <ul class="nav nav-underline fs-5">
            <li class="nav-item mx-3 ">
                <a class="nav-link text-success" href="edit_stores.php?stores_id=<?= $_GET['stores_id'] ?>">修改場地資料</a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-link text-warning" href="edit_stores_information.php?stores_id=<?= $_GET['stores_id'] ?>">修改場地資訊</a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-link text-warning" href="edit_stores_commodity.php?stores_id=<?= $_GET['stores_id'] ?>">修改空間數量</a>
            </li>
        </ul>
    </div>
    <hr />

    <div class="container">
        <div class="row">
            <div class="col">
                <form name="form2" onsubmit="sendTag(event,this)" class="border border-warning p-3 m-2">
                    <legend class="mb-3">增加標籤：</legend>
                    <?php foreach ($tags as $t) : ?>
                        <input type="hidden" id="stores_id" name="stores_id" value="<?= $_GET['stores_id'] ?>">
                        <input type="hidden" id="tag_name" name="tag_name" value="<?= $t['tag_name'] ?>">
                        <input type="radio" id="<?= $t['tag_id'] ?>" name="tag_id" value="<?= $t['tag_id'] ?>" class="form-check-input">
                        <label for="<?= $t['tag_id'] ?>" class="form-check-label"><?= $t['tag_name'] ?></label>
                    <?php endforeach ?>
                    <br>
                    <button type="submit" class="btn btn-primary mt-3">增加</button>
                </form>
            </div>
            <div class="col">
                <div class="border border-warning p-3 m-2">
                    <legend>已擁有的標籤：</legend>
                    <?php foreach ($tagsStore as $ts) : ?>
                        <span class="m-2 p-1 ">
                            <a class="text-decoration-none " href="storesTag_delete.php?store_tag_id=<?= $ts['store_tag_id'] ?>&stores_id=<?= $_GET['stores_id'] ?>">X</a>
                            <span><?= $ts['tag_name'] ?></span>
                        </span>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>


    <hr class="m-3">
    <form name="form1" onsubmit="sendData(event)" style="margin: 20px">

        <div class="pb-3">
            <label for="stores_id" class="form-label">場地編號</label>
            <input type="hidden" name="stores_id" value="<?= $stores['stores_id'] ?>">
            <input type="text" class="form-control" value="<?= $stores['stores_id'] ?>" disabled>
        </div>

        <div class="pb-3">
            <label for=" name" class="form-label">場地名稱</label>
            <input class="form-control" type="text" id="name" name="name" value="<?= $stores['name'] ?>">
        </div>

        <div class="pb-3">
            <label for=" mobile" class="form-label">電話號碼</label>
            <input class="form-control" type="text" id="mobile" name="mobile" value="<?= $stores['mobile'] ?>">
        </div>

        <div class="pb-3">
            <label for=" address" class="form-label">地址</label>
            <input class="form-control" type="text" id="address" name="address" value="<?= $stores['address'] ?>">
        </div>

        <div class="pb-3">
            <label for=" longitude" class="form-label">經度</label>
            <input class="form-control" type="text" id="longitude" name="longitude" value="<?= htmlentities($stores['longitude']) ?>">
        </div>

        <div class="pb-3">
            <label for=" latitude" class="form-label">緯度</label>
            <input class="form-control" type="text" id="latitude" name="latitude" value="<?= htmlentities($stores['latitude']) ?>">
        </div>

        <div class="pb-3">
            <label for=" altitude" class="form-label">高度</label>
            <input class="form-control" type="text" id="altitude" name="altitude" value="<?= $stores['altitude'] ?>">
        </div>



        <div class="pb-3">
            <label for=" precautions" class="form-label">注意事項</label>
            <textarea class="form-control" id="precautions" name="precautions" rows="3"><?= $stores['precautions'] ?></textarea>
        </div>

        <div class="pb-3">
            <label for=" introduction" class="form-label">場地簡介</label>
            <textarea class="form-control" id="introduction" name="introduction" rows="3"><?= $stores['introduction'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">確定修改</button>
    </form>
    </div>

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
                    <a href="edit_stores.php?stores_id=<?= $_GET['stores_id'] ?>" class="btn btn-primary">OK</a>
                </div>
            </div>
        </div>
    </div>
</main>

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
                <a href="edit_stores.php?stores_id=<?= $_GET['stores_id'] ?>" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>



<?php include __DIR__ . './parts/scripts.php' ?>
<script>
    const sendTag = (e, th) => {

        e.preventDefault();

        //只有資料的表單物物件
        const file = new FormData(th);
        fetch('storeAddTag_api.php', {
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


    const sendData = e => {

        e.preventDefault();

        //只有資料的表單物物件
        const file = new FormData(document.form1);
        fetch('edit_stores_api.php', {
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