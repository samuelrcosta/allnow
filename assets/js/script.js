$(function(){
    setTimeout(function(){
        $(".notification").slideUp();
    }, 8000);

    // On search submit
    $('.nav-search').on('submit', function (e) {
        e.preventDefault();
        let word = $('#search-input').val();
        if(word !== ''){
            word = encodeURI(word);
            window.location.replace(BASE_URL + 'home/search/' + word);
        }
    });

    $('.search-mobile-button').click(function(){
        // Close search menu
        if($(this).hasClass('active')){
            $(this).find('i').removeClass('icon-arrow-up').addClass('icon-magnifier');
            $(this).removeClass('active');
            $('.menu-search-container').slideUp(400, function(){
                $(this).removeClass('active');
            });
        // Open search menu
        }else{
            $(this).find('i').removeClass('icon-magnifier').addClass('icon-arrow-up');
            $(this).addClass('active');
            $('.menu-search-container').addClass('active').slideDown();
        }
    });
});