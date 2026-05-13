<?php
// RWK Feuerwaffen - Archiv bis 2022/23
?>

<!doctype html>
<html lang="de" data-bs-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SRD | RWK Feuerwaffen</title>
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
				<li class="breadcrumb-item active">RWK Feuerwaffen</li>
			</ol>
		</nav>

		<!-- Page Header -->
		<div class="row mb-4">
			<div class="col">
				<h1 class="display-6 fw-bold text-primary">RWK Feuerwaffen</h1>
				<p class="lead text-muted">Archiv der Kreisrundenwettkämpfe Feuerwaffen</p>
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
						Die aktuellen Kreisrundenwettkämpfe werden seit 2023 über die externe Ligaverwaltung abgewickelt.
						<br>
						<a href="https://www.rwk-onlinemelder.de/online/listen/nssvksv09" target="_blank" class="btn btn-primary mt-2">
							<i class="bi bi-box-arrow-up-right me-1"></i>Zur aktuellen Ligaverwaltung
						</a>
					</p>
				</div>
			</div>
		</div>

		<!-- Archive Table -->
		<div class="row">
			<div class="col-12">
				<div class="card shadow-sm">
					<div class="card-header bg-primary text-white">
						<h5 class="card-title mb-0">
							<i class="bi bi-archive me-2"></i>Archiv RWK Feuerwaffen (bis 2022/23)
						</h5>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-hover table-striped mb-0">
								<thead class="table-primary">
									<tr>
										<th class="col-year">Jahr</th>
										<th class="col-equal text-center">Einteilung</th>
										<th class="col-equal text-center">KK-Gewehr Auflage</th>
										<th class="col-equal text-center">KK-Sportpistole</th>
										<th class="col-equal text-center">Großkaliber</th>
									</tr>
								</thead>
								<tbody>
									<?php
									// RWK Jahre von 2023 bis 2013
									$years = array(2023, 2019, 2018, 2017, 2016, 2015, 2014, 2013);
									
									foreach ($years as $year) {
										echo '<tr>';
										echo '<td><strong>' . $year . '</strong></td>';
										
										// Einteilung
										echo '<td class="text-center">';
										$einteilungPath = "results/rwk_" . $year . "/Einteilung_KK_" . $year . ".pdf";
										if (file_exists($einteilungPath)) {
											echo '<a href="' . $einteilungPath . '" target="_blank" class="btn btn-outline-primary btn-sm">';
											echo '<i class="bi bi-file-earmark-pdf me-1"></i>PDF';
											echo '</a>';
										} else {
											echo '<span class="text-muted">n/a</span>';
										}
										echo '</td>';
										
										// KK-Gewehr Auflage
										echo '<td class="text-center">';
										echo '<a href="krw_kka.php?year=' . $year . '" class="btn btn-outline-success btn-sm">';
										echo '<i class="bi bi-link me-1"></i>Link';
										echo '</a>';
										echo '</td>';
										
										// KK-Sportpistole
										echo '<td class="text-center">';
										echo '<a href="krw_kkspo.php?year=' . $year . '" class="btn btn-outline-success btn-sm">';
										echo '<i class="bi bi-link me-1"></i>Link';
										echo '</a>';
										echo '</td>';
										
										// Großkaliber
										echo '<td class="text-center">';
										if ($year >= 2015) {
											echo '<a href="krw_grk.php?year=' . $year . '" class="btn btn-outline-success btn-sm">';
											echo '<i class="bi bi-link me-1"></i>Link';
											echo '</a>';
										} else {
											echo '<span class="text-muted">-</span>';
										}
										echo '</td>';
										
										echo '</tr>';
									}
									?>
								</tbody>
							</table>
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
	document.getElementById('pageTitle').textContent = 'RWK Feuerwaffen';
});
</script>

</body>
</html>

