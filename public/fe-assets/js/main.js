
// hover category

function mOver(obj){
    obj.classList.toggle('category-item--active');
}

function mOut(obj){
    obj.classList.toggle('category-item--active');
}


// count downt timer

var countDownDate = new Date("july 20, 2022 16:00:00").getTime();

var x=setInterval(function(){

  var now = new Date().getTime();

  var distance = countDownDate - now;

  //var days = Math.floor( distance / (1000 *60 *60 * 24));
  var hours = Math.floor( (distance % (1000 *60 *60 *24)) / (1000 *60 *60));
  var minutes = Math.floor( (distance % (1000 *60 *60))/ (1000 * 60));
  var seconds = Math.floor( (distance %(1000 *60)) / 1000);

 // days = days >= 10 ? days: `0${days}`;
  hours = hours >= 10 ? hours: `0${hours}`;
  minutes = minutes >= 10 ? minutes: `0${minutes}`;
  seconds = seconds >= 10 ? seconds: `0${seconds}`;

  //document.getElementById("days").innerHTML = days;
  document.getElementById("hours").innerHTML = hours;
  document.getElementById("minutes").innerHTML = minutes;
  document.getElementById("seconds").innerHTML = seconds;

  if(distance < 0){
    clearInterval(x);
    document.getElementById("days").innerHTML = "EXPIRED";
  }

}, 1000);


// scroll header
window.onscroll = function() {
  scrollFunction()
};

const htmlNavbar = document.getElementById("demo-head").innerHTML;
const htmlMenu = document.getElementById("menu-head").innerHTML;


function scrollFunction() {
  if(document.body.scrollTop>530||document.documentElement.scrollTop>530){
    document.getElementById("demo-head").style.height= "0";
    document.getElementById("demo-head").innerHTML="";

    document.getElementById("menu-head").style.height= "35px";
    document.getElementById("menu-head").style.display= "flex";
    document.getElementById("menu-head").innerHTML= htmlMenu;

    document.querySelector('.scroll-navbox').style.display="block";
  }else{
    document.getElementById("demo-head").style.height= "var(--navbar-height)";
    document.getElementById("demo-head").innerHTML= htmlNavbar;

    document.getElementById("menu-head").style.height= "0";
    document.getElementById("menu-head").innerHTML="";

    document.querySelector('.scroll-navbox').style.display="none";

  }
}


// slide show fl-sale
  var slideIndex = 1;
  showSlides(slideIndex);

  function plusSlides(n) {
    showSlides(slideIndex += n);
  }


  function showSlides(n) {
    var i,j;
    var items = document.getElementsByClassName("slide-item");
    var itemsNumber = items.length;//=18
    var slides = Math.ceil(itemsNumber/6);//=3
    if (n > slides) {slideIndex = 1}    
    if (n < 1) {slideIndex = slides}

    for(i=0;i<itemsNumber;++i){
      items[i].style.display = "none";
    }
    
    for(i=1;i<=slides;++i){
      if(slideIndex == i){
        for(j=(slideIndex-1)*6;j<itemsNumber&&j<((slideIndex-1)*6+6);++j){
          items[j].style.display = "block";
        }
      }
    }

  }

// number -> toLocaleString

var num;
 x = document.querySelectorAll(".money");
for(var key in Object.keys(x)){
    var num = new Number(x[key].innerHTML).toLocaleString("nl-NL");
    document.querySelectorAll(".money")[key].innerHTML = num + " đ";

 }