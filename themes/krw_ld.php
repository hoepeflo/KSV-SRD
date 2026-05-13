<?php
	$jahr = $_GET["year"];
?>

<!doctype html>
<html lang="">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="SRD | Ergebnisdienst - Kreismeisterschaften">
<meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
<title>SRD | Kreisrundenwettkämpfe <?php echo $jahr ?></title>
<link rel="shortcut icon" type="image/x-icon" href="themes/images/favicon.ico">

<!-- Google icon -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Bootstrap css -->
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

<!-- Propeller css -->
<link rel="stylesheet" type="text/css" href="assets/css/propeller.min.css">

<!-- DataTables css-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css">
<!-- Propeller dataTables css-->

<link rel="stylesheet" type="text/css" href="components/data-table/css/pmd-datatable.css">

<!-- Propeller theme css-->
<link rel="stylesheet" type="text/css" href="themes/css/propeller-theme.css" />

<!-- Propeller admin theme css-->
<link rel="stylesheet" type="text/css" href="themes/css/propeller-admin.css">

</head>

<body>
<!-- Header Starts -->

<?php include 'conf/nav.php'; ?>

<!--content area start-->
<div id="content" class="pmd-content inner-page">

<!--tab start-->
<div class="container-fluid full-width-container data-tables">
		<!-- Title -->
		<h1 class="section-title" id="services">
			<span>Kreisrundenwettkämpfe <?php echo $jahr ?> - Ergebnisse</span>
		</h1><!-- End Title -->
	
		<!--breadcrum start-->
		<ol class="breadcrumb text-left">
		  <li><a href="index.html">Kreisrundenwettkämpfe</a></li>
		  <li class="active"><?php echo $jahr ?></li>
		</ol><!--breadcrum end-->
		
		<!-- Responsive table -->
		<section class="row component-section">
		
			<!-- responsive table code and example -->
			<div class="col-md-12">
				<!-- responsive table example -->
				<div class="pmd-card pmd-z-depth pmd-card-custom-view">
					<table id="lg-liga" class="table pmd-table table-hover table-striped display responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Liga</th>
								<th> </th>
								<th>Klasse</th>
								<th>Änderungsdatum</th>
								<th>Ergebnisse</th>
							</tr>
						</thead>
						<tbody>
							<?php
									include 'conf/db_d.php';
																		
									$res = mysqli_query($con, "SELECT
																	*
																FROM 
																	srd_kreis_rwk_v1
																WHERE
																	disziplin = 'Luftgewehr' AND art = 'Kreisliga'");
									
									$lf = 1;
										while ($dsatz = mysqli_fetch_assoc($res))
										{	
											if(file_exists("results/rwk_" . $jahr . "/RWK_" . $jahr . $dsatz['datei'] . ".pdf"))
											{
												echo '<tr>';
													echo '<td>' . $dsatz["nummer"] . '. ' . $dsatz["art"] . '</td>';
													echo '<td></td>';
													echo '<td>' . $dsatz["altersklasse"] . '</td>';
													echo "<td>". date('d.m.Y', filectime("results/rwk_" . $jahr . "/RWK_" . $jahr . $dsatz['datei'] . ".pdf"));"</td>";
													echo "<td><a href='results/rwk_" . $jahr . "/RWK_" . $jahr . $dsatz['datei'] . ".pdf'><i class='material-icons md-dark pmd-sm'>picture_as_pdf</i></a></td>";
												echo '</tr>';
											}
										}
						
										mysqli_close($con);
							?>
						</tbody>
					</table>
				</div> <!-- responsive table example end -->
				
				</br>
				
				<div class="pmd-card pmd-z-depth pmd-card-custom-view">
					<table id="lg-klasse" class="table pmd-table table-hover table-striped display responsive nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Gruppe</th>
								<th> </th>
								<th>Klasse</th>
								<th>Änderungsdatum</th>
								<th>Ergebnisse</th>
							</tr>
						</thead>
						<tbody>
							<?php
									include 'conf/db_d.php';
																		
									$res = mysqli_query($con, "SELECT
																	*
																FROM 
																	srd_kreis_rwk_v1
																WHERE
																	disziplin = 'Luftgewehr' AND art = 'Kreisklasse'");
									
									$lf = 1;
										while ($dsatz = mysqli_fetch_assoc($res))
										{	
											if(file_exists("results/rwk_" . $jahr . "/RWK_" . $jahr . $dsatz['datei'] . ".pdf"))
											{
												echo '<tr>';
													echo '<td>' . $dsatz["nummer"] . '. ' . $dsatz["art"] . '</td>';
													echo '<td></td>';
													echo '<td>' . $dsatz["altersklasse"] . '</td>';
													echo "<td>". date('d.m.Y', filectime("results/rwk_" . $jahr . "/RWK_" . $jahr . $dsatz['datei'] . ".pdf"));"</td>";
													echo "<td><a href='results/rwk_" . $jahr . "/RWK_" . $jahr . $dsatz['datei'] . ".pdf'><i class='material-icons md-dark pmd-sm'>picture_as_pdf</i></a></td>";
												echo '</tr>';
											}
										}
						
										mysqli_close($con);
							?>
						</tbody>
					</table>
				</div> <!-- responsive table example end -->
				
			</div> <!-- responsive table code and example end-->
		</section> <!-- Responsive table end -->
		
		
	</div>
<!--tab start-->

<!--content area end-->

</div>

<!-- Footer Starts -->
<footer class="admin-footer">
 <div class="container-fluid">
 	<ul class="list-unstyled list-inline">
	 	<li>
			<span class="pmd-card-subtitle-text">Shooting Results Documentation &copy; <span class="auto-update-year"></span>. Alle Rechte vorbehalten.</span>
			<h3 class="pmd-card-subtitle-text">KSV Fallingbostel. Lizensiert unter <a href="https://opensource.org/licenses/MIT" target="_blank">MIT license.</a></h3>
        </li>
        
        <li class="pull-right for-support">
			<a href="mailto:info@ksv-fallingbostel.de">
          		<div>
					<svg x="0px" y="0px" width="38px" height="38px" viewBox="0 0 38 38" enable-background="new 0 0 38 38">
<g><path fill="#A5A4A4" d="M25.621,21.085c-0.642-0.682-1.483-0.682-2.165,0c-0.521,0.521-1.003,1.002-1.524,1.523
		c-0.16,0.16-0.24,0.16-0.44,0.08c-0.321-0.2-0.683-0.32-1.003-0.521c-1.483-0.922-2.726-2.125-3.809-3.488
		c-0.521-0.681-1.002-1.402-1.363-2.205c-0.04-0.16-0.04-0.24,0.08-0.4c0.521-0.481,1.002-1.003,1.524-1.483
		c0.721-0.722,0.721-1.524,0-2.246c-0.441-0.44-0.842-0.842-1.203-1.202c-0.441-0.441-0.842-0.842-1.243-1.243
		c-0.642-0.642-1.483-0.642-2.165,0c-0.521,0.521-1.002,1.002-1.524,1.523c-0.481,0.481-0.722,1.043-0.802,1.685
		c-0.08,1.042,0.16,2.085,0.521,3.047c0.762,2.085,1.925,3.849,3.328,5.532c1.884,2.286,4.17,4.05,6.815,5.333
		c1.203,0.562,2.406,1.002,3.729,1.123c0.922,0.04,1.724-0.201,2.365-0.923c0.441-0.521,0.923-0.922,1.403-1.403
		c0.682-0.722,0.682-1.563,0-2.245C27.265,22.729,26.423,21.927,25.621,21.085z"/>
	<path fill="#A5A4A4" d="M32.437,5.568C28.869,2,24.098-0.005,19.005-0.005S9.182,2,5.573,5.568C2.005,9.177,0,13.908,0,19
		s1.965,9.823,5.573,13.432c3.568,3.568,8.34,5.573,13.432,5.573s9.823-1.965,13.431-5.573
		C39.854,25.014,39.854,12.985,32.437,5.568z M30.299,30.294c-3.003,3.045-7.021,4.695-11.293,4.695
		c-4.272,0-8.291-1.65-11.294-4.695C4.666,27.29,3.016,23.271,3.016,19c0-4.272,1.649-8.291,4.695-11.294
		c3.003-3.003,7.022-4.695,11.294-4.695c4.272,0,8.291,1.649,11.293,4.695C36.56,13.924,36.56,24.075,30.299,30.294z"/>
</g></svg>
            	</div>
            	<div>
				  <span class="pmd-card-subtitle-text">Bei Fragen:</span>
				  <h3 class="pmd-card-title-text">info@ksv-fallingbostel.de</h3>
				</div>
            </a>
        </li>
    </ul>
 </div>
</footer>
<!-- Footer Ends -->

<!-- Scripts Starts -->
<script src="assets/js/jquery-1.12.2.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/propeller.min.js"></script>
<script>
	$(document).ready(function() {
		var sPath=window.location.pathname;
		var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
		$(".pmd-sidebar-nav").each(function(){
			$(this).find("a[href='"+sPage+"']").parents(".dropdown").addClass("open");
			$(this).find("a[href='"+sPage+"']").parents(".dropdown").find('.dropdown-menu').css("display", "block");
			$(this).find("a[href='"+sPage+"']").parents(".dropdown").find('a.dropdown-toggle').addClass("active");
			$(this).find("a[href='"+sPage+"']").addClass("active");
		});
		$(".auto-update-year").html(new Date().getFullYear());
	});
</script> 

<!-- Scripts Ends -->


<!-- Datatable js -->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!-- Datatable Bootstrap -->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

<!-- Datatable responsive js-->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>

<!-- Datatable select js-->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>

<!-- Responsive Data table js-->
<script>
//Propeller  Customised Javascript code 
$(document).ready(function() {
	var exampleDatatable = $('#lg-liga').DataTable({
		responsive: {
			details: {
				type: 'column',
				target: 'tr'
			}
		},
		columnDefs: [ {
			className: 'control',
			orderable: false,
			targets:   1
		} ],
		order: [ 2, 'asc' ],
		bFilter: true,
		bLengthChange: false,
		pagingType: "simple",
		"paging": false,
		"searching": true,
		"language": {
			"info": " _START_ - _END_ von _TOTAL_ ",
			"sLengthMenu": "<span class='custom-select-title'>Zeilen pro Seite:</span> <span class='custom-select'> _MENU_ </span>",
			"sSearch": "",
			"sSearchPlaceholder": "Suche",
			"paginate": {
				"sNext": " ",
				"sPrevious": " "
			},
		},
		dom:
			"<'pmd-card-title'<'data-table-responsive pull-left'><'search-paper pmd-textfield'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>",
	});
	
	/// Select value
	$('.custom-select-info').hide();
	
	$(".data-table-responsive").html('<h2 class="pmd-card-title-text">Luftgewehr Kreisliga</h2>');
	$(".custom-select-action").html('<button class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-primary" type="button"><i class="material-icons pmd-sm">delete</i></button><button class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-primary" type="button"><i class="material-icons pmd-sm">more_vert</i></button>');
		
} );
</script>

<script>
//Propeller  Customised Javascript code 
$(document).ready(function() {
	var exampleDatatable = $('#lg-klasse').DataTable({
		responsive: {
			details: {
				type: 'column',
				target: 'tr'
			}
		},
		columnDefs: [ {
			className: 'control',
			orderable: false,
			targets:   1
		} ],
		order: [ 2, 'asc' ],
		bFilter: true,
		bLengthChange: false,
		pagingType: "simple",
		"paging": false,
		"searching": true,
		"language": {
			"info": " _START_ - _END_ von _TOTAL_ ",
			"sLengthMenu": "<span class='custom-select-title'>Zeilen pro Seite:</span> <span class='custom-select'> _MENU_ </span>",
			"sSearch": "",
			"sSearchPlaceholder": "Suche",
			"paginate": {
				"sNext": " ",
				"sPrevious": " "
			},
		},
		dom:
			"<'pmd-card-title'<'data-table-responsive pull-left'><'search-paper pmd-textfield'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>",
	});
	
	/// Select value
	$('.custom-select-info').hide();
	
	$(".data-table-responsive").html('<h2 class="pmd-card-title-text">Luftgewehr Kreisliga</h2>');
	$(".custom-select-action").html('<button class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-primary" type="button"><i class="material-icons pmd-sm">delete</i></button><button class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-primary" type="button"><i class="material-icons pmd-sm">more_vert</i></button>');
		
} );
</script>

</body>
</html>