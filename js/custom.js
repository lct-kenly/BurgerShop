// to get current year
function getYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    document.querySelector("#displayYear").innerHTML = currentYear;
}

getYear();


// isotope js
$(window).on('load', function () {
    $('.filters_menu li').click(function () {
        $('.filters_menu li').removeClass('active');
        $(this).addClass('active');

        var data = $(this).attr('data-filter');
        $grid.isotope({
            filter: data
        })
    });

    var $grid = $(".grid").isotope({
        itemSelector: ".all",
        percentPosition: false,
        masonry: {
            columnWidth: ".all"
        }
    })
});

// // nice select
// $(document).ready(function() {
//     $('select').niceSelect();
//   });

/** google_map js **/
function myMap() {
    var mapProp = {
        center: new google.maps.LatLng(10.032415, 105.784092),
        zoom: 20,
    };
    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
}

// client section owl carousel
$(".client_owl-carousel").owlCarousel({
    loop: true,
    margin: 0,
    dots: false,
    nav: true,
    navText: [],
    autoplay: true,
    autoplayHoverPause: true,
    navText: [
        '<i class="fa fa-angle-left" aria-hidden="true"></i>',
        '<i class="fa fa-angle-right" aria-hidden="true"></i>'
    ],
    responsive: {
        0: {
            items: 1
        },
        768: {
            items: 2
        },
        1000: {
            items: 2
        }
    }
});

//show password
$('.show-password').click(function(e) {
    const parent = $(this).parent();
    const inputPassword = parent.find('input');

    if(inputPassword.attr('type') === 'password') {
        $(inputPassword).attr('type', 'text');
        $(this).find('i').removeClass('fa-eye-slash');
        $(this).find('i').addClass('fa-eye');
    } else {
        $(inputPassword).attr('type', 'password');
        $(this).find('i').removeClass('fa-eye');
        $(this).find('i').addClass('fa-eye-slash');
    }
});

// show tab
$('.tab-item a').click(function(e) {
    $('.tab-item.active').removeClass('active');
    $('.tab-content.active').removeClass('active');

    const id = $(this).attr('data-id');
    $(this).parent().addClass('active');
    $(id).addClass('active');

})

//upload file image
function uploadFile(inputFile, grid) {
    // Kh???i t???o ?????i t?????ng FileReader
    const reader = new FileReader();

    // L???ng nghe tr???ng th??i ????ng t???i t???p
    inputFile.addEventListener("change", (event) => {
        // L???y th??ng tin t???p tin ???????c ????ng t???i
        const files  = event.target.files;
        
        // ?????c th??ng tin t???p tin ???? ???????c ????ng t???i
        reader.readAsDataURL(files[0]);

        const getSizeImage = files[0].size;
        
        if(getSizeImage > 1024 * 800) {
            alert("Ch??? cho ph??p t???i t???p tin nh??? h??n 800KB");
        } 
            
        else{
            alert("????ng t???i t???p th??nh c??ng");
            // L???ng nghe qu?? tr??nh ?????c t???p tin ho??n th??nh
            reader.addEventListener("load", (event) => {
                // L???y chu???i Binary th??ng tin h??nh ???nh
                const img = grid.querySelector('img');

                img.setAttribute("src", event.target.result);
            })
        }
    })
}