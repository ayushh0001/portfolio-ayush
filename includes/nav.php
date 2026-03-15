<?php
// $page must be set before including this file
$navItems = [
    ['href' => 'index.php',    'num' => '01', 'label' => 'Root'],
    ['href' => 'about.php',    'num' => '02', 'label' => 'About'],
    ['href' => 'projects.php', 'num' => '03', 'label' => 'Repos'],
    ['href' => 'contact.php',  'num' => '04', 'label' => 'Ping'],
];
?>
<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <span class="kw">const</span>
    <span class="var"> Ayush</span>
    <span class="op"> = </span>
    <span class="val">{}</span>
  </a>

  <button class="hamburger" aria-label="Toggle menu">
    <span></span><span></span><span></span>
  </button>

  <ul class="nav-links">
    <?php foreach ($navItems as $item): ?>
      <li>
        <a href="<?= $item['href'] ?>" class="<?= ($page === $item['href']) ? 'active' : '' ?>">
          <span class="num"><?= $item['num'] ?>.</span> <?= $item['label'] ?>
        </a>
      </li>
    <?php endforeach; ?>
    <li class="admin-link">
      <a href="admin/index.php">⚙ Admin</a>
    </li>
  </ul>
</nav>
