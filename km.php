<?php
	$jahr = isset($_GET["year"]) ? intval($_GET["year"]) : null;
?>

<!doctype html>
<html lang="de" data-bs-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SRD | Kreismeisterschaften <?php echo $jahr ? $jahr : '' ?></title>
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
				<?php if ($jahr) { ?>
				<li class="breadcrumb-item active"><?php echo $jahr; ?></li>
				<?php } else { ?>
				<li class="breadcrumb-item active">Jahr auswählen</li>
				<?php } ?>
			</ol>
		</nav>

		<!-- Page Header -->
		<div class="row mb-4">
			<div class="col">
				<h1 class="display-6 fw-bold text-primary">Kreismeisterschaften</h1>
				<p class="lead text-muted">Ergebnisse der Kreismeisterschaften</p>
			</div>
		</div>

		<?php if (!$jahr) { ?>
		<!-- Year Selection with Disciplines -->
		<div class="row mb-4">
			<div class="col-12">
				<div class="card shadow-sm">
					<div class="card-header bg-primary text-white">
						<h5 class="card-title mb-0">
							<i class="bi bi-calendar me-2"></i>Sportjahr und Disziplin auswählen
						</h5>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table class="table table-hover table-striped mb-0">
								<thead class="table-primary">
									<tr>
										<th class="col-year">Jahr</th>
										<th class="col-equal text-center">Kugel</th>
										<th class="col-equal text-center">Lichtschießen</th>
										<th class="col-equal text-center">Bogen</th>
										<th class="col-equal text-center">Blasrohr</th>
									</tr>
								</thead>
								<tbody>
									<?php
									// Verfügbare Jahre - Standard-Jahre für Kreismeisterschaften
									$years = array(2026, 2025, 2024, 2023, 2022, 2021, 2020, 2019, 2018, 2017, 2016);
									
									// Versuche Jahre aus der Datenbank zu laden (optional)
									try {
										include 'conf/db_d.php';
										$dbYears = array();
										$tables = array('srd_kreis_v3', 'srd_kreis_v2');
										foreach ($tables as $table) {
											$result = mysqli_query($con, "SELECT DISTINCT sportjahr FROM $table ORDER BY sportjahr DESC");
											if ($result) {
												while ($row = mysqli_fetch_assoc($result)) {
													$dbYears[$row['sportjahr']] = $row['sportjahr'];
												}
											}
										}
										mysqli_close($con);
										
										// Wenn DB-Jahre verfügbar, verwende diese
										if (!empty($dbYears)) {
											$years = array_values($dbYears);
											krsort($years);
										}
									} catch (Exception $e) {
										// Verwende Standard-Jahre bei DB-Fehlern
									}
									
									// Disziplin-Links für jedes Jahr
									foreach ($years as $year) {
										echo '<tr>';
										echo '<td><strong>' . $year . '</strong></td>';
										
										// Kugel (Hauptdisziplin)
										echo '<td class="text-center">';
										echo '<a href="km.php?year=' . $year . '" class="btn btn-outline-primary btn-sm">';
										echo '<i class="bi bi-trophy me-1"></i>Ergebnisse';
										echo '</a>';
										echo '</td>';
										
										// Lichtschießen
										echo '<td class="text-center">';
										$lichtPath = '';
										if ($year == 2026) {
											$lichtPath = 'results/km_2026/2026_Lichtschießen.pdf';
										} elseif ($year == 2025) {
											$lichtPath = 'results/km_' . $year . '/licht/Ergebnisse.pdf';
										} elseif ($year == 2018) {
											$lichtPath = 'results/km-licht/' . $year . '/' . $year . '-Gesamt.pdf';
										} elseif ($year == 2018) {
											$lichtPath = 'kmlicht_2018.php';
										} elseif ($year >= 2017) {
											$lichtPath = 'results/km-licht/' . $year . '/KM_Licht' . $year . '-gesamt.pdf';
										}
										
										if ($lichtPath && file_exists($lichtPath)) {
											if (strpos($lichtPath, '.pdf') !== false) {
												echo '<a href="' . $lichtPath . '" target="_blank" class="btn btn-outline-primary btn-sm">';
												echo '<i class="bi bi-file-earmark-pdf me-1"></i>PDF';
												echo '</a>';
											} else {
												echo '<a href="' . $lichtPath . '" class="btn btn-outline-success btn-sm">';
												echo '<i class="bi bi-link me-1"></i>Link';
												echo '</a>';
											}
										} else {
											echo '<span class="text-muted">-</span>';
										}
										echo '</td>';
										
										// Bogen
										echo '<td class="text-center">';
										if ($year >= 2024) {
											echo '<a href="kreismeisterschaften_bogen.php?year=' . $year . '" class="btn btn-outline-success btn-sm">';
											echo '<i class="bi bi-link me-1"></i>Link';
											echo '</a>';
										} else {
											echo '<span class="text-muted">-</span>';
										}
										echo '</td>';
										
										// Blasrohr
										echo '<td class="text-center">';
										if ($year >= 2024) {
											echo '<a href="kreismeisterschaften_blasrohr.php?year=' . $year . '" class="btn btn-outline-success btn-sm">';
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
		<?php } else { ?>

		<!-- Results Table -->
		<div class="row">
			<div class="col-12">
				<div class="card shadow-sm">
					<div class="card-header bg-primary text-white">
						<h5 class="card-title mb-0">
							<i class="bi bi-trophy me-2"></i>Disziplinen <?php echo $jahr; ?>
						</h5>
					</div>
					<div class="card-body p-0">
						<?php if ($jahr) { ?>
							<div class="table-responsive">
								<table class="table table-hover table-striped mb-0">
									<thead class="table-primary">
										<tr>
											<th>Disziplin</th>
											<th>Klasse</th>
											<th>SpO</th>
											<th>Änderungsdatum</th>
											<th>Einzel</th>
											<th>Mannschaft</th>
										</tr>
									</thead>
							<tbody>
							<?php
								include 'conf/db_d.php';
								function renderRow($dsatz, $jahr, $ext) {
									echo '<tr>';
									echo '<td><strong>' . $dsatz["disziplin"] . '</strong></td>';
									echo '<td>' . $dsatz["altersklasse"] . '</td>';
									echo '<td>' . $dsatz["spo"] . '</td>';
									$pfadE = "results/km_" . $jahr . "/e" . $dsatz['datei'] . "." . $ext;
									$pfadM = "results/km_" . $jahr . "/m" . $dsatz['datei'] . "." . $ext;
									echo "<td>". (file_exists($pfadE) ? date('d.m.Y', filectime($pfadE)) : '-') . "</td>";
									echo file_exists($pfadE)
										? "<td>" . ($ext === 'html' ? "<a href='km_results.php?year=".$jahr."&id=".$dsatz["datei"]."&art=e' class='btn btn-outline-success btn-sm'><i class='bi bi-person me-1'></i>Einzel</a>" : "<a href='".$pfadE."' target='_blank' class='btn btn-outline-primary btn-sm'><i class='bi bi-file-earmark-pdf me-1'></i>PDF</a>") . "</td>"
										: '<td><span class="text-muted">-</span></td>';
									echo file_exists($pfadM)
										? "<td>" . ($ext === 'html' ? "<a href='km_results.php?year=".$jahr."&id=".$dsatz["datei"]."&art=m' class='btn btn-outline-success btn-sm'><i class='bi bi-people me-1'></i>Mannschaft</a>" : "<a href='".$pfadM."' target='_blank' class='btn btn-outline-primary btn-sm'><i class='bi bi-file-earmark-pdf me-1'></i>PDF</a>") . "</td>"
										: '<td><span class="text-muted">-</span></td>';
									echo '</tr>';
								}

								// Erkennungslogik: PDF bevorzugt (ab 2024), sonst HTML (bis 2023)
								$extPreferred = ($jahr >= 2024) ? 'pdf' : 'html';
								$tables = array('srd_kreis_v3');
								foreach ($tables as $table) {
									$res = @mysqli_query($con, "SELECT * FROM " . $table . " ORDER BY spo");
									if ($res) {
										while ($dsatz = mysqli_fetch_assoc($res)) {
											$pfadEpdf = "results/km_" . $jahr . "/e" . $dsatz['datei'] . ".pdf";
											$pfadMpdf = "results/km_" . $jahr . "/m" . $dsatz['datei'] . ".pdf";
											$pfadEhtml = "results/km_" . $jahr . "/e" . $dsatz['datei'] . ".html";
											$pfadMhtml = "results/km_" . $jahr . "/m" . $dsatz['datei'] . ".html";

											if ($extPreferred === 'pdf') {
												if (file_exists($pfadEpdf) || file_exists($pfadMpdf)) { renderRow($dsatz, $jahr, 'pdf'); }
												else if (file_exists($pfadEhtml) || file_exists($pfadMhtml)) { renderRow($dsatz, $jahr, 'html'); }
											} else {
												if (file_exists($pfadEhtml) || file_exists($pfadMhtml)) { renderRow($dsatz, $jahr, 'html'); }
												else if (file_exists($pfadEpdf) || file_exists($pfadMpdf)) { renderRow($dsatz, $jahr, 'pdf'); }
											}
										}
									}
								}
								mysqli_close($con);
							?>
								</tbody>
								</table>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</main>

<?php include 'conf/footer.php'; ?>

<!-- Page title script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
	<?php if ($jahr) { ?>
	document.getElementById('pageTitle').textContent = 'Kreismeisterschaften <?php echo $jahr; ?>';
	<?php } else { ?>
	document.getElementById('pageTitle').textContent = 'Kreismeisterschaften';
	<?php } ?>
});
</script>

</body>
</html>


