<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid credentials.';
}

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Ayush</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <div class="admin-login-wrap">
    <div class="admin-login-box">
      <div class="terminal-bar" style="border-radius:6px 6px 0 0;">
        <span class="dot red"></span>
        <span class="dot yellow"></span>
        <span class="dot green"></span>
        <span class="terminal-title">admin — login</span>
      </div>
      <div class="admin-login-body">
        <p class="section-label" style="margin-bottom:0.25rem;">// sudo access</p>
        <h1 class="section-title" style="font-size:1.4rem;margin-bottom:1.5rem;">Admin Login</h1>

        <?php if ($error): ?>
          <p class="admin-error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" class="contact-form">
          <div class="form-group">
            <label for="username">username</label>
            <input type="text" id="username" name="username" placeholder="admin" required autofocus>
          </div>
          <div class="form-group">
            <label for="password">password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">→ Login</button>
        </form>
        <p style="text-align:center;margin-top:1rem;">
          <a href="../index.php" class="admin-back-link">← Back to portfolio</a>
        </p>
      </div>
    </div>
  </div>
</body>
</html>
