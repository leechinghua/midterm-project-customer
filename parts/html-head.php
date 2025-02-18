<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= isset($title) ? "{$title} | 野Fun" : "野Fun" ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <!-- google font -->

  <style>
    :root {
      --aside-width: 240px;
      --page-top: 56px;
    }

    header {
      background-color: #C6A300;
    }

    .brand {
      width: var(--aside-width);
      background-color: #73BF00;
    }

    .aside-content {
      /* top : 0 可以讓aside位置回到最頂部 */
      top: 0;
      width: var(--aside-width);
      height: 100%;
      margin-top: var(--page-top);
      /* 也可設定padding-top */
    }

    .main-content {
      /* 讓main不會被遮住 */
      margin: var(--page-top) 0 0 var(--aside-width);
    }
  </style>
</head>

<body>