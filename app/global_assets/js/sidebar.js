// Trigger the sidebar to show/hide

function executeSidebar() {
  var sidebar = document.getquerySelector('.sidebar');
  
}
function toggleSidebar() {
  var sidebar = document.getElementById('sidebar-content');
  
  // PRevent horizaontal swipe when the sidebar is open
  function preventHorizontalSwipe(e) {
    if (e.deltaX !== 0) {
      e.preventDefault();
    }
  }

  // Add class name 'open' to the sidebar and not toggle
  if (sidebar.classList.contains('open')) {
    // If the sidebar is already open, restrict the swipe either left to right or right to left until the sidebar is closed
    sidebar.classList.remove('open');
    window.removeEventListener('wheel', preventHorizontalSwipe, { passive: false });
    return;
  } else {
    sidebar.classList.add('open');
    window.addEventListener('wheel', preventHorizontalSwipe, { passive: false });
  }
}