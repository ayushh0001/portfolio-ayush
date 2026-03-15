<?php
require_once __DIR__ . '/../data/data.php';
$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $sent = true;
}
?>
<section class="section" id="contact">
  <div class="section-inner">
    <p class="section-label">// send_message()</p>
    <h2 class="section-title">Contact</h2>
    <div class="section-divider"></div>

    <div class="contact-grid">
      <div class="contact-info">
        <p>Got a project in mind, a question, or just want to say hi? Drop me a message and I'll get back to you.</p>
        <div class="contact-links">
          <?php if (!empty($profile['email'])): ?>
            <div class="contact-link-item">📧 <a href="mailto:<?= htmlspecialchars($profile['email']) ?>"><?= htmlspecialchars($profile['email']) ?></a></div>
          <?php endif; ?>
          <?php if (!empty($profile['github'])): ?>
            <div class="contact-link-item">🐙 <a href="<?= htmlspecialchars($profile['github']) ?>" target="_blank"><?= htmlspecialchars($profile['github']) ?></a></div>
          <?php endif; ?>
          <?php if (!empty($profile['linkedin'])): ?>
            <div class="contact-link-item">💼 <a href="<?= htmlspecialchars($profile['linkedin']) ?>" target="_blank"><?= htmlspecialchars($profile['linkedin']) ?></a></div>
          <?php endif; ?>
          <?php if (!empty($profile['twitter'])): ?>
            <div class="contact-link-item">🐦 <a href="<?= htmlspecialchars($profile['twitter']) ?>" target="_blank"><?= htmlspecialchars($profile['twitter']) ?></a></div>
          <?php endif; ?>
        </div>
      </div>

      <form class="contact-form" method="POST">
        <?php if ($sent): ?>
          <p class="form-success">// Message sent. I'll reply soon.</p>
        <?php endif; ?>
        <div class="form-group">
          <label for="cf-name">name</label>
          <input type="text" id="cf-name" name="name" placeholder="Your name" required>
        </div>
        <div class="form-group">
          <label for="cf-email">email</label>
          <input type="email" id="cf-email" name="email" placeholder="you@example.com" required>
        </div>
        <div class="form-group">
          <label for="cf-message">message</label>
          <textarea id="cf-message" name="message" placeholder="// write your message here..." required></textarea>
        </div>
        <button type="submit" name="contact_submit" class="btn btn-primary">→ Send Message</button>
      </form>
    </div>
  </div>
</section>
