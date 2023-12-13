define(['jquery'], function ($) {
    return function () {
        $(document).ready(function() {
            console.log("This is Mujasss");
            //---
            //document.addEventListener('DOMContentLoaded', function () {
                const slider = document.getElementById('slider');
                const sliderBar = document.getElementById('sliderBar');
                const accessories = document.querySelectorAll('.accessory');
            
                let currentIndex = 0;
            
                function updateSlider() {
                    const newPosition = -currentIndex * 100;
                    slider.style.transform = `translateX(${newPosition}%)`;
            
                    // Calculate and set the width of the slider bar based on visible cards
                    const visibleCards = getVisibleCards();
                    const barWidth = (visibleCards / accessories.length) * 100;
                    sliderBar.style.width = barWidth + '%';
                }
            
                function getVisibleCards() {
                    const containerWidth = slider.clientWidth;
                    const cardWidth = accessories[0].offsetWidth;
                    return Math.floor(containerWidth / cardWidth);
                }
            
                window.nextSlide = function () {
                    if (currentIndex < accessories.length - getVisibleCards()) {
                        currentIndex++;
                    } else {
                        currentIndex = 0;
                    }
                    updateSlider();
                }
            
                window.prevSlide = function () {
                    if (currentIndex > 0) {
                        currentIndex--;
                    } else {
                        currentIndex = accessories.length - getVisibleCards();
                    }
                    updateSlider();
                }
            //});            

            //--
        });
    }
});