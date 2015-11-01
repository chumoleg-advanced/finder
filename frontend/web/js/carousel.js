$(document).ready(function () {
    $("#owl-demo").owlCarousel({
        navigation: false,
        slideSpeed: 300,
        paginationSpeed: 400,
        margin:10,
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            400:{
                items:2
            },
            500:{
                items:3
            },
            600:{
                items:4
            },
            900:{
                items:5
            },
            1200:{
                items:7
            }
        }
    });
});
