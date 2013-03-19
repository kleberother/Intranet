// FUNÇÃO PARA INICIAR OS SLIDES

$(function(){
        // Set starting slide to 1
        var startSlide = 1;
        // Get slide number if it exists
        if (window.location.hash) {
                startSlide = window.location.hash.replace('#','');
        }
        // Initialize Slides
        $('.slides').slides({
                preload: true,
                preloadImage: 'img/loading.gif',
                generatePagination: false,
                play: 5000,
                pause: 2500,
                hoverPause: false,
                // Get the starting slide
                start: startSlide,
                animationComplete: function(current){
                        // Set the slide number as a hash
                        window.location.hash = '#' + current;
                }
        });
});


// FUNÇÃO PARA TABELA SCROLL

$(function() {
        $(".tabela-conteudo").jCarouselLite({
                vertical: true,
                hoverPause:false,
                visible: 11,
                auto:500,
                speed:1000
        });
});