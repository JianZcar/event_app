
function toggleSidebar() {
  let sidebar_toggle = document.querySelector('#btn-menu-list');
  let sidebar_panel = document.querySelector('.sidebar-content');

  // Activate sidebar
  sidebar_toggle.onclick = function() {
    sidebar_panel.classList.toggle('open');
  }
}
