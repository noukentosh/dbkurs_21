<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>Автомастерская</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="/">Автомастерская</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="/order/browse.php">
                Заказы
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/car/browse.php">
                Автомобили
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/customer/browse.php">
                Клиенты
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/service/browse.php">
                Услуги
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/category/browse.php">
                Категории
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/employee/browse.php">
                Работники
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container">
    <?php require_once __DIR__ . '/breadcrumbs.php'; ?>