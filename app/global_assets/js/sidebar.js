function slideOpen() {
  let slide_btn = document.querySelector(".btn-slide");
  let slide_panel = document.querySelector(".slide-panel");
  let slide_list = document.querySelectorAll(".set-hide");

  slide_btn.onclick = function () {
    slide_panel.classList.toggle("slide-panel-open");
    slide_list.forEach((item) => item.classList.toggle("show"));
  };
}
