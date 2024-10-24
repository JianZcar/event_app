
function toggleSidebar() {
  let sidebar_toggle = document.querySelector('#btn-menu-list');
  let sidebar_panel = document.querySelector('.sidebar-content');
  let sidebar_top = document.querySelector('.sidebar-top');
  let sidebar_profile = document.querySelector('.sidebar-profile');
  let sidebar_menu = document.querySelector('.sidebar-menu');

  // Activate sidebar
  sidebar_toggle.onclick = function() {
    sidebar_panel.classList.toggle('open');
    sidebar_top.classList.toggle('open');
    sidebar_profile.classList.toggle('open');
    sidebar_menu.classList.toggle('open');
  }
}
