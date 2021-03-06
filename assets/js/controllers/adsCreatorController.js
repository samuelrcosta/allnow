var PageController = {

    // inputs
    INPUT_TITLE: '#title',
    SELECT_CATEGORY: '#id_category',
    SELECT_SUBCATEGORY: '#id_subcategory',
    TEXTAREA_ABSTRACT: '#abstract',
    TEXTAREA_DESCRIPTION: '#description',
    SELECT_RATING: '#rating',
    CHECK_HIGHLIGHT: '#highlight',
    CHECK_NEW: '#new',
    CHECK_BEST_SELLER: '#bestseller',
    CHECK_SALE: '#sale',
    INPUT_IMAGE: 'input[name="image"]',
    SELECT_MEDIA_TYPE: 'select[name="media_type"]',
    INPUT_MEDIA_LINK: 'input[name="media_link"]',
    // buttons
    BUTTON_ADD_MEDIA: "#button-add-media",
    BUTTON_REMOVE_MEDIA: ".button-remove-media",
    BUTTON_SAVE_ADVERTISEMENT: '.save-advertisement',

    // containers
    MEDIA_CONTAINER: '.media-container',
    NOTICE_CONTAINER: '.container-notices',
    // Resize
    RESIZE: new window.resize(),

    _base_url: null,

    listeners: function listeners(){
        // Filds validation
        PageController._validateFields();
        // When choose a image
        $(PageController.INPUT_IMAGE).change(PageController._renderizeImage);

        $(PageController.SELECT_CATEGORY).change(PageController._renderSubCategories);

        $(PageController.SELECT_MEDIA_TYPE).change(PageController.validateMediaType);

        $(PageController.BUTTON_ADD_MEDIA).click(PageController._addNewMediaFields);
    },

    _validateFields: function _validateFields(){
        $.validate({
            form : '#register',
            modules : 'file',
            onError : function($form) {
                $(PageController.NOTICE_CONTAINER).html('<div class="alert alert-warning" role="alert"> Preencha todos os campos obrigatórios.</div>');
                return false;
            },
            onSuccess : function($form) {
                $(PageController.NOTICE_CONTAINER).hide();
                $(PageController.NOTICE_CONTAINER).html("");
                PageController._saveAdvetisement();
                return false; // Will stop the submission of the form
            }
        });
    },

    _saveAdvetisement: function _saveAdvetisement(){
        // TurnOff the save button
        $(PageController.BUTTON_SAVE_ADVERTISEMENT).attr('disabled', true).html('<i class="fa fa-spinner"></i> Aguarde');
        var formData = new FormData();
        // Creates the formData
        formData.append('title', $(PageController.INPUT_TITLE).val());
        formData.append('id_category', $(PageController.SELECT_CATEGORY).val());
        formData.append('id_subcategory', $(PageController.SELECT_SUBCATEGORY).val());
        formData.append('abstract', $(PageController.TEXTAREA_ABSTRACT).val());
        formData.append('description', CKEDITOR.instances.description.getData());
        formData.append('rating', $(PageController.SELECT_RATING).val());
        formData.append('highlight', $(PageController.CHECK_HIGHLIGHT).prop('checked'));
        formData.append('new', $(PageController.CHECK_NEW).prop('checked'));
        formData.append('bestseller', $(PageController.CHECK_BEST_SELLER).prop('checked'));
        formData.append('sale', $(PageController.CHECK_SALE).prop('checked'));
        // Add media
        var medias = [];
        $(PageController.MEDIA_CONTAINER).map(function(){
            medias.push({'media_type': $(this).find(PageController.SELECT_MEDIA_TYPE).val(), 'media_link': $(this).find(PageController.INPUT_MEDIA_LINK).val()});
        });
        formData.append('medias', JSON.stringify(medias));
        var sending = PageController.sendForm(formData);
        if(sending == 'true'){
            let urlData = encodeURI("?notification=Anúncio cadastrado com sucesso&status=alert-success");
            window.location.replace(PageController._base_url + 'adminAdvertisementsCMS'+urlData);
        }else{
            $(PageController.NOTICE_CONTAINER).html('<div class="alert alert-warning" role="alert">' + sending + '</div>').show();
            $(PageController.BUTTON_SAVE_ADVERTISEMENT).attr('disabled', false).html('<i class="fa fa-save"></i> Salvar');
        }
    },

    _renderSubCategories: function _renderSubCategories(){
        var $element = $(this);
        if( $element.val() ) {
            $(PageController.SELECT_SUBCATEGORY).html('<option value="">Carregando</option>');
            $.getJSON(PageController._base_url + 'subcategoriesCMS/getSubcategories/' + btoa(btoa($element.val())), function(j){
                var options = '<option value=""></option>';
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
                }
                $(PageController.SELECT_SUBCATEGORY).html(options);
            });
        } else {
            $(PageController.SELECT_SUBCATEGORY).html('<option value="">-- Escolha uma categoria Principal --</option>');
        }
    },

    validateMediaType: function validateMediaType(){
        var $container = $(this).parent().parent();
        if( $(this).val() == "3" ) {
            $container.find(".div-image").slideDown();
            $container.find('input[name="image"]').attr("data-validation", "required mime size");
            $container.find(".image-area").html("");
            PageController._validateFields();
            $container.find(".div-link").slideUp();
        }else{
            $container.find(".div-image").slideUp();
            $container.find('input[name="image"]').removeAttr("data-validation");
            $container.find('input[name="media_link"]').attr("data-validation", "url").val("");
            PageController._validateFields();
            $container.find(".div-link").slideDown();
        }
    },

    _addNewMediaFields: function _addNewMediaFields(){
        var template = $("#template-new-media").html();
        template = $(template);
        $("#media_containers").append(template);
        template.find(PageController.INPUT_IMAGE).change(PageController._renderizeImage);
        template.find(PageController.SELECT_MEDIA_TYPE).change(PageController.validateMediaType);
        template.find(PageController.BUTTON_REMOVE_MEDIA).click(PageController._removeMedia);
        PageController._validateFields();
    },

    _removeMedia: function _removeMedia(){
        $element = $(this);
        $container = $element.parent().parent();
        // remove container
        $container.remove();
    },

    // -------------------------------------- Image rendering -------------------------------------- //
    // Renderiza a imagem
    _renderizeImage: function _renderizeImage() {
        var $elemento = $(this);
        var $container = $elemento.parent().parent();
        // Verify if the navegator have capacity
        if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
            alert('O navegador não suporta os recursos utilizados pelo aplicativo');
            return;
        }
        // Saving the image
        var image = $elemento[0].files;
        // If send at least one image
        if (image.length > 0) {
            // Set 0% in progress bar
            $container.find('.progresso').attr('aria-valuenow', 0).css('width', '0%');
            // Hinding image input
            $elemento.hide();
            // Start the image resizing
            if(PageController._resizeImage($elemento, image)){
                // Shows the finish image
                $container.find('.progresso').append('Imagen(s) enviada(s) com sucesso');
                // Showing the image input
                $elemento.show();
            }else{
                // Refresh the progress bar
                var progress = 100;
                $container.find('.progresso').text(Math.round(progress) + '%').attr('aria-valuenow', progress).css('width', progress + '%');
                // Shows the error
                $container.find('.progresso').append('Arquivo de imagem inválido');
            }
        }
    },

    _resizeImage: function _resizeImage($elemento, image) {
        var $container = $elemento.parent().parent();
        // If is not a valid image
        if ((typeof image[0] !== 'object') || (image[0] == null)) {
            // Returns error
            return false;
        }else{
            // Resizing the image
            PageController.RESIZE.photo(image[0], 800, 'dataURL', function (imagem) {
                // Creating the image tag
                var mediaInput = "<h5>Pré-visulização da imagem:</h5><img width='100%' src='" + imagem + "' >";
                // Triggering the media_link input
                $container.find("input[name='media_link']").val(imagem);
                // Show the selected image
                $container.find(".image-area").html(mediaInput);
                // Refresh the progress bar
                var progress = 100;
                $container.find('.progresso').text(Math.round(progress) + '%').attr('aria-valuenow', progress).css('width', progress + '%');
            });
            // Return success
            return true;
        }
    },

    // ---------------------------------------------- sendForm --------------------------------------------------//
    sendForm: function sendForm(formData){
        var callback = false;
        $.ajax({
            url: PageController._base_url + 'adminAdvertisementsCMS/saveNewAdvertisement',
            data: formData,
            async: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                callback = data;
            }
        });
        return callback;
    },

    start: function start(base_url){
        //CKEDITOR
        CKEDITOR.replace('description');
        // Initializing resize library
        PageController.RESIZE.init();
        this._base_url = base_url;
        this.listeners();
    }
};