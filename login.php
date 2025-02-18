<?php
if (!isset($_SESSION)) {
    # 如果沒有設定 $_SESSION，才啟動
    session_start();
  }
$title = '登入';
$pageName = 'login';

?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<header class="bg-black fixed-top d-flex">
  <a class="text-decoration-none text-white bg-black p-3" href="login.php">野Fun後臺管理系統</a>
</header>
<style>
    body { 
        /* background: #efefef; */
        background: url("images/background01.jpg") center center / cover no-repeat;

            /* @media screen and (min-width:576px) {
                background-image: url("./../picture/login.png");

            }

            @media screen and (min-width:768px) {
                background-image: url("/images/bg.jpg");
            }  */
    } 

    .login-panel {
        width: 300px;
        
    }

    .logo {
        width: 84px;
    }

    .input-area {
        .form-floating {
            .form-control:focus {
                position: relative;
                z-index: 1;
            }

            &:first-child {
                .form-control {
                    border-bottom-left-radius: 0;
                    border-bottom-right-radius: 0;
                    border-bottom: none;
                }
            }

            &:last-child {
                .form-control {
                    border-top-left-radius: 0;
                    border-top-right-radius: 0;
                }
            }
        }
    }
</style>

<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="login-panel">
            <!-- <img class="logo" src="/picture/Logo.png" alt=""> -->
            <h1 class="h3 mt-3 mb-4">Please sign in</h1>
            <form name="login_form" onsubmit="sendData(event)">

                <div class="form-floating">
                    <input type="text" class="form-control" id="email" placeholder="name@example.com" name="email">
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                    <label for="floatingPassword">Password</label>
                </div>
                <!-- <div class="form-text my-3 danger">
                    <span>123</span>
                  </div> -->
                <div class="d-grid mt-4 ">
                    <button class="btn btn-primary">Sign in</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">登入結果</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        帳號或密碼錯誤
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">繼續登入</button>
                    <!-- <a href="owners-list.php" class="btn btn-primary">到列表頁</a> -->
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/parts/scripts.php' ?>

    <script>
            // const emailField = document.login_form.email;

        // function validateEmail(email) {
        //     var re =
        //         /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        //     return re.test(email);
        // }

        const sendData = e => {
            e.preventDefault();

            // emailField.style.border = '1px solid #CCCCCC';
            // emailField.nextElementSibling.innerHTML = 'Email address';

            // let isPass = true;
            // //email驗證
            // if (!validateEmail(emailField.value)) {
            //     isPass = false;
            //     emailField.style.border = '1px solid red';   

            //     // emailField.nextElementSibling.innerHTML = '請填寫正確的Email';
            // }


            // if (isPass) {}
            const fd = new FormData(document.login_form)

            fetch('login-api.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r => r.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        location.href = 'index_.php'
                    } else {
                        myModal.show();
                    }
                }).catch(ex => {
                    console.log(`fetch() 發生錯誤,回傳的JSON格式錯誤`);
                    console.log(ex);
                })
        }




        const myModal = new bootstrap.Modal('#exampleModal');
        </script>
    <?php include __DIR__ . '/parts/html-foot.php' ?>