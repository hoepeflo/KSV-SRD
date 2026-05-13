
<!doctype html>
<html lang="de" data-bs-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SRD | Kreiskönigsschießen</title>
<link rel="shortcut icon" type="image/x-icon" href="themes/images/favicon.ico">

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!-- Custom Brand CSS -->
<link rel="stylesheet" href="themes/css/brand.css">

</head>

<body>
<!-- Header Starts -->

<?php include 'conf/nav.php'; ?>

<!-- Main Content -->
<main class="main-content">
<div class="container-fluid py-4">
	<!-- Breadcrumb -->
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Ergebnishistorie</a></li>
			<li class="breadcrumb-item active">Kreiskönigsschießen</li>
		</ol>
	</nav>

	<!-- Page Header -->
	<div class="row mb-4">
		<div class="col">
			<h1 class="display-6 fw-bold text-primary">Kreiskönigsschießen</h1>
			<p class="lead text-muted">Ergebnisse der Kreiskönigswettbewerbe</p>
		</div>
	</div>

	<!-- Results Table -->
	<div class="row">
		<div class="col-12">
			<div class="card shadow-sm">
				<div class="card-header bg-primary text-white">
					<h5 class="card-title mb-0">
						<i class="bi bi-trophy me-2"></i>Ergebnisse Kreiskönigsschießen
					</h5>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-hover table-striped mb-0">
							<thead class="table-primary">
							<tr>
								<th class="col-year">Jahr</th>
								<th class="col-equal">Kreiskönig</th>
								<th class="col-equal">Kreiskönigin</th>
								<th class="col-equal">Kreisjugendkönig*in</th>
								<th class="col-equal">Kreislichtpunktkönig*in</th>
								<th class="col-equal">Kaiserpokal</th>
								<th class="col-equal">Königinnenpokal</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$root = __DIR__ . '/results/kks/';
						$labels = array(
							'Kreiskoenig' => 'Kreiskönig',
							'Kreiskoenigin' => 'Kreiskönigin',
							'Kreisjugendkoenig' => 'Kreisjugendkönig*in',
							'Kreislichtpunktkoenig' => 'Kreislichtpunktkönig*in',
							'Kaiserpokal' => 'Kaiserpokal',
							'Koeniginnenpokal' => 'Königinnenpokal'
						);
						$years = array();
						if (is_dir($root)) {
							$files = array_diff(scandir($root), array('..', '.'));
							foreach ($files as $f) {
								if (preg_match('/^(\\d{4})_([A-Za-z]+)\\.pdf$/', $f, $m)) {
									$y = intval($m[1]);
									$key = $m[2];
									if (!isset($years[$y])) { $years[$y] = array(); }
									$years[$y][$key] = $f;
								}
							}
						}
						krsort($years);
						foreach ($years as $y => $cols) {
							echo '<tr>';
							echo '<td><strong>' . $y . '</strong></td>';
							foreach ($labels as $key => $label) {
								if (isset($cols[$key])) {
									$href = 'results/kks/' . $cols[$key];
									echo "<td><a target='_blank' href='" . $href . "' class='btn btn-outline-primary btn-sm'><i class='bi bi-file-earmark-pdf me-1'></i>PDF</a></td>";
								} else {
									echo '<td><span class="text-muted">-</span></td>';
								}
							}
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
	document.getElementById('pageTitle').textContent = 'Kreiskönigsschießen';
});
</script>

</body>
</html>