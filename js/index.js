var carouselWidth = $('#carouselExampleControls .carousel-inner')[0].scrollWidth;
var cardWidth = $('#carouselExampleControls .carousel-item').width();

var scrillPosition = 0;

$('#carouselExampleControls .carousel-control-next').on('click', function(){
	scrillPosition = scrillPosition + cardWidth;
	$('#carouselExampleControls .carousel-inner').animate({scrollLeft: scrillPosition}, 600);
});