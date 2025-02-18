<?php
# exit; # 結束 php 程式
require __DIR__. '/config/pdo-connect.php';

$blogAuthor = ["豊鑫","于卉","為煬","昱穎","京樺","家浚"];
$lasts = ["何","傅","劉","吳","呂","周","唐","孫","宋","張","彭","徐","於","曹","曾","朱","李","林","梁","楊","沈","王","程","羅","胡","董","蕭","袁","許","謝","趙","郭","鄧","鄭","陳","韓","馬","馮","高","黃"];

$firsts = ["冠廷","冠宇","宗翰","家豪","彥廷","承翰","柏翰","宇軒","家瑋","冠霖","雅婷","雅筑","怡君","佳穎","怡萱","宜庭","郁婷","怡婷","詩涵","鈺婷"];

$areas = ["臺北市","新北市","桃園市","臺中市","臺南市","高雄市","新竹縣","苗栗縣","彰化縣","南投縣","雲林縣","嘉義縣","屏東縣","宜蘭縣","花蓮縣","臺東縣","澎湖縣","金門縣","連江縣","基隆市","新竹市","嘉義市"];

$blogTag = ["天體露營","篝火晚會","合歡山露營區","墾丁露營區","夜衝","洗澡","料理","驅蟲","防蛇","防熊","搭建帳篷","浮淺","橡皮筏","小木屋"];


$sql = "INSERT INTO `blog`( `title`, `author`, `blog_tag`, `content`, `create_at`) VALUES (?,?,?,?,now())";

$stmt = $pdo->prepare($sql);

for($i=1; $i<21; $i++){
    shuffle($blogAuthor);
    shuffle($blogTag);
    $blogTitle1 = "我的推廣文".$i;
    $blogAuthor1 = $blogAuthor[0];
    $blogTag1 = $blogTag[0];
    $blogContent ="<div>
    <hr>
    <p>
    這是一篇關於".$blogTag1."
    的文章
    有一天，我突然發現了一個令人興奮的露營博客。這個部落格充滿了關於大自然的美麗描述，以及露營生活中的種種冒險故事。在這個博客中，我發現了許多有關露營地點、戶外裝備和野外生存技巧的寶貴資訊。每一篇文章都像一場探險，帶領我穿越森林、越過山川，去探索大自然的奇妙之處。

我迫不及待地分享了這個博客的連結給我的朋友們，因為我相信他們也會被這些精彩的故事所吸引。在這個露營部落格的世界裡，每一篇文章都是獨特的冒險，每一次閱讀都是心靈的洗禮。我期待在未來的日子裡，繼續跟隨這個博客，與大自然親密接觸，感受生活的美好。

這個露營博客成為了我生活中的一部分，它不僅僅是一個網站，更是我靈魂的家園，讓我在城市喧囂中找到了片刻的寧靜和慰藉。我感謝這個博客的創作者，因為他們用文字和圖片，為我打開了通往自然世界的大門，讓我體驗了生活的真諦。</p><hr>
    </div>";
   

    $stmt->execute([
        $blogTitle1,
        $blogAuthor1,
        $blogTag1,
        $blogContent,
        
    ]);
}

echo json_encode([
    $stmt->rowCount(), // 影響的資料筆數
    $pdo->lastInsertId(), // 最新的新增資料的主鍵
]);


/*
https://www.ntdtv.com/b5/2017/05/14/a1324156.html


let d = `01李 02王 03張 04劉 05陳 06楊 07趙 08黃 09周 10吳
11徐 12孫 13胡 14朱 15高 16林 17何 18郭 19馬 20羅
21梁 22宋 23鄭 24謝 25韓 26唐 27馮 28於 29董 30蕭
31程 32曹 33袁 34鄧 35許 36傅 37沈 38曾 39彭 40呂`.split('').sort().slice(119);
JSON.stringify(d);

// ---------------------
https://freshman.tw/namerank

let ar = [];
$('table').eq(0).find('tr>td:nth-of-type(2)').each(function(i, el){
    ar.push(el.innerText);
});
$('table').eq(1).find('tr>td:nth-of-type(2)').each(function(i, el){
    ar.push(el.innerText);
});
JSON.stringify(ar);

// -------------------
https://www.president.gov.tw/Page/106
let ar = [];
$('.btn.btn-default.alluser').each(function(i, el){
    ar.push(el.innerText);
});
JSON.stringify(ar);

*/