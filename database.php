<?php

declare(strict_types=1);

function getPortalDb(): ?PDO
{
    if (!extension_loaded('pdo_sqlite')) {
        return null;
    }

    $storageDir = __DIR__ . '/storage';
    if (!is_dir($storageDir)) {
        mkdir($storageDir, 0755, true);
    }

    $dbPath = $storageDir . '/portal.sqlite';
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS visits (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            page TEXT NOT NULL,
            ip TEXT NOT NULL,
            user_agent TEXT NOT NULL,
            created_at TEXT NOT NULL
        )'
    );
    $pdo->exec('CREATE INDEX IF NOT EXISTS idx_visits_created_at ON visits(created_at)');

    return $pdo;
}

function logPortalVisit(string $page): void
{
    $pdo = getPortalDb();
    if (!$pdo) {
        return;
    }

    $stmt = $pdo->prepare('INSERT INTO visits (page, ip, user_agent, created_at) VALUES (:page, :ip, :ua, :created_at)');
    $stmt->execute([
        ':page' => $page,
        ':ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        ':ua' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        ':created_at' => gmdate('Y-m-d H:i:s'),
    ]);
}

function getPortalStats(): array
{
    $pdo = getPortalDb();
    if (!$pdo) {
        return [
            'total_visits' => 0,
            'last_24h' => 0,
        ];
    }

    $total = (int) $pdo->query('SELECT COUNT(*) FROM visits')->fetchColumn();
    $last24hStmt = $pdo->prepare('SELECT COUNT(*) FROM visits WHERE created_at >= :since');
    $last24hStmt->execute([':since' => gmdate('Y-m-d H:i:s', time() - 86400)]);
    $last24h = (int) $last24hStmt->fetchColumn();

    return [
        'total_visits' => $total,
        'last_24h' => $last24h,
    ];
}
