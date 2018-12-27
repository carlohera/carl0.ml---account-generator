/*
 Template Name: Admiry - Bootstrap 4 Admin Dashboard
 Author: Themesdesign
 Website: www.themesdesign.in
 File: Rating init (Demo only - minify)
 */

$(function(){$("input.check").on("change",function(){alert("Rating: "+$(this).val())}),$(".rating-tooltip").rating({extendSymbol:function(t){$(this).tooltip({container:"body",placement:"bottom",title:"Rate "+t})}}),$(".rating-tooltip-manual").rating({extendSymbol:function(){var t;$(this).tooltip({container:"body",placement:"bottom",trigger:"manual",title:function(){return t}}),$(this).on("rating.rateenter",function(n,i){t=i,$(this).tooltip("show")}).on("rating.rateleave",function(){$(this).tooltip("hide")})}}),$(".rating").each(function(){$('<span class="label label-default"></span>').text($(this).val()||" ").insertAfter(this)}),$(".rating").on("change",function(){$(this).next(".label").text($(this).val())})});