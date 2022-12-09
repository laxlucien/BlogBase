/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

var menuIcon = document.querySelector(".menu-icon");
var sidebar = document.querySelector(".sidebar");

menuIcon.onclick = function(){
    sidebar.classList.toggle("small-sidebar");
};