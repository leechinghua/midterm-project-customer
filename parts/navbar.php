<!-- d-flex 設定在容器上較好 -->
<header class="fixed-top d-flex justify-content-between">
  <a class="brand text-decoration-none text-white text-center fs-3 p-2" href="index_.php">野Fun</a>
  <div class="nav-item d-flex">
    <?php if (isset($_SESSION['admin'])) : ?>
      <a class="text-decoration-none text-white  p-3"><?= $_SESSION['admin']['nickname'] ?>主人，歡迎您</a>
      <a class="text-decoration-none  text-white  p-3" href="logout.php">登出</a>
    <?php endif; ?>
  </div>
</header>

<aside class="aside-content bg-light border-end position-fixed"  ">
  <!-- 清單列表 -->
  <ul class="list-unstyled" >
    <!-- a : d-block 讓超連結變為block元素，感應範圍變大，且可設定padding -->
    <li>
      <a class="text-decoration-none d-block mt-3 px-3 py-2" href="customers.php"><i class="bi bi-file-earmark me-2"></i>會員資料</a>
    </li>
    <li>
      <a class="text-decoration-none d-block mt-2 px-3 py-2" href="owners-list-admin.php"><i class="bi bi-cart3 me-2"></i>場主資料</a>
    </li>
    <li>
      <a class="text-decoration-none d-block mt-2 px-3 py-2" href="stores.php"><i class="bi bi-people me-2"></i>營地管理</a>
    </li>
    <li>
      <a class="text-decoration-none d-block mt-2 px-3 py-2" href="orders.php"><i class="bi bi-graph-up me-2"></i>訂單管理</a>
    </li>
    <li>
      <a class="text-decoration-none d-block mt-2 px-3 py-2" href="comment-list.php"><i class="bi bi-puzzle me-2"></i>評論管理</a>
    </li>
    <li>
      
      
  <a class="text-decoration-none d-block mt-2 px-3 py-2" href="blog.php"><i class="bi bi-puzzle me-2"></i>推廣文列表</a>
</li>
    <li>
      
      
    <a class="text-decoration-none d-block mt-2 px-3 py-2" href="favorite_blog.php"><i class="bi bi-puzzle me-2"></i>最愛推廣文列表</a>
</li>
    <li>
      
      
    <a class="text-decoration-none d-block mt-2 px-3 py-2" href="blog_img.php"><i class="bi bi-puzzle me-2"></i>推廣文圖片列表</a>
   
</li>
  
  

  </ul>
  <!-- 中間文字 -->
  <div class="d-flex justify-content-between px-3 text-secondary">
    <!-- <span>SAVED REPORTS</span> -->
    <!-- <a><i class="bi bi-plus-circle"></i></a> -->
  </div>
  <!-- 清單列表 -->
  <ul class="list-unstyled">
    <li>
      <!-- <a class="text-decoration-none d-block px-3 py-2" href=""><i class="bi bi-file-earmark-text me-2"></i>Current month</a> -->
    </li>
    <!-- <li>
      <a class="text-decoration-none d-block px-3 py-2" href=""><i class="bi bi-file-earmark-text me-2"></i>Last quarter</a>
    </li>
    <li>
      <a class="text-decoration-none d-block px-3 py-2" href=""><i class="bi bi-file-earmark-text me-2"></i>Social engagement</a>
    </li>
    <li>
      <a class="text-decoration-none d-block px-3 py-2" href=""><i class="bi bi-file-earmark-text me-2"></i>Year-end sale</a>
    </li> -->
  </ul>
  <!-- <hr /> -->
  <ul class="list-unstyled">
    <li>
      <!-- <a class="text-decoration-none d-block px-3 py-2" href=""><i class="bi bi-gear-wide-connected me-2"></i>Settings</a> -->
    </li>
    <li>
      <!-- <a class="text-decoration-none d-block px-3 py-2" href=""><i class="bi bi-door-closed me-2"></i>Sign out</a> -->
    </li>
  </ul>
</aside>