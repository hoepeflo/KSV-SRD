<!doctype html>
<html lang="de" data-bs-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SRD | Ergebnisdienst des KSV Fallingbostel</title>
<meta name="description" content="SRD | Ergebnisdienst des KSV Fallingbostel"/>

<link rel="shortcut icon" type="image/x-icon" href="themes/images/favicon.ico">
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- Custom Brand CSS -->
<link rel="stylesheet" href="themes/css/brand.css">
</head>
<body>
<?php include 'conf/nav.php'; ?>
<main class="main-content">
	<div class="container-fluid py-4">
		<div class="row g-3">
			<div class="col-12">
				<h1 class="display-6 fw-bold text-primary mb-4">Ergebnisse</h1>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body text-center">
						<div class="display-6 text-success mb-2">📊</div>
						<h5 class="card-title">Kreismeisterschaften</h5>
						<a href="km.php" class="btn btn-success">Öffnen</a>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body text-center">
						<div class="display-6 text-success mb-2">🧭</div>
						<h5 class="card-title">Kreisrundenwettkämpfe</h5>
						<a target="_blank" href="https://www.rwk-onlinemelder.de/online/listen/nssvksv09" class="btn btn-success">Zur Ligaverwaltung</a>
						<div class="mt-2"><a href="krw_luft.php" class="link-success">Archiv (bis 2022/23)</a></div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body text-center">
						<div class="display-6 text-success mb-2">⭐</div>
						<h5 class="card-title">Kreiskönigsschießen</h5>
						<a href="kks_results.php" class="btn btn-success">Öffnen</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php include 'conf/footer.php'; ?>

<!-- Set Page Title -->
<script>
document.addEventListener('DOMContentLoaded', function() {
	document.getElementById('pageTitle').textContent = 'Ergebnisse';
});
</script>
</body>
</html>


