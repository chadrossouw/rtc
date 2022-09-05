(function(){
    const swiperCarousel = document.querySelectorAll('.carousel_carousel');
    console.log(swiperCarousel);
    if(swiperCarousel.length>0){
        swiperCarousel.forEach(carousel=>{
            let options= {
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                simulateTouch:true,
                centeredSlides:true,
                slidesPerView: 1,
                spaceBetween:16,
                breakpoints:{
                    700:{
                        slidesPerView:3,
                        spaceBetween:24,
                    },
                    1000:{
                        slidesPerView:4,
                        spaceBetween:32,
                    },
                    1200:{
                        slidesPerView:4,
                        spaceBetween:45,
                    }
                } 
                
            }
            const carouselInstance = new Swiper(carousel,options);
        })    
    }
}());


