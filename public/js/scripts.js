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
var mybutton = document.getElementById("topBtn");
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
        document.getElementById("navbar").style.top = "0";
        document.getElementById("navbar2").style.top = "60px";
    } else {
        document.getElementById("navbar").style.top = "-60px";
        document.getElementById("navbar2").style.top = "0";
    }
    prevScrollpos = currentScrollPos;

    if (document.body.scrollTop > 250 || document.documentElement.scrollTop > 250) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

//categories drop-down when hover
$(document).ready(function () {
    $('.navbar .dropdown').hover(function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown(150);
    }, function () {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp(150)
    });
});

//initialize tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})




