const PageController = {
    // Ids
    INPUT_SEARCH: '#search',
    CONFIRM_DELETE: "#confirm-delete",
    BACKGROUND_DARK: "#background-dark",

    // buttons
    BUTTON_EDIT_AREA: '.edit-area',
    BUTTON_DELETE_AREA: '.delete-area',
    BUTTON_CONFIRM_DELETE: '#btn-confirm-delete',
    BUTTON_NOT_DELETE: "#btn-not-delete",

    // containers
    CONTAINER_LIST_AREAS: "#areas_result",

    // Templates
    TEMPLATE_TABLE_AREAS: "template-table-areas",

    // Variables for control and storage
    _areasList: null,
    _areaId: null,

    // Variables to storage templates
    _templateTableAreas: '',

    // ---------------------------------------------- LoadTemplates --------------------------------------------------//
    _loadTemplates: function _loadTemplates(){
        this._templateTableAreas = document.getElementById(PageController.TEMPLATE_TABLE_AREAS).innerHTML;
    },

    _listeners: function _listeners(){
        // On search input change
        $(PageController.INPUT_SEARCH).keyup(function(){
            PageController._searchAreas($(this).val());
        });

        // On confirm to delete
        $(PageController.BUTTON_CONFIRM_DELETE).click(function(){
            // Redirects to delete page
            let id = btoa(btoa(PageController._areaId));
            window.location.replace(BASE_URL + 'areasCMS/delete/' + id);
        });

        // On not confirm to delete
        $(PageController.BUTTON_NOT_DELETE).click(function(){
            // Hide dark background and alert
            $(PageController.BACKGROUND_DARK).hide();
            $(PageController.CONFIRM_DELETE).hide();
        });
    },

    _listenersTableButtons: function _listenersTableButtons(){
        $(PageController.BUTTON_DELETE_AREA).click(function(){
            PageController._areaId = $(this).parent().attr('data-id');
            // Shows dark background and alert
            $(PageController.BACKGROUND_DARK).show();
            $(PageController.CONFIRM_DELETE).show();
        });

        $(PageController.BUTTON_EDIT_AREA).click(function(){
            // Redirects to view page
            let id = $(this).parent().attr('data-id');
            id = btoa(btoa(id));
            window.location.replace(BASE_URL + 'areasCMS/editArea/'+id);
        });
    },

    // ---------------------------------------------- renders --------------------------------------------------//
    _render: function _render(template, data){
        return Mustache.render(template, data);
    },

    _renderAreasList: function _renderAreasList(list){
        // Checks if the list have areas
        if(list.length > 0){
            let render = PageController._render(PageController._templateTableAreas, list);
            $(PageController.CONTAINER_LIST_AREAS).html(render);
            // Activate boostrap tooltip
            $('[data-toggle="tooltip"]').tooltip();
            // Activate buttons listeners
            PageController._listenersTableButtons();
        }else{
            let msg = "<tr><td colspan='6' style='text-align: center; font-weight: bold'>Nenhuma área encontrada.</td></tr>";
            $(PageController.CONTAINER_LIST_AREAS).html(msg);
            // Block input search
            $(PageController.INPUT_SEARCH).attr('disabled', true);
        }
    },

    // ---------------------------------------------- Utils --------------------------------------------------//
    _saveAreasList: function _saveAreasList(areasList){
        PageController._areasList = areasList;
    },

    _searchAreas: function _searchAreas(term){
        term = term.toLowerCase();
        list = [];
        for(let i = 0; i < PageController._areasList.length; i++){
            let name = PageController._areasList[i].name.toLowerCase();
            if(name.search(term) !== -1){
                list.push(PageController._areasList[i]);
            }
        }

        PageController._renderAreasList(list);
    },

    // ---------------------------------------------- Start --------------------------------------------------//

    start: function start(areasList){
        // Load all templates
        this._loadTemplates();
        // Get areas list
        this._saveAreasList(areasList);
        // Render all areas
        this._renderAreasList(PageController._areasList);
        // Activate page listeners
        this._listeners();
    }
};