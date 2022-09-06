/*!
 * Start Bootstrap - Bare v5.0.7 (https://startbootstrap.com/template/bare)
 * Copyright 2013-2021 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-bare/blob/master/LICENSE)
 */
// This file is intentionally blank
// Use this file to add JavaScript to your project

/**
 * Scoll to top button and navbar hide or show when scroll.
 * @type {HTMLElement}
 */
var prevScrollpos = window.pageYOffset;
window.onscroll   = function() {scrollFunction();};

function scrollFunction() {
   var currentScrollPos = window.pageYOffset;
   if (prevScrollpos > currentScrollPos) {
      document.getElementById('navbar').style.top  = '0';
      document.getElementById('navbar2').style.top = '60px';
   } else {
      document.getElementById('navbar').style.top  = '-60px';
      document.getElementById('navbar2').style.top = '0';
   }
   prevScrollpos = currentScrollPos;
}

function topFunction() {
   document.body.scrollTop            = 0;
   document.documentElement.scrollTop = 0;
}

//categories drop-down when hover
$(document).ready(function() {
   $('.navbar .dropdown').hover(function() {
      $(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);
   }, function() {
      $(this).find('.dropdown-menu').first().stop(true, true).slideUp(150);
   });
});

//initialize tooltip
$(function() {
   $('[data-toggle="tooltip"]').tooltip();
});

//scroll to top button
$(window).scroll(function() {
   if ($(this).scrollTop() > 100) {
      $('#topBtn').fadeIn();
   } else {
      $('#topBtn').fadeOut();
   }
});

//Click event to scroll to top
$('#topBtn').click(function() {
   $('html, body').animate({scrollTop: 0}, 200);
   return false;
});




