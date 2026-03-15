<?php require_once __DIR__ . '/../data/data.php'; ?>
<?php
// Collect unique tags
$allTags = [];
foreach ($projects as $p) {
    foreach ($p['tech'] as $t) {
        if (!in_array($t, $allTags)) $allTags[] = $t;
    }
}
sort($allTags);
?>
<section class="section" id="projects">
  <div class="section-inner">
    <p class="section-label">// git_log --all</p>
    <h2 class="section-title">Projects</h2>
    <div class="section-divider"></div>

    <div class="filter-bar">
      <button class="filter-btn active" data-filter="all">All</button>
      <?php foreach ($allTags as $tag): ?>
        <button class="filter-btn" data-filter="<?= htmlspecialchars($tag) ?>">
          <?= htmlspecialchars($tag) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <div class="projects-grid">
      <?php foreach ($projects as $p): ?>
        <div class="project-card" data-tech="<?= htmlspecialchars(implode(',', $p['tech'])) ?>">
          <img src="<?= htmlspecialchars($p['img']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="project-img">
          <div class="project-body">
            <h3 class="project-title"><?= htmlspecialchars($p['title']) ?></h3>
            <p class="project-desc"><?= htmlspecialchars($p['description']) ?></p>
            <div class="project-tech">
              <?php foreach ($p['tech'] as $t): ?>
                <span class="tech-tag"><?= htmlspecialchars($t) ?></span>
              <?php endforeach; ?>
            </div>
            <a href="<?= htmlspecialchars($p['link']) ?>" target="_blank" class="project-link">
              → View on GitHub
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
