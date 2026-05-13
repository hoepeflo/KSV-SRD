<?php
require_once __DIR__ . '/../conf/session.php';
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
	header('Location: login.php');
	exit;
}

require_once __DIR__ . '/../conf/db_d.php';

$error = '';
$tables = [];

if ($con && !$con->connect_error) {
	$res = $con->query('SHOW TABLES');
	if ($res) {
		while ($row = $res->fetch_row()) {
			$tables[] = $row[0];
		}
		sort($tables, SORT_STRING);
	} else {
		$error = 'Tabellen konnten nicht gelesen werden: ' . htmlspecialchars($con->error);
	}
} else {
	$error = 'Keine Datenbankverbindung.';
}

/**
 * @param mixed $value
 */
function srd_sql_export_quote_value(mysqli $mysqli, $value): string
{
	if ($value === null) {
		return 'NULL';
	}
	return "'" . $mysqli->real_escape_string((string) $value) . "'";
}

function srd_sql_export_quote_ident(string $name): string
{
	return '`' . str_replace('`', '``', $name) . '`';
}

/**
 * @return array{0: string[], 1: string[]} [quoted identifiers, raw field names]
 */
function srd_sql_export_columns_meta(mysqli $mysqli, string $table): array
{
	$idents = [];
	$fields = [];
	$r = $mysqli->query('SHOW COLUMNS FROM ' . srd_sql_export_quote_ident($table));
	if (!$r) {
		return [[], []];
	}
	while ($row = $r->fetch_assoc()) {
		$fields[] = $row['Field'];
		$idents[] = srd_sql_export_quote_ident($row['Field']);
	}
	return [$idents, $fields];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'export') {
	if (!isset($_POST['csrf']) || !isset($_SESSION['csrf_export']) || !hash_equals($_SESSION['csrf_export'], (string) $_POST['csrf'])) {
		$error = 'Ungültiges CSRF-Token.';
	} elseif (!$con || $con->connect_error) {
		$error = 'Keine Datenbankverbindung.';
	} else {
		$posted = isset($_POST['tables']) && is_array($_POST['tables']) ? $_POST['tables'] : [];
		$posted = array_values(array_unique(array_map('strval', $posted)));
		$selected = array_values(array_intersect($posted, $tables));
		if ($selected === []) {
			$error = 'Bitte mindestens eine Tabelle auswählen.';
		} else {
			$dbLabel = isset($name) ? (string) $name : 'database';
			$filename = 'srd_export_' . preg_replace('/[^a-zA-Z0-9_-]+/', '_', $dbLabel) . '_' . date('Y-m-d_His') . '.sql';

			header('Content-Type: application/sql; charset=utf-8');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('X-Content-Type-Options: nosniff');

			echo "-- SRD SQL-Export\n";
			echo '-- ' . date('c') . "\n";
			echo '-- Datenbank: ' . $dbLabel . "\n\n";
			echo "SET NAMES utf8mb4;\n";
			echo "SET FOREIGN_KEY_CHECKS=0;\n\n";

			$chunk = 500;
			$valuesPerInsert = 50;

			foreach ($selected as $table) {
				echo "\n-- ----------------------------\n";
				echo '-- Tabelle ' . srd_sql_export_quote_ident($table) . "\n";
				echo "-- ----------------------------\n";

				$cr = $con->query('SHOW CREATE TABLE ' . srd_sql_export_quote_ident($table));
				if (!$cr) {
					echo '-- FEHLER SHOW CREATE TABLE: ' . $con->error . "\n";
					continue;
				}
				$createRow = $cr->fetch_assoc();
				$createSql = $createRow['Create Table'] ?? $createRow['Create table'] ?? reset($createRow);
				if (!is_string($createSql)) {
					echo '-- FEHLER: CREATE TABLE nicht lesbar' . "\n";
					continue;
				}
				echo 'DROP TABLE IF EXISTS ' . srd_sql_export_quote_ident($table) . ";\n";
				echo $createSql . ";\n\n";

				[$colIdents, $fieldNames] = srd_sql_export_columns_meta($con, $table);
				if ($colIdents === [] || $fieldNames === []) {
					echo '-- Keine Spalten oder SHOW COLUMNS fehlgeschlagen' . "\n\n";
					continue;
				}
				$colList = implode(', ', $colIdents);
				$tIdent = srd_sql_export_quote_ident($table);

				$offset = 0;
				while (true) {
					$limit = (int) $chunk;
					$off = (int) $offset;
					$sel = "SELECT * FROM {$tIdent} LIMIT {$limit} OFFSET {$off}";
					$data = $con->query($sel);
					if (!$data) {
						echo '-- FEHLER SELECT: ' . $con->error . "\n";
						break;
					}
					if ($data->num_rows === 0) {
						break;
					}

					$batchValues = [];
					while ($row = $data->fetch_assoc()) {
						$vals = [];
						foreach ($fieldNames as $fn) {
							$cell = array_key_exists($fn, $row) ? $row[$fn] : null;
							$vals[] = srd_sql_export_quote_value($con, $cell);
						}
						$batchValues[] = '(' . implode(',', $vals) . ')';
						if (count($batchValues) >= $valuesPerInsert) {
							echo 'INSERT INTO ' . $tIdent . ' (' . $colList . ") VALUES\n" . implode(",\n", $batchValues) . ";\n\n";
							$batchValues = [];
						}
					}
					if ($batchValues !== []) {
						echo 'INSERT INTO ' . $tIdent . ' (' . $colList . ") VALUES\n" . implode(",\n", $batchValues) . ";\n\n";
					}
					$offset += $chunk;
				}
			}

			echo "\nSET FOREIGN_KEY_CHECKS=1;\n";
			exit;
		}
	}
}

