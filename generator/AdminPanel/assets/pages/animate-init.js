/*
 Template Name: Admiry - Bootstrap 4 Admin Dashboard
 Author: Themesdesign
 Website: www.themesdesign.in
 File: Animation demo js (Demo only - minify)
 */

function testAnim(n){$("#animationSandbox").removeClass().addClass(n+" animated").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",function(){$(this).removeClass()})}$(document).ready(function(){$(".js--triggerAnimation").click(function(n){n.preventDefault();var i=$(".js--animations").val();testAnim(i)}),$(".js--animations").change(function(){var n=$(this).val();testAnim(n)})});
