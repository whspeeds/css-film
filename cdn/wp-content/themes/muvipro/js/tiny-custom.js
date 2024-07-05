var slider = tns({
	container: '.gmr-owl-carousel',
	loop: true,
	items: 5,
	gutter: 10,
	mouseDrag: true,
	swipeAngle: false,
	nav: false,
	controlsText: ['&nbsp;', '&nbsp;'],
	autoplay: true,
	lazyload: true,
	autoplayButtonOutput: false,
	responsive : {
		0 : {
			items : 2,
			edgePadding: 40,
		},
		380 : {
			items : 2,
			edgePadding: 40,
		},
		600 : {
			items : 4,
			edgePadding: 70,
		},
		1000 : {
			items : 5,
			edgePadding: 100,
		}
	}
});
