const PageController = {
    // Ids
    INPUT_SEARCH: '#search',
    CONFIRM_DELETE: "#confirm-delete",
    BACKGROUND_DARK: "#background-dark",

    // buttons
    BUTTON_EDIT_SUBCATEGORY: '.edit-subcategory',
    BUTTON_DELETE_SUBCATEGORY: '.delete-subcategory',
    BUTTON_CONFIRM_DELETE: '#btn-confirm-delete',
    BUTTON_NOT_DELETE: "#btn-not-delete",

    // containers
    CONTAINER_LIST_SUBCATEGORIES: "#subcategories_result",

    // Templates
    TEMPLATE_TABLE_SUBCATEGORIES: "template-table-subcategories",

    // Variables for control and storage
    _subcategoriesList: null,
    _subcategoryId: null,

    // Variables to storage templates
    _templateTableSubcategories: '',

    // ---------------------------------------------- LoadTemplates --------------------------------------------------//
    _loadTemplates: function _loadTemplates(){
        this._templateTableSubcategories = document.getElementById(PageController.TEMPLATE_TABLE_SUBCATEGORIES).innerHTML;
    },

    _listeners: function _listeners(){
        // On search input change
        $(PageController.INPUT_SEARCH).keyup(function(){
            PageController._search($(this).val());
        });

        // On confirm to delete
        $(PageController.BUTTON_CONFIRM_DELETE).click(function(){
            // Redirects to delete page
            let id = btoa(btoa(PageController._subcategoryId));
            window.location.replace(BASE_URL + 'subcategoriesCMS/deleteSubCategory/' + id);
        });

        // On not confirm to delete
        $(PageController.BUTTON_NOT_DELETE).click(function(){
            // Hide dark background and alert
            $(PageController.BACKGROUND_DARK).hide();
            $(PageController.CONFIRM_DELETE).hide();
        });
    },

    _listenersTableButtons: function _listenersTableButtons(){
        $(PageController.BUTTON_DELETE_SUBCATEGORY).click(function(){
            PageController._subcategoryId = $(this).parent().attr('data-id');
            // Shows dark background and alert
            $(PageController.BACKGROUND_DARK).show();
            $(PageController.CONFIRM_DELETE).show();
        });

        $(PageController.BUTTON_EDIT_SUBCATEGORY).click(function(){
            // Redirects to view page
            let id = $(this).parent().attr('data-id');
            id = btoa(btoa(id));
            window.location.replace(BASE_URL + 'subcategoriesCMS/editSubCategory/'+id);
        });
    },

    // ---------------------------------------------- renders --------------------------------------------------//
    _render: function _render(template, data){
        return Mustache.render(template, data);
    },

    _renderList: function _renderList(list){
        // Checks if the list have itens
        if(list.length > 0){
            let render = PageController._render(PageController._templateTableSubcategories, list);
            $(PageController.CONTAINER_LIST_SUBCATEGORIES).html(render);
            // Activate boostrap tooltip
            $('[data-toggle="tooltip"]').tooltip();
            // Activate buttons listeners
            PageController._listenersTableButtons();
        }else{
            let msg = "<tr><td colspan='6' style='text-align: center; font-weight: bold'>Nenhuma subcategoria encontrada.</td></tr>";
            $(PageController.CONTAINER_LIST_SUBCATEGORIES).html(msg);
        }
    },

    // ---------------------------------------------- Utils --------------------------------------------------//
    _saveList: function _saveList(list){
        PageController._subcategoriesList = list;
    },

    _search: function _search(term){
        term = term.toLowerCase();
        list = [];
        for(let i = 0; i < PageController._subcategoriesList.length; i++){
            let name = PageController._subcategoriesList[i].name.toLowerCase();
            let description = (PageController._subcategoriesList[i].description != null) ? PageController._subcategoriesList[i].description.toLowerCase() : '';
            let principal_name = PageController._subcategoriesList[i].principal_name.toLowerCase();

            if(name.search(term) !== -1 || description.search(term) !== -1 || principal_name.search(term) !== -1){
                list.push(PageController._subcategoriesList[i]);
            }
        }

        PageController._renderList(list);
    },

    // ---------------------------------------------- Start --------------------------------------------------//

    start: function start(subcategoriesList){
        // Load all templates
        this._loadTemplates();
        // Get categories list
        this._saveList(subcategoriesList);
        // Render all categories
        this._renderList(PageController._subcategoriesList);
        // Activate page listeners
        this._listeners();
    }
};