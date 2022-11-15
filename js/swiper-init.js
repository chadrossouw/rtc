(function(){
    const swiperCarousel = document.querySelectorAll('.swiper');
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
                spaceBetween:2,
                autoplay: {
                    delay: 3500,
                  },
                
            }
            const carouselInstance = new Swiper(carousel,options);
        })    
    }
}());


