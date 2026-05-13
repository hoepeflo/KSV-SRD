<?php
session_start();
$cfg = include __DIR__ . '/../conf/admin.php';
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
	header('Location: login.php');
	exit;
}
?>
<!doctype html>
<html lang="de" data-bs-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SRD | Admin</title>
<link rel="shortcut icon" type="image/x-icon" href="../themes/images/favicon.ico">

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- Custom Brand CSS -->
<link rel="stylesheet" href="../themes/css/brand.css">
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	<div class="container">
		<a class="navbar-brand" href="../index.php">
			<img src="../themes/images/ksv-logo.png" alt="KSV Logo" height="30" class="me-2">
			SRD Admin
		</a>
		<div class="navbar-nav ms-auto">
			<a class="nav-link" href="logout.php">
				<i class="bi bi-box-arrow-right me-1"></i>Logout
			</a>
		</div>
	</div>
</nav>

<!-- Main Content -->
<div class="container py-4">
	<div class="row">
		<div class="col-12">
			<h1 class="display-6 fw-bold text-primary mb-4">
				<i class="bi bi-speedometer2 me-2"></i>Admin-Dashboard
			</h1>
			
			<div class="alert alert-success" role="alert">
				<i class="bi bi-person-check me-2"></i>
				Angemeldet als <strong><?php echo htmlspecialchars($cfg['username']); ?></strong>
			</div>

			<div class="row mb-4 g-3">
				<div class="col-md-4">
					<div class="card h-100">
						<div class="card-body text-center">
							<i class="bi bi-cloud-upload display-4 text-primary mb-3"></i>
							<h5 class="card-title">PDF-Uploads</h5>
							<p class="card-text">Verwalten Sie Ergebnisdateien für KKS und KM</p>
							<a href="uploads.php" class="btn btn-primary">
								<i class="bi bi-upload me-1"></i>Uploads verwalten
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card h-100">
						<div class="card-body text-center">
							<i class="bi bi-database-down display-4 text-primary mb-3"></i>
							<h5 class="card-title">SQL-Export</h5>
							<p class="card-text">Ausgewählte Datenbanktabellen als <code>.sql</code> sichern</p>
							<a href="sql_export.php" class="btn btn-primary">
								<i class="bi bi-download me-1"></i>Export starten
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card h-100">
						<div class="card-body text-center">
							<i class="bi bi-info-circle display-4 text-info mb-3"></i>
							<h5 class="card-title">Informationen</h5>
							<p class="card-text">Dateikonventionen und Pfade</p>
							<button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#infoModal">
								<i class="bi bi-info me-1"></i>Anzeigen
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Dateikonventionen</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<h6>Kreiskönigsschießen PDFs:</h6>
				<p><code>results/kks/</code></p>
				<ul>
					<li><code>YYYY_Kreiskoenig.pdf</code></li>
					<li><code>YYYY_Kreiskoenigin.pdf</code></li>
					<li><code>YYYY_Kreisjugendkoenig.pdf</code></li>
					<li><code>YYYY_Kreislichtpunktkoenig.pdf</code></li>
					<li><code>YYYY_Kaiserpokal.pdf</code></li>
					<li><code>YYYY_Koeniginnenpokal.pdf</code></li>
				</ul>
				
				<h6>Kreismeisterschaften PDFs:</h6>
				<p><code>results/km_YYYY/</code></p>
				<ul>
					<li>Einzel: <code>e&lt;ID&gt;.pdf</code></li>
					<li>Mannschaft: <code>m&lt;ID&gt;.pdf</code></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Dark Mode Toggle -->
<script src="../themes/js/dark-mode.js"></script>
</body>
</html>


