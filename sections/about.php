<?php require_once __DIR__ . '/../data/data.php'; ?>
<section class="section" id="about">
  <div class="section-inner">
    <p class="section-label">// who_am_i</p>
    <h2 class="section-title">About Me</h2>
    <div class="section-divider"></div>

    <div class="about-grid">
      <div class="about-text">
        <?php foreach ($profile['bio'] as $para): ?>
          <p><?= htmlspecialchars($para) ?></p>
        <?php endforeach; ?>

        <!-- Social links -->
        <div class="about-social">
          <?php if (!empty($profile['github'])): ?>
            <a href="<?= htmlspecialchars($profile['github']) ?>" target="_blank" class="social-link">🐙 GitHub</a>
          <?php endif; ?>
          <?php if (!empty($profile['linkedin'])): ?>
            <a href="<?= htmlspecialchars($profile['linkedin']) ?>" target="_blank" class="social-link">💼 LinkedIn</a>
          <?php endif; ?>
          <?php if (!empty($profile['twitter'])): ?>
            <a href="<?= htmlspecialchars($profile['twitter']) ?>" target="_blank" class="social-link">🐦 Twitter</a>
          <?php endif; ?>
          <?php if (!empty($profile['website'])): ?>
            <a href="<?= htmlspecialchars($profile['website']) ?>" target="_blank" class="social-link">🌐 Website</a>
          <?php endif; ?>
          <?php if (!empty($profile['resume'])): ?>
            <a href="<?= htmlspecialchars($profile['resume']) ?>" target="_blank" class="social-link">📄 Resume</a>
          <?php endif; ?>
        </div>
      </div>

      <div class="skills-grid">
        <?php foreach ($skillCategories as $cat): ?>
          <div class="skill-card">
            <div class="skill-card-header">
              <span class="skill-icon"><?= $cat['icon'] ?></span>
              <span class="skill-card-title"><?= htmlspecialchars($cat['title']) ?></span>
            </div>
            <div class="skill-tags">
              <?php foreach ($cat['items'] as $item): ?>
                <span class="skill-tag"><?= htmlspecialchars($item) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
