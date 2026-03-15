<?php
function nextId(array $items): int {
    if (empty($items)) return 1;
    return max(array_column($items, 'id')) + 1;
}

function saveData(array $projects, array $skillCategories, array $profile): void {
    $dataFile = __DIR__ . '/../data/data.php';
    $content  = "<?php\n";
    $content .= '$profile = '          . var_export($profile, true)          . ";\n\n";
    $content .= '$projects = '         . var_export($projects, true)         . ";\n\n";
    $content .= '$skillCategories = '  . var_export($skillCategories, true)  . ";\n";
    file_put_contents($dataFile, $content);
}

/**
 * Handle a file upload. Returns the web-relative path on success, or '' on skip.
 * $field   — $_FILES key
 * $subdir  — 'photos' | 'resumes'
 * $allowed — allowed mime types
 */
function handleUpload(string $field, string $subdir, array $allowed): string {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return '';

    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK) return '';

    // Validate by extension as fallback (MIME can be spoofed but fine for local use)
    $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $extMap  = [
        'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',  'gif'  => 'image/gif',
        'webp'=> 'image/webp', 'pdf'  => 'application/pdf',
    ];
    $mime = isset($extMap[$ext]) ? $extMap[$ext] : $file['type'];
    if (!in_array($mime, $allowed, true)) return '';
    if ($file['size'] > 5 * 1024 * 1024) return '';

    $name = uniqid('', true) . '.' . $ext;
    $dir  = __DIR__ . '/../uploads/' . $subdir . '/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $dest = $dir . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) return '';

    return 'uploads/' . $subdir . '/' . $name;
}
