<?php
require_once 'auth.php';
require_once 'helpers.php';
require_once __DIR__ . '/../data/data.php';

// ── Handle POST actions ──────────────────────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action    = $_POST['action'] ?? '';
    $parseList = fn(string $s): array => array_values(array_filter(array_map('trim', explode(',', $s))));

    // ── Profile ──
    if ($action === 'update_profile') {
        // Handle photo upload
        $photoPath = handleUpload('photo_file', 'photos', ['image/jpeg','image/png','image/gif','image/webp']);
        if ($photoPath === '' && !empty($_POST['photo_url'])) {
            $photoPath = trim($_POST['photo_url']);
        } elseif ($photoPath === '') {
            $photoPath = $profile['photo']; // keep existing
        }

        // Handle resume upload
        $resumePath = handleUpload('resume_file', 'resumes', ['application/pdf']);
        if ($resumePath === '' && !empty($_POST['resume_url'])) {
            $resumePath = trim($_POST['resume_url']);
        } elseif ($resumePath === '') {
            $resumePath = $profile['resume']; // keep existing
        }

        $profile = [
            'name'     => trim($_POST['name']),
            'tagline'  => trim($_POST['tagline']),
            'bio'      => array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", '', $_POST['bio']))))) ,
            'photo'    => $photoPath,
            'resume'   => $resumePath,
            'email'    => trim($_POST['email']),
            'github'   => trim($_POST['github']),
            'linkedin' => trim($_POST['linkedin']),
            'twitter'  => trim($_POST['twitter']),
            'website'  => trim($_POST['website']),
        ];
        saveData($projects, $skillCategories, $profile);
        header('Location: dashboard.php#profile'); exit;
    }

    // ── Projects ──
    if ($action === 'add_project') {
        // Handle project image upload
        $imgPath = handleUpload('img_file', 'projects', ['image/jpeg','image/png','image/gif','image/webp']);
        if ($imgPath === '') $imgPath = trim($_POST['img'] ?? '');

        $projects[] = [
            'id'          => nextId($projects),
            'title'       => trim($_POST['title']),
            'description' => trim($_POST['description']),
            'tech'        => $parseList($_POST['tech']),
            'link'        => trim($_POST['link']),
            'img'         => $imgPath,
        ];
        saveData($projects, $skillCategories, $profile);
        header('Location: dashboard.php#projects'); exit;
    }

    if ($action === 'update_project') {
        $id      = (int)$_POST['id'];
        $imgPath = handleUpload('img_file_' . $id, 'projects', ['image/jpeg','image/png','image/gif','image/webp']);

        foreach ($projects as &$p) {
            if ($p['id'] === $id) {
                $p['title']       = trim($_POST['title']);
                $p['description'] = trim($_POST['description']);
                $p['tech']        = $parseList($_POST['tech']);
                $p['link']        = trim($_POST['link']);
                $p['img']         = $imgPath !== '' ? $imgPath : trim($_POST['img']);
                break;
            }
        }
        unset($p);
        saveData($projects, $skillCategories, $profile);
        header('Location: dashboard.php#projects'); exit;
    }

    if ($action === 'delete_project') {
        $id       = (int)$_POST['id'];
        $projects = array_values(array_filter($projects, fn($p) => $p['id'] !== $id));
        saveData($projects, $skillCategories, $profile);
        header('Location: dashboard.php#projects'); exit;
    }

    // ── Skills ──
    if ($action === 'add_skill') {
        $skillCategories[] = [
            'id'    => nextId($skillCategories),
            'icon'  => trim($_POST['icon']),
            'title' => trim($_POST['title']),
            'items' => $parseList($_POST['items']),
        ];
        saveData($projects, $skillCategories, $profile);
        header('Location: dashboard.php#skills'); exit;
    }

    if ($action === 'update_skill') {
        $id = (int)$_POST['id'];
        foreach ($skillCategories as &$s) {
            if ($s['id'] === $id) {
                $s['icon']  = trim($_POST['icon']);
                $s['title'] = trim($_POST['title']);
                $s['items'] = $parseList($_POST['items']);
                break;
            }
        }
        unset($s);
        saveData($projects, $skillCategories, $profile);
        header('Location: dashboard.php#skills'); exit;
    }

    if ($action === 'delete_skill') {
        $id              = (int)$_POST['id'];
        $skillCategories = array_values(array_filter($skillCategories, fn($s) => $s['id'] !== $id));
        saveData($projects, $skillCategories, $profile);
        header('Location: dashboard.php#skills'); exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="admin-wrap">

  <!-- Sidebar -->
  <aside class="admin-sidebar">
    <div class="admin-logo">
      <span style="color:var(--purple)">const</span>
      <span style="color:var(--accent)"> Admin</span>
      <span style="color:var(--text-dim)"> = {}</span>
    </div>
    <nav class="admin-nav">
      <a href="#profile"  class="admin-nav-link" data-tab="profile">👤 Profile</a>
      <a href="#projects" class="admin-nav-link" data-tab="projects">📁 Projects</a>
      <a href="#skills"   class="admin-nav-link" data-tab="skills">🛠 Skills</a>
    </nav>
    <div class="admin-sidebar-footer">
      <a href="../index.php" class="admin-back-link">← Portfolio</a>
      <a href="logout.php"   class="admin-logout-link">Logout</a>
    </div>
  </aside>

  <!-- Main -->
  <main class="admin-main">

    <!-- ── Profile Tab ── -->
    <div class="admin-tab hidden" id="tab-profile">
      <h2 class="admin-tab-title">Profile</h2>

      <form method="POST" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="action" value="update_profile">

        <!-- Photo -->
        <div class="admin-card">
          <h3 class="admin-card-title">🖼 Profile Photo</h3>
          <div class="admin-photo-preview-wrap">
            <?php if (!empty($profile['photo'])): ?>
              <?php $photoSrc = (strpos($profile['photo'], 'http') === 0) ? $profile['photo'] : '../' . $profile['photo']; ?>
              <img src="<?= htmlspecialchars($photoSrc) ?>" alt="Current photo" class="admin-photo-preview">
              <p class="admin-current-file" style="margin-top:0.5rem;margin-bottom:0;">Current: <span style="color:var(--accent2)"><?= htmlspecialchars($profile['photo']) ?></span></p>
            <?php else: ?>
              <div class="admin-photo-placeholder">No photo set</div>
            <?php endif; ?>
          </div>
          <div class="admin-form-row" style="margin-top:1rem;">
            <div class="form-group">
              <label>upload new photo (jpg/png/webp, max 5MB)</label>
              <label class="file-label" for="photo_file">
                <span class="file-label-icon">↑</span>
                <span class="file-label-name">No file chosen</span>
              </label>
              <input type="file" name="photo_file" id="photo_file" accept="image/*">
            </div>
            <div class="form-group">
              <label>or paste image URL</label>
              <?php $photoUrlVal = (strpos($profile['photo'] ?? '', 'uploads/') === 0) ? '' : htmlspecialchars($profile['photo'] ?? ''); ?>
              <input type="text" name="photo_url" placeholder="https://..." value="<?= $photoUrlVal ?>">
            </div>
          </div>
        </div>

        <!-- Resume -->
        <div class="admin-card">
          <h3 class="admin-card-title">📄 Resume</h3>
          <?php if (!empty($profile['resume'])): ?>
            <?php $resumeSrc = (strpos($profile['resume'], 'http') === 0) ? $profile['resume'] : '../' . $profile['resume']; ?>
            <p class="admin-current-file">Current: <a href="<?= htmlspecialchars($resumeSrc) ?>" target="_blank"><?= htmlspecialchars($profile['resume']) ?></a></p>
          <?php endif; ?>
          <div class="admin-form-row">
            <div class="form-group">
              <label>upload PDF (max 5MB)</label>
              <label class="file-label" for="resume_file">
                <span class="file-label-icon">↑</span>
                <span class="file-label-name">No file chosen</span>
              </label>
              <input type="file" name="resume_file" id="resume_file" accept=".pdf,application/pdf">
            </div>
            <div class="form-group">
              <label>or paste resume URL</label>
              <?php $resumeUrlVal = (strpos($profile['resume'] ?? '', 'uploads/') === 0) ? '' : htmlspecialchars($profile['resume'] ?? ''); ?>
              <input type="text" name="resume_url" placeholder="https://..." value="<?= $resumeUrlVal ?>">
            </div>
          </div>
        </div>

        <!-- Basic info -->
        <div class="admin-card">
          <h3 class="admin-card-title">✏️ Basic Info</h3>
          <div class="admin-form-row">
            <div class="form-group">
              <label>name</label>
              <input type="text" name="name" value="<?= htmlspecialchars($profile['name']) ?>" required>
            </div>
            <div class="form-group">
              <label>email</label>
              <input type="email" name="email" value="<?= htmlspecialchars($profile['email']) ?>">
            </div>
          </div>
          <div class="form-group">
            <label>tagline (hero subtitle)</label>
            <input type="text" name="tagline" value="<?= htmlspecialchars($profile['tagline']) ?>">
          </div>
          <div class="form-group">
            <label>bio (one paragraph per line)</label>
            <textarea name="bio" rows="6"><?= htmlspecialchars(implode("\n", $profile['bio'])) ?></textarea>
          </div>
        </div>

        <!-- Links -->
        <div class="admin-card">
          <h3 class="admin-card-title">🔗 Links</h3>
          <div class="admin-form-row">
            <div class="form-group">
              <label>🐙 GitHub URL</label>
              <input type="url" name="github" value="<?= htmlspecialchars($profile['github']) ?>" placeholder="https://github.com/username">
            </div>
            <div class="form-group">
              <label>💼 LinkedIn URL</label>
              <input type="url" name="linkedin" value="<?= htmlspecialchars($profile['linkedin']) ?>" placeholder="https://linkedin.com/in/username">
            </div>
          </div>
          <div class="admin-form-row">
            <div class="form-group">
              <label>🐦 Twitter / X URL</label>
              <input type="url" name="twitter" value="<?= htmlspecialchars($profile['twitter']) ?>" placeholder="https://twitter.com/username">
            </div>
            <div class="form-group">
              <label>🌐 Personal Website</label>
              <input type="url" name="website" value="<?= htmlspecialchars($profile['website']) ?>" placeholder="https://yoursite.com">
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">💾 Save Profile</button>
      </form>
    </div>

    <!-- ── Projects Tab ── -->
    <div class="admin-tab hidden" id="tab-projects">
      <h2 class="admin-tab-title">Projects</h2>

      <div class="admin-card">
        <h3 class="admin-card-title">+ Add Project</h3>
        <form method="POST" enctype="multipart/form-data" class="admin-form">
          <input type="hidden" name="action" value="add_project">
          <div class="admin-form-row">
            <div class="form-group"><label>title</label><input type="text" name="title" required></div>
            <div class="form-group"><label>link</label><input type="url" name="link" required></div>
          </div>
          <div class="form-group"><label>description</label><textarea name="description" rows="2" required></textarea></div>
          <div class="form-group"><label>tech (comma-separated)</label><input type="text" name="tech" placeholder="PHP, MySQL, JS"></div>
          <div class="admin-form-row">
            <div class="form-group">
              <label>upload image</label>
              <label class="file-label" for="img_file">
                <span class="file-label-icon">↑</span>
                <span class="file-label-name">No file chosen</span>
              </label>
              <input type="file" name="img_file" id="img_file" accept="image/*">
            </div>
            <div class="form-group"><label>or image URL</label><input type="text" name="img" placeholder="https://..."></div>
          </div>
          <button type="submit" class="btn btn-primary">Add Project</button>
        </form>
      </div>

      <?php foreach ($projects as $p): ?>
        <div class="admin-card">
          <details>
            <summary class="admin-item-summary">
              <span class="admin-item-title"><?= htmlspecialchars($p['title']) ?></span>
              <span class="admin-item-tags">
                <?php foreach ($p['tech'] as $t): ?>
                  <span class="tech-tag"><?= htmlspecialchars($t) ?></span>
                <?php endforeach; ?>
              </span>
            </summary>
            <form method="POST" enctype="multipart/form-data" class="admin-form" style="margin-top:1rem;">
              <input type="hidden" name="action" value="update_project">
              <input type="hidden" name="id" value="<?= $p['id'] ?>">
              <div class="admin-form-row">
                <div class="form-group"><label>title</label><input type="text" name="title" value="<?= htmlspecialchars($p['title']) ?>" required></div>
                <div class="form-group"><label>link</label><input type="url" name="link" value="<?= htmlspecialchars($p['link']) ?>" required></div>
              </div>
              <div class="form-group"><label>description</label><textarea name="description" rows="2" required><?= htmlspecialchars($p['description']) ?></textarea></div>
              <div class="form-group"><label>tech</label><input type="text" name="tech" value="<?= htmlspecialchars(implode(', ', $p['tech'])) ?>"></div>
              <?php if (!empty($p['img'])): ?>
                <?php $imgSrc = (strpos($p['img'], 'http') === 0) ? $p['img'] : '../' . $p['img']; ?>
                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="" class="admin-preview-img" style="border-radius:4px;width:120px;height:80px;">
              <?php endif; ?>
              <div class="admin-form-row">
                <div class="form-group">
                  <label>upload new image</label>
                  <label class="file-label" for="img_file_<?= $p['id'] ?>">
                    <span class="file-label-icon">↑</span>
                    <span class="file-label-name">No file chosen</span>
                  </label>
                  <input type="file" name="img_file_<?= $p['id'] ?>" id="img_file_<?= $p['id'] ?>" accept="image/*">
                </div>
                <div class="form-group"><label>or image URL</label><input type="text" name="img" value="<?= htmlspecialchars($p['img']) ?>"></div>
              </div>
              <div class="admin-form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="submit" form="del-p-<?= $p['id'] ?>" class="btn btn-danger" onclick="return confirm('Delete this project?')">Delete</button>
              </div>
            </form>
            <form id="del-p-<?= $p['id'] ?>" method="POST" style="display:none;">
              <input type="hidden" name="action" value="delete_project">
              <input type="hidden" name="id" value="<?= $p['id'] ?>">
            </form>
          </details>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- ── Skills Tab ── -->
    <div class="admin-tab hidden" id="tab-skills">
      <h2 class="admin-tab-title">Skill Categories</h2>

      <div class="admin-card">
        <h3 class="admin-card-title">+ Add Skill Category</h3>
        <form method="POST" class="admin-form">
          <input type="hidden" name="action" value="add_skill">
          <div class="admin-form-row">
            <div class="form-group"><label>icon (emoji)</label><input type="text" name="icon" placeholder="⚙️" required></div>
            <div class="form-group"><label>title</label><input type="text" name="title" required></div>
          </div>
          <div class="form-group"><label>items (comma-separated)</label><input type="text" name="items" placeholder="PHP, MySQL, REST" required></div>
          <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
      </div>

      <?php foreach ($skillCategories as $s): ?>
        <div class="admin-card">
          <details>
            <summary class="admin-item-summary">
              <span class="admin-item-title"><?= htmlspecialchars($s['icon']) ?> <?= htmlspecialchars($s['title']) ?></span>
              <span class="admin-item-tags">
                <?php foreach ($s['items'] as $item): ?>
                  <span class="skill-tag"><?= htmlspecialchars($item) ?></span>
                <?php endforeach; ?>
              </span>
            </summary>
            <form method="POST" class="admin-form" style="margin-top:1rem;">
              <input type="hidden" name="action" value="update_skill">
              <input type="hidden" name="id" value="<?= $s['id'] ?>">
              <div class="admin-form-row">
                <div class="form-group"><label>icon</label><input type="text" name="icon" value="<?= htmlspecialchars($s['icon']) ?>" required></div>
                <div class="form-group"><label>title</label><input type="text" name="title" value="<?= htmlspecialchars($s['title']) ?>" required></div>
              </div>
              <div class="form-group"><label>items</label><input type="text" name="items" value="<?= htmlspecialchars(implode(', ', $s['items'])) ?>" required></div>
              <div class="admin-form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="submit" form="del-s-<?= $s['id'] ?>" class="btn btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
              </div>
            </form>
            <form id="del-s-<?= $s['id'] ?>" method="POST" style="display:none;">
              <input type="hidden" name="action" value="delete_skill">
              <input type="hidden" name="id" value="<?= $s['id'] ?>">
            </form>
          </details>
        </div>
      <?php endforeach; ?>
    </div>

  </main>
</div>
<script src="admin.js"></script>
</body>
</html>
