'use strict';

document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.menu-item');
    const menuLinks = document.querySelectorAll('.menu-link.menu-toggle');

    menuLinks.forEach(function(menuLink, index) {
        menuLink.onclick = function(e) {
            e.preventDefault();

            if(this.matches('.menu-link.active')) {
                this.parentElement.classList.remove('active');
                this.classList.remove('active');
                this.nextElementSibling.style.maxHeight = null;
                this.nextElementSibling.classList.remove('open');
            } else {
                if(document.querySelector('.menu-item.active')) {
                    document.querySelector('.menu-item.active').classList.remove('active');
    
                    document.querySelectorAll('.menu-link.active').forEach((item) => {
                        item.classList.remove('active');
                    })

                    if(document.querySelector('.menu-sub.open')) {
                        document.querySelector('.menu-sub.open').style.maxHeight = null;
                        document.querySelector('.menu-sub.open').classList.remove('open');
                    }
                }
                    
                this.parentElement.classList.add('active');
                this.classList.add('active');

                const menuSub = this.parentElement.querySelector('.menu-sub');
                
                if(menuSub.matches('.menu-sub.open')) {
                    menuSub.classList.remove('open');
                    menuSub.style.maxHeight = null;
                } else {
                    menuSub.classList.add('open');
                    menuSub.style.maxHeight = this.parentElement.scrollHeight + 'px';
                }
            } 
        }
    });


    // navbar mobile

    if(window.innerWidth <= 1024) {
        document.querySelector('.layout-menu').classList.add('offcanvas');
    } else {
        document.querySelector('.layout-menu').classList.remove('offcanvas');
    }

    window.addEventListener('resize', function() {
        if(window.innerWidth <= 1024) {
            document.querySelector('.layout-menu').classList.add('offcanvas');
        } else {
            document.querySelector('.layout-menu').classList.remove('offcanvas');
        }
    })


    // show/hide dropdown profile 
    const profileBtn = document.querySelector('.profile .dropdown-btn');
    const profileDropdown = document.querySelector('.profile .dropdown');

    profileBtn.onclick = function(e) {

        e.stopPropagation();

        profileDropdown.classList.toggle('open');
    }

    window.onclick = function(e) {
        if(!e.target.matches('.dropdown-btn')) {
            profileDropdown.classList.remove('open'); 
        }
    }
})

//Show password
$('.show-password').click(function () {
    const parent = $(this).parent();
    if($(this).hasClass('hide'))  {

        $(this).removeClass('hide');
        $(this).addClass('show');

        $(parent).children('input').attr('type', 'text');

        $(this).children('i').removeClass('fa-eye');
        $(this).children('i').addClass('fa-eye-slash');
    } else {
        $(this).removeClass('show');
        $(this).addClass('hide');

        $(parent).children('input').attr('type', 'password');

        $(this).children('i').removeClass('fa-eye-slash');
        $(this).children('i').addClass('fa-eye');
    }
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