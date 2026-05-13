<!-- Sidebar -->
<nav class="sidebar bg-primary text-white" id="sidebar">
	<div class="sidebar-header p-3">
		<div class="d-flex align-items-center">
			<?php $branding = include __DIR__ . '/branding.php'; ?>
			<img src="<?php echo htmlspecialchars($branding['logo_url']); ?>" alt="KSV" class="me-2" height="40">
			<div>
				<div class="fw-bold">Kreisinformationszentrum</div>
				<small class="text-light">Fallingbostel</small>
			</div>
		</div>
	</div>
	
	<div class="sidebar-menu p-3">
		<ul class="nav nav-pills flex-column">
			<li class="nav-item mb-2">
				<a class="nav-link text-white" href="index.php">
					<i class="bi bi-house me-2"></i>Startseite
				</a>
			</li>
			<li class="nav-item mb-2">
				<a class="nav-link text-white" href="km.php">
					<i class="bi bi-trophy me-2"></i>Kreismeisterschaften
				</a>
			</li>
			<li class="nav-item mb-2">
				<a class="nav-link text-white" target="_blank" href="https://www.rwk-onlinemelder.de/online/listen/nssvksv09">
					<i class="bi bi-link-45deg me-2"></i>Kreisrundenwettkämpfe
				</a>
			</li>
			<li class="nav-item mb-2">
				<a class="nav-link text-white" href="kks_results.php">
					<i class="bi bi-award me-2"></i>Kreiskönigsschießen
				</a>
			</li>
			<li class="nav-item mb-2">
				<div class="dropdown">
					<a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
						<i class="bi bi-archive me-2"></i>Archiv RWK
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="krw_luft.php">Luftdruck</a></li>
						<li><a class="dropdown-item" href="krw_feuer.php">Feuerwaffen</a></li>
					</ul>
				</div>
			</li>
		</ul>
		
		<div class="mt-4 pt-3 border-top border-light">
			<button id="toggle-dark" class="btn btn-outline-light w-100" type="button">
				<i class="bi bi-moon me-2"></i>Dark Mode
			</button>
		</div>
	</div>
</nav>

<!-- Top Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	<div class="container-fluid">
		<!-- Sidebar Toggle Button -->
		<button class="btn btn-outline-light me-3" type="button" id="sidebarToggle">
			<i class="bi bi-list"></i>
		</button>
		
		<!-- Page Title (will be set by each page) -->
		<span class="navbar-brand mb-0 h1" id="pageTitle">SRD</span>
	</div>
</nav>

<!-- Sidebar Overlay (for mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<script>
(function(){
  // Dark Mode functionality
  function applyMode(mode){
    if(mode === 'dark') document.body.classList.add('dark-mode');
    else document.body.classList.remove('dark-mode');
  }
  
  var saved = localStorage.getItem('srd-color-mode');
  applyMode(saved);
  
  // Sidebar functionality
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (window.innerWidth >= 992) {
      // Desktop: Toggle between always visible and hidden
      if (document.body.classList.contains('sidebar-closed')) {
        document.body.classList.remove('sidebar-closed');
      } else {
        document.body.classList.add('sidebar-closed');
      }
    } else {
      // Mobile: Toggle show/hide with overlay
      if (sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
      } else {
        sidebar.classList.add('show');
        overlay.classList.add('show');
      }
    }
  }
  
  function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (window.innerWidth >= 992) {
      // Desktop: Close sidebar
      document.body.classList.add('sidebar-closed');
    } else {
      // Mobile: Close sidebar with overlay
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    }
  }
  
  document.addEventListener('DOMContentLoaded', function(){
    // Dark mode toggle
    var btn = document.getElementById('toggle-dark');
    if(btn){
      btn.addEventListener('click', function(){
        var mode = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
        localStorage.setItem('srd-color-mode', mode);
        applyMode(mode);
      });
    }
    
    // Sidebar toggle
    var sidebarToggle = document.getElementById('sidebarToggle');
    if(sidebarToggle){
      sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    // Close sidebar when clicking overlay
    var overlay = document.getElementById('sidebarOverlay');
    if(overlay){
      overlay.addEventListener('click', closeSidebar);
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
      const sidebar = document.getElementById('sidebar');
      const toggle = document.getElementById('sidebarToggle');
      
      if (window.innerWidth < 992 && 
          sidebar.classList.contains('show') && 
          !sidebar.contains(e.target) && 
          !toggle.contains(e.target)) {
        closeSidebar();
      }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      
      if (window.innerWidth >= 992) {
        // Switching to desktop: Remove mobile classes, ensure sidebar is visible by default
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.classList.remove('sidebar-closed');
      } else {
        // Switching to mobile: Remove desktop classes
        document.body.classList.remove('sidebar-closed');
      }
    });
  });
})();
</script>