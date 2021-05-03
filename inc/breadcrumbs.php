<nav aria-label="breadcrumb">
  <ol class="breadcrumb py-3 me-5">
    <?php foreach ($breadcrumbs as $key => $breadcrumb): ?>
      <?php if (count($breadcrumbs) - 1 !== $key): ?>
      <li class="breadcrumb-item"><a href="<?= $breadcrumb['href'] ?>"><?= $breadcrumb['title'] ?></a></li>
      <?php else: ?>
      <li class="breadcrumb-item active" aria-current="page"><span><?= $breadcrumb['title'] ?></span></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ol>
</nav>