<?php require_once __DIR__ . '/../data/data.php'; ?>
<section class="hero">
  <div class="terminal-window">
    <div class="terminal-bar">
      <span class="dot red"></span>
      <span class="dot yellow"></span>
      <span class="dot green"></span>
      <span class="terminal-title">bash — 80×24</span>
    </div>
    <div class="terminal-body">
      <p class="terminal-prompt">
        <span class="arrow">→</span>
        <span class="path"> ~/portfolio</span>
        <span class="cmd"> git checkout main</span>
      </p>
      <p class="terminal-comment">// Initializing developer profile...</p>

      <div class="hero-inner">
        <div class="hero-content">
          <h1 class="hero-title">
            Hello World,<br>
            I am <span class="name"><?= htmlspecialchars($profile['name']) ?></span>
          </h1>
          <p class="hero-sub"><?= nl2br(htmlspecialchars($profile['tagline'])) ?></p>
          <div class="hero-btns">
            <a href="projects.php" class="btn btn-primary">View Projects</a>
            <a href="contact.php"  class="btn btn-outline">Contact Me</a>
            <?php if (!empty($profile['resume'])): ?>
              <a href="<?= htmlspecialchars($profile['resume']) ?>" target="_blank" class="btn btn-outline">↓ Resume</a>
            <?php endif; ?>
            <a href="admin/index.php" class="btn btn-ghost">⚙ Admin</a>
          </div>
        </div>

        <?php if (!empty($profile['photo'])): ?>
          <?php $photoSrc = (strpos($profile['photo'], 'http') === 0) ? $profile['photo'] : $profile['photo']; ?>
          <div class="hero-avatar-wrap">
            <img src="<?= htmlspecialchars($photoSrc) ?>" alt="<?= htmlspecialchars($profile['name']) ?>" class="hero-avatar">
            <div class="hero-avatar-ring"></div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
