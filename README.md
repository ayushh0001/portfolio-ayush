# `const Ayush = {}`

> A terminal-themed developer portfolio built with vanilla PHP — no frameworks, no database, no build tools.

---

## ✦ Preview

```
→ ~/portfolio git checkout main
// Initializing developer profile...

Hello World,
I am Ayush
```

The entire site uses a VS Code / terminal aesthetic — dark background, monospace fonts, syntax-colored accents, and a code-editor UI language throughout.

---

## ✦ Features

| Area | What it does |
|---|---|
| **Hero** | Terminal window UI with animated prompt, name, tagline, and CTA buttons |
| **Projects** | Card grid with a dynamic filter bar built from tech tags |
| **About** | Bio paragraphs + skill category cards, all editable from admin |
| **Contact** | Contact form with social links pulled from profile data |
| **Admin Panel** | Full CMS — manage profile, photo, resume, links, projects, and skills |
| **File Uploads** | Upload profile photo (JPG/PNG/WEBP) and resume (PDF) directly from admin |
| **Flat file storage** | All data lives in `data/data.php` — zero database required |
| **Session auth** | Simple session-based login protecting the admin panel |

---

## ✦ Tech Stack

```
Language   →  PHP 7.4+
Styling    →  Vanilla CSS (CSS custom properties)
Scripts    →  Vanilla JavaScript (no jQuery, no frameworks)
Fonts      →  JetBrains Mono + Inter (Google Fonts)
Storage    →  Flat PHP file (var_export)
Server     →  Apache via XAMPP (or any PHP server)
```

---

## ✦ Project Structure

```
portfolio/
│
├── index.php               # Home — hero section
├── about.php               # About — bio + skills
├── projects.php            # Projects — filterable card grid
├── contact.php             # Contact — form + social links
│
├── sections/               # Page section partials
│   ├── hero.php
│   ├── about.php
│   ├── projects.php
│   └── contact.php
│
├── includes/               # Shared layout partials
│   ├── nav.php             # Navbar with active state via $page variable
│   └── footer.php
│
├── data/
│   └── data.php            # ← Single source of truth for all content
│
├── assets/
│   ├── css/style.css       # Main stylesheet
│   └── js/main.js          # Filter bar + hamburger toggle
│
├── uploads/                # User-uploaded files (auto-created)
│   ├── photos/
│   ├── resumes/
│   └── projects/
│
└── admin/
    ├── index.php           # Login page
    ├── dashboard.php       # Main CMS dashboard (3 tabs)
    ├── auth.php            # Session guard
    ├── helpers.php         # saveData() + handleUpload() + nextId()
    ├── logout.php          # Session destroy + redirect
    ├── admin.css           # Admin-specific styles
    └── admin.js            # Tab switching + file input feedback
```

---

## ✦ Getting Started with XAMPP

**1. Place the project in htdocs**

```
C:\xampp\htdocs\portfolio\
```

**2. Start Apache in XAMPP Control Panel**

MySQL is not needed — this project uses no database.

**3. Open in your browser**

```
http://localhost/portfolio/
```

**4. Access the admin panel**

```
http://localhost/portfolio/admin/
```

---

## ✦ Admin Panel

Login with the default credentials:

```
Username:  admin
Password:  admin123
```

> Change these in `admin/index.php` before deploying publicly.

### Tabs

**👤 Profile**
- Upload a profile photo (JPG, PNG, WEBP — max 5MB)
- Upload your resume as a PDF (max 5MB), or paste a URL
- Edit your name, tagline, and bio paragraphs
- Set GitHub, LinkedIn, Twitter/X, and personal website links
- Set your contact email

**📁 Projects**
- Add new projects with title, description, tech tags, link, and image
- Upload a project image or paste an image URL
- Inline edit or delete any existing project
- Tech tags drive the filter bar on the public projects page automatically

**🛠 Skills**
- Add skill categories with an emoji icon and title
- Items are comma-separated (e.g. `PHP, MySQL, REST APIs`)
- Inline edit or delete any category

---

## ✦ Data Layer

Everything is stored in `data/data.php` as plain PHP arrays:

```php
$profile = [
    'name'     => 'Ayush',
    'tagline'  => '...',
    'bio'      => ['paragraph 1', 'paragraph 2'],
    'photo'    => 'uploads/photos/abc123.jpg',
    'resume'   => 'uploads/resumes/resume.pdf',
    'email'    => 'you@example.com',
    'github'   => 'https://github.com/username',
    'linkedin' => 'https://linkedin.com/in/username',
    'twitter'  => '',
    'website'  => '',
];

$projects = [
    [
        'id'          => 1,
        'title'       => 'Project Name',
        'description' => '...',
        'tech'        => ['PHP', 'MySQL'],
        'link'        => 'https://github.com/...',
        'img'         => 'uploads/projects/abc.jpg',
    ],
];

$skillCategories = [
    [
        'id'    => 1,
        'icon'  => '⚙️',
        'title' => 'Backend',
        'items' => ['PHP', 'MySQL', 'REST APIs'],
    ],
];
```

The admin panel writes back to this file using `var_export()` — no SQL, no ORM, no migrations.

---

## ✦ Color Palette

```css
--bg:       #0d1117   /* page background      */
--bg2:      #161b22   /* cards, sidebar        */
--bg3:      #1c2128   /* inputs, code blocks   */
--border:   #30363d   /* borders               */
--text:     #c9d1d9   /* body text             */
--text-dim: #8b949e   /* muted / labels        */
--accent:   #4fc3f7   /* cyan — primary        */
--accent2:  #56d364   /* green — success/tags  */
--red:      #ff7b72   /* errors, delete        */
--purple:   #bc8cff   /* keywords              */
--yellow:   #e3b341   /* warnings              */
```

---

## ✦ Customization

| What | Where |
|---|---|
| Your name, bio, links | Admin → Profile tab |
| Projects | Admin → Projects tab |
| Skills | Admin → Skills tab |
| Color theme | `assets/css/style.css` — edit CSS variables in `:root` |
| Nav link labels | `includes/nav.php` — edit the `$navItems` array |
| Footer text | `includes/footer.php` |
| Admin credentials | `admin/index.php` — change the hardcoded check |

---

## ✦ Deployment Notes

- Make sure `data/data.php` and the `uploads/` directory are **writable** by the web server
- On Linux/Mac: `chmod 755 uploads/ && chmod 644 data/data.php`
- Change the admin password before going live
- For production, consider adding CSRF protection to the admin forms

---

## ✦ License

MIT — use it, fork it, make it yours.

---

<p align="center">
  <code>// made with ☕ and too many terminal windows</code>
</p>
