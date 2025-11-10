window.addEventListener('resize', function(event) {
    slidesContainerA.scrollLeft = 0;
    current_slideA = 1;
    document.getElementById('slide_textA').innerHTML = document.getElementById('slideAnum'+current_slideA).innerHTML;
});
var current_slideA = 1; 
document.getElementById('slide_textA').innerHTML = document.getElementById('slideAnum'+current_slideA).innerHTML;
const slidesContainerA = document.getElementById("slides-container-affiliate");
            const slideA = slidesContainerA.querySelector(".slideA");
            const prevButtonA = document.getElementById("slide-arrow-prevA");
            const nextButtonA = document.getElementById("slide-arrow-nextA");
            const slideA_num = document.getElementById("slideA_num").value;

            nextButtonA.addEventListener("click", () => {
            const slideWidthA = slideA.clientWidth;
                if ((slidesContainerA.scrollLeft+slideWidthA+10)>=slidesContainerA.scrollWidth){
                    slidesContainerA.scrollLeft = 0;
                    current_slideA = 1;
                }else {
                    slidesContainerA.scrollLeft += slideWidthA;
                    current_slideA += 1;
                    //current_slideA = 3-Math.floor(slidesContainerA.scrollWidth/slidesContainerA.scrollLeft);
                }
                document.getElementById('slide_textA').innerHTML = document.getElementById('slideAnum'+current_slideA).innerHTML;
            });

            prevButtonA.addEventListener("click", () => {
            const slideWidthA = slideA.clientWidth;
            if (slidesContainerA.scrollLeft==0){
                    slidesContainerA.scrollLeft = slidesContainerA.scrollWidth-slideWidthA;
                    current_slideA = slideA_num;
                }else {
                    slidesContainerA.scrollLeft -= slideWidthA;
                    //current_slideA = 3-Math.floor(slidesContainerA.scrollWidth/slidesContainerA.scrollLeft);
                    current_slideA -= 1;
                }
                document.getElementById('slide_textA').innerHTML = document.getElementById('slideAnum'+current_slideA).innerHTML;
            });