$_SESSION['csrf_export'] = bin2hex(random_bytes(32));
?>
<!doctype html>
<html lang="de" data-bs-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SRD | SQL-Export</title>
<link rel="shortcut icon" type="image/x-icon" href="../themes/images/favicon.ico">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="../themes/css/brand.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	<div class="container">
		<a class="navbar-brand" href="../index.php">
			<img src="../themes/images/ksv-logo.png" alt="KSV Logo" height="30" class="me-2">
			SRD Admin
		</a>
		<div class="navbar-nav ms-auto">
			<a class="nav-link" href="index.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
			<a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
		</div>
	</div>
</nav>

<div class="container py-4">
	<h1 class="display-6 fw-bold text-primary mb-3">
		<i class="bi bi-database-down me-2"></i>SQL-Export
	</h1>
	<p class="text-muted">Wählen Sie Tabellen aus und laden Sie eine <code>.sql</code>-Datei herunter (Struktur und Daten).</p>

	<?php if ($error) { ?>
		<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
	<?php } ?>

	<?php if ($tables === []) { ?>
		<div class="alert alert-warning">Keine Tabellen gefunden oder Datenbank nicht erreichbar.</div>
	<?php } else { ?>
		<form method="post" action="" id="exportForm">
			<input type="hidden" name="action" value="export">
			<input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['csrf_export']); ?>">

			<div class="card shadow-sm mb-3">
				<div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
					<span class="fw-semibold">Tabellen (<?php echo count($tables); ?>)</span>
					<div class="btn-group btn-group-sm">
						<button type="button" class="btn btn-outline-primary" id="btnAll">Alle auswählen</button>
						<button type="button" class="btn btn-outline-secondary" id="btnNone">Keine</button>
					</div>
				</div>
				<div class="card-body" style="max-height: 28rem; overflow-y: auto;">
					<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
						<?php foreach ($tables as $t) { ?>
							<div class="col">
								<div class="form-check">
									<input class="form-check-input tbl-cb" type="checkbox" name="tables[]" value="<?php echo htmlspecialchars($t); ?>" id="tbl_<?php echo htmlspecialchars(md5($t)); ?>">
									<label class="form-check-label text-break" for="tbl_<?php echo htmlspecialchars(md5($t)); ?>"><?php echo htmlspecialchars($t); ?></label>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">
						<i class="bi bi-download me-1"></i>Export herunterladen
					</button>
				</div>
			</div>
		</form>
		<div class="alert alert-info small mb-0">
			<strong>Hinweis:</strong> Der Export erfolgt im Browser als Download. Sehr große Tabellen können länger dauern. Wiederherstellung z.&nbsp;B. mit phpMyAdmin oder <code>mysql</code> auf der Kommandozeile.
		</div>
	<?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../themes/js/dark-mode.js"></script>
<script>
document.getElementById('btnAll')?.addEventListener('click', function() {
	document.querySelectorAll('.tbl-cb').forEach(function(cb) { cb.checked = true; });
});
document.getElementById('btnNone')?.addEventListener('click', function() {
	document.querySelectorAll('.tbl-cb').forEach(function(cb) { cb.checked = false; });
});
</script>
</body>
</html>
