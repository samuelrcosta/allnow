const PageController = {
    // Ids
    INPUT_SEARCH: '#search',
    CONFIRM_DELETE: "#confirm-delete",
    BACKGROUND_DARK: "#background-dark",

    // buttons
    BUTTON_EDIT_CATEGORY: '.edit-category',
    BUTTON_DELETE_CATEGORY: '.delete-category',
    BUTTON_CONFIRM_DELETE: '#btn-confirm-delete',
    BUTTON_NOT_DELETE: "#btn-not-delete",

    // containers
    CONTAINER_LIST_CATEGORIES: "#categories_result",

    // Templates
    TEMPLATE_TABLE_CATEGORIES: "template-table-categories",

    // Variables for control and storage
    _categoriesList: null,
    _categoryId: null,

    // Variables to storage templates
    _templateTableCategories: '',

    // ---------------------------------------------- LoadTemplates --------------------------------------------------//
    _loadTemplates: function _loadTemplates(){
        this._templateTableCategories = document.getElementById(PageController.TEMPLATE_TABLE_CATEGORIES).innerHTML;
    },

    _listeners: function _listeners(){
        // On search input change
        $(PageController.INPUT_SEARCH).keyup(function(){
            PageController._search($(this).val());
        });

        // On confirm to delete
        $(PageController.BUTTON_CONFIRM_DELETE).click(function(){
            // Redirects to delete page
            let id = btoa(btoa(PageController._categoryId));
            window.location.replace(BASE_URL + 'categoriesCMS/deleteCategory/' + id);
        });

        // On not confirm to delete
        $(PageController.BUTTON_NOT_DELETE).click(function(){
            // Hide dark background and alert
            $(PageController.BACKGROUND_DARK).hide();
            $(PageController.CONFIRM_DELETE).hide();
        });
    },

    _listenersTableButtons: function _listenersTableButtons(){
        $(PageController.BUTTON_DELETE_CATEGORY).click(function(){
            PageController._categoryId = $(this).parent().attr('data-id');
            // Shows dark background and alert
            $(PageController.BACKGROUND_DARK).show();
            $(PageController.CONFIRM_DELETE).show();
        });

        $(PageController.BUTTON_EDIT_CATEGORY).click(function(){
            // Redirects to view page
            let id = $(this).parent().attr('data-id');
            id = btoa(btoa(id));
            window.location.replace(BASE_URL + 'categoriesCMS/editCategory/'+id);
        });
    },

    // ---------------------------------------------- renders --------------------------------------------------//
    _render: function _render(template, data){
        return Mustache.render(template, data);
    },

    _renderList: function _renderList(list){
        // Checks if the list have itens
        if(list.length > 0){
            let render = PageController._render(PageController._templateTableCategories, list);
            $(PageController.CONTAINER_LIST_CATEGORIES).html(render);
            // Activate boostrap tooltip
            $('[data-toggle="tooltip"]').tooltip();
            // Activate buttons listeners
            PageController._listenersTableButtons();
        }else{
            let msg = "<tr><td colspan='6' style='text-align: center; font-weight: bold'>Nenhuma categoria encontrada.</td></tr>";
            $(PageController.CONTAINER_LIST_CATEGORIES).html(msg);
        }
    },

    // ---------------------------------------------- Utils --------------------------------------------------//
    _saveList: function _saveList(list){
        PageController._categoriesList = list;
    },

    _search: function _search(term){
        term = term.toLowerCase();
        list = [];
        for(let i = 0; i < PageController._categoriesList.length; i++){
            let name = PageController._categoriesList[i].name.toLowerCase();
            let description = (PageController._categoriesList[i].description != null) ? PageController._categoriesList[i].description.toLowerCase() : '';
            let area_name = PageController._categoriesList[i].area_name.toLowerCase();

            if(name.search(term) !== -1 || description.search(term) !== -1 || area_name.search(term) !== -1){
                list.push(PageController._categoriesList[i]);
            }
        }

        PageController._renderList(list);
    },

    // ---------------------------------------------- Start --------------------------------------------------//

    start: function start(categoriesList){
        // Load all templates
        this._loadTemplates();
        // Get categories list
        this._saveList(categoriesList);
        // Render all categories
        this._renderList(PageController._categoriesList);
        // Activate page listeners
        this._listeners();
    }
};