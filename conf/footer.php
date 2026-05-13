<!-- Footer -->
<footer class="bg-light border-top">
	<div class="container py-4">
		<div class="row align-items-center">
			<div class="col-md-6">
				<p class="mb-0 text-muted">
					Kreisinformationszentrum &copy; <span class="auto-update-year"></span>. Alle Rechte vorbehalten.
				</p>
				<p class="mb-0 text-muted">
					KSV Fallingbostel. Lizensiert unter <a href="https://opensource.org/licenses/MIT" target="_blank">MIT license.</a>
				</p>
				<p class="mb-0 text-muted">
					Erstellt durch Florian Höper
				</p>
			</div>
			<div class="col-md-6 text-md-end">
				<div class="mb-2">
					<a href="mailto:info@ksv-fallingbostel.de" class="text-decoration-none me-3">
						<i class="bi bi-envelope me-2"></i>info@ksv-fallingbostel.de
					</a>
				</div>
				<div class="legal-links">
					<a href="https://www.ksv-fallingbostel.de/index.php/impressum" target="_blank" class="text-decoration-none me-3">
						<i class="bi bi-info-circle me-1"></i>Impressum
					</a>
					<a href="https://www.ksv-fallingbostel.de/index.php/haftungsausschluss" target="_blank" class="text-decoration-none me-3">
						<i class="bi bi-shield-exclamation me-1"></i>Haftungsausschluss
					</a>
					<a href="https://www.ksv-fallingbostel.de/index.php/datenschutzerklaerung" target="_blank" class="text-decoration-none">
						<i class="bi bi-shield-lock me-1"></i>Datenschutz
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Dark Mode Toggle -->
<script src="themes/js/dark-mode.js"></script>
<!-- Auto-update year -->
<script>
document.addEventListener('DOMContentLoaded', function() {
	document.querySelector('.auto-update-year').textContent = new Date().getFullYear();
});
</script>