const PageController = {
    // Containers
    PHRASE_REPEAT_CONTAINER: "#phrase-repeat",

    // Ids
    SEARCH_FORM: '.nav-search',
    INPUT_SEARCH: '#search-input',

    // Variables for storage and controller
    _phrases: ["idiomas", "finanças", "negócios", "e muito mais"],
    _nowPhrase: 0,
    _timeToShow: 250,
    _timeToHide: 100,

    _listeners: function _listeners(){
        // Letters repeat show
        PageController._showLetters(PageController.PHRASE_REPEAT_CONTAINER, PageController._phrases[PageController._nowPhrase], 0, 250);
    },

    _showLetters: function _showLetters(target, message, index, interval) {
        if(index === message.length) {
            setTimeout(function(){
                PageController._deleteLetters(target, message, message.length, PageController._timeToHide);
            }, interval);
        }else if (index < message.length) {
            $(target).append("<span>" + message[index++] + "</span>");
            setTimeout(function(){
                PageController._showLetters(target, message, index, interval);
            }, interval);
        }
    },

    _deleteLetters: function _deleteLetters(target, message, index, interval) {
        if(index === 0){
            let nextPhrase = PageController._nowPhrase + 1;
            if(nextPhrase >= PageController._phrases.length){
                PageController._nowPhrase = 0;
            }else{
                PageController._nowPhrase = nextPhrase;
            }
            PageController._showLetters(target, PageController._phrases[PageController._nowPhrase], 0, PageController._timeToShow);
        }else{
            $(target).find('span').last().remove();
            index--;
            setTimeout(function () {
                PageController._deleteLetters(target, message, index, interval);
            }, interval);
        }
    },

    start: function start(){
        // Activate listeners functions
        this._listeners();
    }
};