<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
	header('Location: login.php');
	exit;
}

$message = '';
$error = '';

function ensureDir($path) {
	if (!is_dir($path)) {
		@mkdir($path, 0775, true);
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!isset($_POST['csrf']) || !isset($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
		$error = 'Ungültiges CSRF-Token.';
	} else {
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$year = isset($_POST['year']) ? intval($_POST['year']) : 0;
		$targetDir = '';
		if ($category === 'kks') {
			$targetDir = __DIR__ . '/../results/kks/';
		} elseif ($category === 'km' && $year > 0) {
			$targetDir = __DIR__ . '/../results/km_' . $year . '/';
		} else {
			$error = 'Bitte Kategorie und Jahr korrekt auswählen.';
		}
		if (!$error) {
			ensureDir($targetDir);
			if (!empty($_FILES['files'])) {
				$uploaded = 0;
				foreach ($_FILES['files']['tmp_name'] as $idx => $tmp) {
					if (!is_uploaded_file($tmp)) { continue; }
					$name = basename($_FILES['files']['name'][$idx]);
					$dest = $targetDir . $name;
					if (move_uploaded_file($tmp, $dest)) { $uploaded++; }
				}
				$message = $uploaded . ' Datei(en) hochgeladen.';
			}
		}
	}
}

?>
<!doctype html>
<html lang="">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="SRD | Admin Uploads">
<meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
<title>SRD | Admin Uploads</title>
<link rel="shortcut icon" type="image/x-icon" href="../themes/images/favicon.ico">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../assets/css/propeller.min.css">
<link rel="stylesheet" type="text/css" href="../themes/css/propeller-theme.css" />
<link rel="stylesheet" type="text/css" href="../themes/css/propeller-admin.css">
<link rel="stylesheet" type="text/css" href="../themes/css/custom.css">
</head>
<body>
<div class="pmd-content inner-page">
	<div class="container">
		<h1 class="section-title">PDF-Uploads</h1>
		<p>
			<a href="index.php" class="btn pmd-btn-raised pmd-ripple-effect btn-default">Zurück</a>
			<a href="logout.php" class="btn pmd-btn-raised pmd-ripple-effect btn-default">Logout</a>
		</p>
		<?php if ($message) { echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
		<?php if ($error) { echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>'; } ?>
		<div class="pmd-card pmd-z-depth">
			<div class="pmd-card-body">
				<form action="" method="post" enctype="multipart/form-data">
					<?php $_SESSION['csrf'] = bin2hex(random_bytes(32)); ?>
					<input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['csrf']); ?>">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Kategorie</label>
								<select class="form-control" name="category" required>
									<option value="">Bitte wählen</option>
									<option value="kks">Kreiskönigsschießen</option>
									<option value="km">Kreismeisterschaften</option>
								</select>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Jahr (für KM)</label>
								<input type="number" class="form-control" name="year" min="2000" max="2100" placeholder="z.B. 2025">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>PDF-Dateien</label>
						<input type="file" name="files[]" class="form-control" accept="application/pdf" multiple required>
						<p class="help-block">Dateinamen beachten (KM: e<ID>.pdf / m<ID>.pdf)</p>
					</div>
					<button type="submit" class="btn pmd-btn-raised pmd-ripple-effect btn-success">Hochladen</button>
				</form>
			</div>
		</div>

		<div class="pmd-card pmd-z-depth" style="margin-top:16px;">
			<div class="pmd-card-body">
				<h3>Vorhandene Dateien</h3>
				<div class="row">
					<div class="col-sm-6">
						<h4>KKS</h4>
						<pre style="white-space:pre-wrap;">
<?php
$dir = __DIR__ . '/../results/kks/';
if (is_dir($dir)) {
	$files = array_diff(scandir($dir), array('..', '.'));
	foreach ($files as $f) { echo htmlspecialchars($f) . "\n"; }
}
?>
						</pre>
					</div>
					<div class="col-sm-6">
						<h4>KM (aktuelles Jahr)</h4>
						<pre style="white-space:pre-wrap;">
<?php
$y = intval(date('Y'));
$dir2 = __DIR__ . '/../results/km_' . $y . '/';
if (is_dir($dir2)) {
	$files2 = array_diff(scandir($dir2), array('..', '.'));
	foreach ($files2 as $f) { echo htmlspecialchars($f) . "\n"; }
}
?>
						</pre>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="../assets/js/jquery-1.12.2.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/propeller.min.js"></script>
</body>
</html>


