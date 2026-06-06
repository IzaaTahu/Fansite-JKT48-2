/* public/js/admin.js */

// Sidebar toggle mobile
const toggle  = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');

if (toggle && sidebar) {
  toggle.addEventListener('click', () => sidebar.classList.toggle('open'));
  document.addEventListener('click', (e) => {
    if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
      sidebar.classList.remove('open');
    }
  });
}

// Auto-dismiss flash
const flash = document.getElementById('adminFlash');
if (flash) {
  setTimeout(() => {
    flash.style.transition = 'opacity .4s';
    flash.style.opacity    = '0';
    setTimeout(() => flash.remove(), 400);
  }, 4000);
}

// Image preview on file input
function previewImg(input) {
  const preview = document.getElementById('fotoPreview');
  if (!preview || !input.files?.[0]) return;
  const reader = new FileReader();
  reader.onload = (e) => { preview.src = e.target.result; preview.classList.add('show'); };
  reader.readAsDataURL(input.files[0]);
}