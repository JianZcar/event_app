
// Trigger the sidebar to show/hide
function toggleSidebar() {
  var sidebar = document.getElementById('sidebar-content');
  // add class name 'open' to the sidebar and not toggle
  if (sidebar.classList.contains('open')) {
    sidebar.classList.remove('open');
    return;
  } else {
    sidebar.classList.add('open');
  }
}