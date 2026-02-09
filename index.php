<?php

declare(strict_types=1);

require __DIR__ . '/security.php';
require __DIR__ . '/database.php';
enforceSecurityHeaders();
enforceRateLimit('portal-index', 120, 60);

require __DIR__ . '/data.php';
$data = getPortalData();
$counts = [
  'timeline' => count($data['timeline']),
  'articles' => count($data['timeline']),
  'problems' => count($data['problems']),
  'projects' => count($data['projects']),
  'scientists' => count($data['scientists']),
];
$totalContent = $counts['timeline'] + $counts['problems'] + $counts['projects'] + $counts['scientists'];
$stats = getPortalStats();
logPortalVisit('index');
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Matematik Tarihi Akademik Portal</title>
  <link rel="stylesheet" href="styles.css">
  <script>
    window.PORTAL_DATA = <?= json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
  </script>
  <script defer src="script.js"></script>
  <script>
    window.MathJax = { tex: { inlineMath: [["$", "$"], ["\\(", "\\)"]] } };
  </script>
  <script async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
</head>
<body>
<header class="header">
  <div class="brand">Matematik Tarihi Akademik Portal</div>
  <nav>
    <a href="#timeline">Zaman Çizelgesi</a>
    <a href="#articles">Makaleler</a>
    <a href="#problems">Problemler</a>
    <a href="#projects">Projeler</a>
    <a href="bibliography.php">Kaynakça Sayfası</a>
  </nav>
</header>

<section class="controls">
  <input id="searchInput" type="text" placeholder="Makale, problem, proje veya kaynak ara">
  <select id="levelSelect">
    <option value="all">Tüm Sınıflar</option>
    <?php for ($i = 5; $i <= 12; $i++): ?>
      <option value="<?= $i ?>"><?= $i ?>. Sınıf</option>
    <?php endfor; ?>
  </select>
  <div class="tabs">
    <button class="tab active" data-tab="timeline">Zaman Çizelgesi</button>
    <button class="tab" data-tab="articles">Makaleler</button>
    <button class="tab" data-tab="problems">Problemler</button>
    <button class="tab" data-tab="projects">Projeler</button>
    <button class="tab" data-tab="scientists">Bilim İnsanları</button>
  </div>
</section>

<section class="status-panel">
  <div class="status-card">
    <h2>Sistem Durumu</h2>
    <ul>
      <li><strong>Toplam içerik:</strong> <?= number_format($totalContent) ?> kayıt</li>
      <li><strong>SQL günlük kayıtları:</strong> <?= number_format($stats['total_visits']) ?> ziyaret</li>
      <li><strong>Son 24 saat:</strong> <?= number_format($stats['last_24h']) ?> istek</li>
      <li><strong>DDoS/DoS Limiti:</strong> 60 sn içinde 120 istek</li>
    </ul>
  </div>
  <div class="status-card">
    <h2>İçerik Dağılımı</h2>
    <ul>
      <li><strong>Zaman Çizelgesi:</strong> <?= number_format($counts['timeline']) ?></li>
      <li><strong>Makaleler:</strong> <?= number_format($counts['articles']) ?></li>
      <li><strong>Problemler:</strong> <?= number_format($counts['problems']) ?></li>
      <li><strong>Projeler:</strong> <?= number_format($counts['projects']) ?></li>
      <li><strong>Bilim İnsanları:</strong> <?= number_format($counts['scientists']) ?></li>
    </ul>
  </div>
</section>

<main id="content"></main>

<div id="detailModal" class="modal-overlay" aria-hidden="true">
  <div class="modal">
    <button id="closeModal" class="close">✕</button>
    <h2 id="modalTitle"></h2>
    <p id="modalDescription"></p>
    <h3>Adım Adım Çözüm</h3>
    <ol id="modalSteps"></ol>
  </div>
</div>
</body>
</html>
