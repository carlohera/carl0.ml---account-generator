// For horizontal menu 1
$(".navbar.horizontal-layout .navbar-menu-wrapper .navbar-toggler").on("click", function() {
  $(".navbar.horizontal-layout").toggleClass("header-toggled");
});

// For horizontal menu 2
$(".horizontal-menu-2 .navbar.horizontal-layout-2 .navbar-menu-wrapper .navbar-toggler").on("click", function() {
  $(".horizontal-menu-2 .navbar.horizontal-layout-2 .nav-bottom").toggleClass("header-toggled");
});