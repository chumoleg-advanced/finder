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
            300:{
                items:2
            },
            400:{
                items:3
            },
            500:{
                items:4
            },
            700:{
                items:5
            },
            800:{
                items:6
            },
            1000:{
                items:7
            },
            1100:{
                items:8
            },
            1200:{
                items:9
            }
        }
    });
});
