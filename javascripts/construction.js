//Sidebar toggle
function sidebarToggle(){
    var counter = 0;
    $(".menu-toggle").click(function(e){
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
        $(".menu-toggle > .fa-bars, .menu-toggle > .fa-times").toggleClass("fa-bars fa-times");
        $(this).toggleClass("active");

        // console.log("sidebar toggle") //debug
        counter = counter + 1;
        // console.log(counter) //debug
        if (counter % 2 == 0) {
            $('.overlay').fadeOut();
        }
        else if (counter % 2 != 0) {
            $('.overlay').fadeIn();
        }
    })
};
sidebarToggle();

//Tooltip toggle - Needs Popper JS
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

//Date time calculations
//Year variables
var today = new Date();
var year = today.getFullYear();
var age;

// Current year
function getDate() {
    document.getElementById("currentDate").innerHTML = year;
};
getDate();

//Calculate years old
function calculateYO() {
    var age = year - 1997;
    document.getElementById('age').innerHTML = age;
};
calculateYO();
