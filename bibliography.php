<?php

declare(strict_types=1);

require __DIR__ . '/security.php';
require __DIR__ . '/database.php';
enforceSecurityHeaders();
enforceRateLimit('portal-bibliography', 90, 60);

require __DIR__ . '/data.php';
$data = getPortalData();
$items = $data['bibliography'];
$stats = getPortalStats();
logPortalVisit('bibliography');
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kaynakça - Matematik Tarihi Portal</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="header">
  <div class="brand">Kaynakça Merkezi</div>
  <nav><a href="index.php">← Portala Dön</a></nav>
</header>

<main class="bibliography-page">
  <h1>Akademik Kaynakça</h1>
  <p>Zaman çizelgesinde kullanılan makale ve kaynakların listesi.</p>
  <div class="status-inline">
    <span><strong>Toplam ziyaret:</strong> <?= number_format($stats['total_visits']) ?></span>
    <span><strong>Son 24 saat:</strong> <?= number_format($stats['last_24h']) ?> istek</span>
  </div>
  <div class="list">
    <?php foreach ($items as $item): ?>
      <article class="biblio-item">
        <h3><?= htmlspecialchars($item['article']) ?></h3>
        <p><strong>Kaynak:</strong> <?= htmlspecialchars($item['source']) ?></p>
        <p><strong>Yıl:</strong> <?= (int) $item['year'] ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</main>
</body>
</html>
