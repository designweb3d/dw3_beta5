window.addEventListener('resize', function(event) {
    var newWidth = window.innerWidth;
    if (newWidth !== prevWidth) {
        prevWidth = newWidth;
        if (document.getElementById('slide_dot'+current_slide)){
            document.getElementById('slide_dot'+current_slide).style.background = "rgba(155,155,155,0.5)";
        }
        slidesContainer.scrollLeft = 0;
        current_slide = 1;
        document.getElementById('slide_dot'+current_slide).style.background = "rgba(255,255,255,1)";
    }
});
var prevWidth = window.innerWidth;
var Slide1Interval = setInterval(autoSlide, 4000);

var current_slide = 1; 
const slidesContainer = document.getElementById("slides-container");
const slide = document.querySelector(".slide");
const prevButton = document.getElementById("slide-arrow-prev");
const nextButton = document.getElementById("slide-arrow-next");
const slide_num = document.getElementById("slide1_num").value;

nextButton.addEventListener("click", () => {
    clearInterval(Slide1Interval);
    const slideWidth = slide.clientWidth;
    if (document.getElementById('slide_dot'+current_slide)){
            document.getElementById('slide_dot'+current_slide).style.background = "rgba(155,155,155,0.5)";
    }
    if ((slidesContainer.scrollLeft+slideWidth)>=slidesContainer.scrollWidth){
        slidesContainer.scrollLeft = 0;
        current_slide = 1;
    }else {
        //slidesContainer.scrollLeft += slideWidth;
        slidesContainer.scrollLeft = slideWidth*current_slide;
        current_slide += 1;
        //current_slide = 3-Math.floor(slidesContainer.scrollWidth/slidesContainer.scrollLeft);
    }
    if (document.getElementById('slide-text'+current_slide)){
        document.getElementById('slide_text').innerHTML = document.getElementById('slide-text'+current_slide).innerHTML;
        document.getElementById('slide_dot'+current_slide).style.background = "rgba(255,255,255,1)";
    }
    Slide1Interval = setInterval(autoSlide, 4000);
});

prevButton.addEventListener("click", () => {
    clearInterval(Slide1Interval);
    const slideWidth = slide.clientWidth;
    if (document.getElementById('slide_dot'+current_slide)){
        document.getElementById('slide_dot'+current_slide).style.background = "rgba(155,155,155,0.5)";
    }
    if (slidesContainer.scrollLeft==0){
        slidesContainer.scrollLeft = slidesContainer.scrollWidth-slideWidth;
        current_slide = slide_num;
    }else {
        //slidesContainer.scrollLeft -= slideWidth;
        current_slide -= 1;
        slidesContainer.scrollLeft = slideWidth*(current_slide-1);
        //current_slide = 3-Math.floor(slidesContainer.scrollWidth/slidesContainer.scrollLeft);
  
    }
    if (document.getElementById('slide-text'+current_slide)){
        document.getElementById('slide_text').innerHTML = document.getElementById('slide-text'+current_slide).innerHTML;
        document.getElementById('slide_dot'+current_slide).style.background = "rgba(255,255,255,1)";
    }
    Slide1Interval = setInterval(autoSlide, 4000);
});

function changeSlideTo(slide_num){
    clearInterval(Slide1Interval);
    document.getElementById('slide_dot'+current_slide).style.background = "rgba(155,155,155,0.5)";
    const slideWidth = slide.clientWidth;
    slidesContainer.scrollLeft = slideWidth*(slide_num-1);
    current_slide = slide_num;
    document.getElementById('slide_dot'+current_slide).style.background = "rgba(255,255,255,1)";
    Slide1Interval = setInterval(autoSlide, 8000);
}

function autoSlide(){
    nextButton.click(); 
}

let touchstartX = 0
let touchendX = 0
    
function checkDirection() {
  if (touchendX < touchstartX) nextButton.click()
  if (touchendX > touchstartX) prevButton.click()
}

document.addEventListener('touchstart', e => {
  touchstartX = e.changedTouches[0].screenX
})

document.addEventListener('touchend', e => {
  touchendX = e.changedTouches[0].screenX
  checkDirection()
})