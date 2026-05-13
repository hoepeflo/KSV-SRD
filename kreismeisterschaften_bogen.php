<?php
$jahr = isset($_GET["year"]) ? intval($_GET["year"]) : null;
if (!$jahr) {
	header('Location: km.php');
	exit;
}
?>

<!doctype html>
<html lang="de" data-bs-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SRD | Kreismeisterschaften Bogen <?php echo $jahr ?></title>
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
		<!-- Breadcrumb -->
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Ergebnishistorie</a></li>
				<li class="breadcrumb-item"><a href="km.php">Kreismeisterschaften</a></li>
				<li class="breadcrumb-item active">Bogen <?php echo $jahr; ?></li>
			</ol>
		</nav>

		<!-- Page Header -->
		<div class="row mb-4">
			<div class="col">
				<h1 class="display-6 fw-bold text-primary">Kreismeisterschaften Bogen <?php echo $jahr; ?></h1>
				<p class="lead text-muted">Ergebnisse der Bogenwettbewerbe</p>
			</div>
		</div>

		<!-- Info Box -->
		<div class="row mb-4">
			<div class="col-12">
				<div class="alert alert-info">
					<h5 class="alert-heading">
						<i class="bi bi-info-circle me-2"></i>Hinweis
					</h5>
					<p class="mb-0">
						Die Bogenwettbewerbe werden separat von den Hauptdisziplinen durchgeführt.
						<br>
						Ergebnisse werden hier veröffentlicht, sobald sie verfügbar sind.
					</p>
				</div>
			</div>
		</div>

		<!-- Results Table -->
		<div class="row">
			<div class="col-12">
				<div class="card shadow-sm">
					<div class="card-header bg-primary text-white">
						<h5 class="card-title mb-0">
							<i class="bi bi-bullseye me-2"></i>Bogenwettbewerbe <?php echo $jahr; ?>
						</h5>
					</div>
					<div class="card-body">
						<div class="text-center py-5">
							<i class="bi bi-bullseye display-1 text-muted mb-3"></i>
							<h4 class="text-muted">Ergebnisse werden hier veröffentlicht</h4>
							<p class="text-muted">Sobald die Bogenwettbewerbe abgeschlossen sind, werden die Ergebnisse hier angezeigt.</p>
							<a href="km.php" class="btn btn-primary">
								<i class="bi bi-arrow-left me-1"></i>Zurück zu Kreismeisterschaften
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php include 'conf/footer.php'; ?>

<!-- Page title script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
	document.getElementById('pageTitle').textContent = 'Bogen <?php echo $jahr; ?>';
});
</script>

</body>
</html>
