const SlidesController = {

    // inputs

    // buttons
    PLAY_BUTTON: ".play-button",

    // containers
    MEDIAS_CONTAINER: ".medias_container",
    AD_MEDIA_CONTAINER: ".ad-media-container",
    TUT_MEDIAS_CONTAINER: ".tutorial_media_container",
    TUT_AD_MEDIA_CONTAINER: ".tutorial-ad-media-container",
    YOUTUBE_MEDIA_CONTAINER: ".media-type-1",
    VIMEO_MEDIA_CONTAINER: ".media-type-2",

    // Variables for storage and controller

    _listeners: function _listeners(){
        // Window Resize
        window.onresize = function(){
            SlidesController._ajustAdsContainerHeight();
        };
    },
    
    _ajustAdsContainerHeight: function _ajustAdsContainerHeight(){
        let width = $(SlidesController.MEDIAS_CONTAINER).first().width();
        let height = Math.floor((width * 9) / 16);
        $(SlidesController.MEDIAS_CONTAINER).height(height);
        $(SlidesController.AD_MEDIA_CONTAINER).height(height);
        // Ajust PlayButton size
        if(width > 380){
            $(SlidesController.PLAY_BUTTON).removeClass('play-md').removeClass('play-sm').addClass('play-big');
        }else if(width > 275 && width < 380){
            $(SlidesController.PLAY_BUTTON).removeClass('play-sm').removeClass('play-big').addClass('play-md');
        }else{
            $(SlidesController.PLAY_BUTTON).removeClass('play-md').removeClass('play-big').addClass('play-sm');
        }

        // Ajust tutorial video
        let tutorialWidth = $(SlidesController.TUT_MEDIAS_CONTAINER).first().width();
        let tutorialheight = Math.floor((tutorialWidth * 9) / 16);
        $(SlidesController.TUT_MEDIAS_CONTAINER).height(tutorialheight);
        $(SlidesController.TUT_AD_MEDIA_CONTAINER).height(tutorialheight);
    },

    _loadSlickSlide: function _loadSlickSlide(){
        $(SlidesController.MEDIAS_CONTAINER).slick({
            infinite: true
        });
    },

    _loadYoutubeThumbs: function _loadYoutubeThumbs(){
        let youtube = document.querySelectorAll( SlidesController.YOUTUBE_MEDIA_CONTAINER );

        for (let i = 0; i < youtube.length; i++) {
            // thumbnail image source.
            //let source = "https://img.youtube.com/vi/" + youtube[i].dataset.media + "/sddefault.jpg";
            let source = "https://img.youtube.com/vi/" + youtube[i].dataset.media + "/hqdefault.jpg";
            // Load the image asynchronously

            let image = new Image();
            image.src = source;
            image.addEventListener("load", function () {
                youtube[i].appendChild(image);
            }(i));
            // Add a listener for play button
            $(youtube[i]).find(SlidesController.PLAY_BUTTON).on('click', function(){
                SlidesController._loadYoutubeVideo($(this));
            });
        }
    },

    _loadVimeoThumbs: function _loadVimeoThumbs(){
        let vimeo = document.querySelectorAll(SlidesController.VIMEO_MEDIA_CONTAINER);
        for(let i = 0; i < vimeo.length; i++){
            // Load Images asynchronously
            (function(i){
                $.ajax({
                    url: 'https://vimeo.com/api/v2/video/' + vimeo[i].dataset.media + '.json',
                    dataType: 'jsonp',
                    success: function(data) {
                        let image = new Image();
                        image.src = data[0].thumbnail_large;
                        image.addEventListener("load", function () {
                            vimeo[i].appendChild(image);
                        }(i));
                    }
                });
            })(i);

            $(vimeo[i]).find(SlidesController.PLAY_BUTTON).on('click', function(){
                SlidesController._loadVimeoVideo($(this));
            });
        }
    },

    _loadYoutubeVideo: function _loadYoutubeVideo($button){
        let media = $button.parent().attr('data-media');
        let iframe = document.createElement("iframe");

        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("allowfullscreen", "");
        iframe.setAttribute("src", "https://www.youtube.com/embed/" + media + "?rel=0&showinfo=0&autoplay=1");

        $button.parent().find('img').remove();
        $button.parent().html(iframe);
    },

    _loadVimeoVideo: function _loadVimeoVideo($button){
        let media = $button.parent().attr('data-media');
        let iframe = document.createElement("iframe");

        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("allowfullscreen", "");
        iframe.setAttribute("src", "https://player.vimeo.com/video/" + media + "?autoplay=1&byline=0&amp;portrait='0'");

        $button.parent().find('img').remove();
        $button.parent().html(iframe);
    },

    // ---------------------------------------------- Start --------------------------------------------------//
    start: function start(){
        // Ajust the height to 16:9
        this._ajustAdsContainerHeight();
        // Load Videos Thumbs and play events
        this._loadYoutubeThumbs();
        this._loadVimeoThumbs();
        // Activate the slick slide
        this._loadSlickSlide();
        // Activate listeners functions
        this._listeners();
    }
};