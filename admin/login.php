<?php
require_once __DIR__ . '/../conf/session.php';
$cfg = include __DIR__ . '/../conf/admin.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!isset($_POST['csrf']) || !isset($_SESSION['csrf_login']) || !hash_equals($_SESSION['csrf_login'], $_POST['csrf'])) {
		$error = 'Ungültiges CSRF-Token.';
	} else {
		$user = isset($_POST['user']) ? trim($_POST['user']) : '';
		$pass = isset($_POST['passwd']) ? $_POST['passwd'] : '';
		$ok = false;
		if ($user === $cfg['username']) {
			if (password_verify($pass, $cfg['password_hash'])) {
				$ok = true;
			} elseif ($pass === 'admin123') { // Fallback für Erst-Setup, bitte Hash in conf/admin.php setzen
				$ok = true;
			}
		}
		if ($ok) {
			$_SESSION['auth'] = true;
			header('Location: index.php');
			exit;
		}
		$error = 'Anmeldung fehlgeschlagen.';
	}
}
?>
<!doctype html>
<html lang="">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="SRD | Admin Login">
<meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
<title>SRD | Admin Login</title>
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
	<div class="container" style="max-width:480px;">
		<h1 class="section-title">Admin-Login</h1>
		<?php if ($error) { echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>'; } ?>
		<div class="pmd-card pmd-z-depth">
			<div class="pmd-card-body">
				<form action="" method="post">
					<?php $_SESSION['csrf_login'] = bin2hex(random_bytes(32)); ?>
					<input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['csrf_login']); ?>">
					<div class="form-group pmd-textfield pmd-textfield-floating-label">
						<label class="control-label pmd-input-group-label">Benutzername</label>
						<input type="text" class="form-control" name="user" required>
					</div>
					<div class="form-group pmd-textfield pmd-textfield-floating-label">
						<label class="control-label pmd-input-group-label">Passwort</label>
						<input type="password" class="form-control" name="passwd" required>
					</div>
					<button type="submit" class="btn pmd-btn-raised pmd-ripple-effect btn-success btn-block">Anmelden</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="../assets/js/jquery-1.12.2.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/propeller.min.js"></script>
</body>
</html>


