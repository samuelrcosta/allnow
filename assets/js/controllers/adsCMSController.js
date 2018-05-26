const PageController = {
    // Ids
    INPUT_SEARCH: '#search',
    CONFIRM_DELETE: "#confirm-delete",
    BACKGROUND_DARK: "#background-dark",

    // buttons
    BUTTON_EDIT_AD: '.edit-ad',
    BUTTON_DELETE_AD: '.delete-ad',
    BUTTON_CONFIRM_DELETE: '#btn-confirm-delete',
    BUTTON_NOT_DELETE: "#btn-not-delete",

    // containers
    CONTAINER_LIST_ADS: "#advertisements_result",

    // Templates
    TEMPLATE_TABLE_ADS: "template-table-advertisements",

    // Variables for control and storage
    _adsList: null,
    _adId: null,

    // Variables to storage templates
    _templateTableAds: '',

    // ---------------------------------------------- LoadTemplates --------------------------------------------------//
    _loadTemplates: function _loadTemplates(){
        this._templateTableAds = document.getElementById(PageController.TEMPLATE_TABLE_ADS).innerHTML;
    },

    _listeners: function _listeners(){
        // On search input change
        $(PageController.INPUT_SEARCH).keyup(function(){
            PageController._searchAds($(this).val());
        });

        // On confirm to delete
        $(PageController.BUTTON_CONFIRM_DELETE).click(function(){
            // Redirects to delete page
            let id = btoa(btoa(PageController._adId));
            window.location.replace(BASE_URL + 'adminAdvertisementsCMS/deleteAdvertisement/' + id);
        });

        // On not confirm to delete
        $(PageController.BUTTON_NOT_DELETE).click(function(){
            // Hide dark background and alert
            $(PageController.BACKGROUND_DARK).hide();
            $(PageController.CONFIRM_DELETE).hide();
        });
    },

    _listenersTableButtons: function _listenersTableButtons(){
        $(PageController.BUTTON_DELETE_AD).click(function(){
            PageController._adId = $(this).parent().attr('data-id');
            // Shows dark background and alert
            $(PageController.BACKGROUND_DARK).show();
            $(PageController.CONFIRM_DELETE).show();
        });

        $(PageController.BUTTON_EDIT_AD).click(function(){
            // Redirects to view page
            let id = $(this).parent().attr('data-id');
            id = btoa(btoa(id));
            window.location.replace(BASE_URL + 'adminAdvertisementsCMS/editAdvertisementPage/'+id);
        });
    },

    // ---------------------------------------------- renders --------------------------------------------------//
    _render: function _render(template, data){
        return Mustache.render(template, data);
    },

    _renderAdsList: function _renderAdsList(list){
        // Checks if the list have ads
        if(list.length > 0){
            let render = PageController._render(PageController._templateTableAds, list);
            $(PageController.CONTAINER_LIST_ADS).html(render);
            // Activate boostrap tooltip
            $('[data-toggle="tooltip"]').tooltip();
            // Activate buttons listeners
            PageController._listenersTableButtons();
        }else{
            let msg = "<tr><td colspan='6' style='text-align: center; font-weight: bold'>Nenhum anúncio encontrado.</td></tr>";
            $(PageController.CONTAINER_LIST_ADS).html(msg);
        }
    },

    // ---------------------------------------------- Utils --------------------------------------------------//
    _saveAdsList: function _saveAdsList(adsList){
        PageController._adsList = adsList;
    },

    _searchAds: function _searchAds(term){
        term = term.toLowerCase();
        list = [];
        for(let i = 0; i < PageController._adsList.length; i++){
            let title = PageController._adsList[i].title.toLowerCase();
            let category_name = PageController._adsList[i].category_name.toLowerCase();
            let subcategory_name = PageController._adsList[i].subcategory_name.toLowerCase();
            let abstract = PageController._adsList[i].abstract.toLowerCase();

            if(title.search(term) !== -1 || category_name.search(term) !== -1 || subcategory_name.search(term) !== -1 || abstract.search(term) !== -1){
                list.push(PageController._adsList[i]);
            }
        }

        PageController._renderAdsList(list);
    },

    // ---------------------------------------------- Start --------------------------------------------------//

    start: function start(adsList){
        // Load all templates
        this._loadTemplates();
        // Get ads list
        this._saveAdsList(adsList);
        // Render all ads
        this._renderAdsList(PageController._adsList);
        // Activate page listeners
        this._listeners();
    }
};