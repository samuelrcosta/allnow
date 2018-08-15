const PageController = {

    FORM: "#pageForm",
    NOTICE_CONTAINER: ".container-notices",
    SAVE_BUTTON: ".save-button",

    _configData: null,

    _listeners: function _listeners(){
        // Fill data
        PageController._fillData();
        // Validate fields
        PageController._validateFields();
        // On change the active radio
        $("#active_radio").change(function(){
            PageController._radioChange($(this).prop("checked"));
        });
    },

    _fillData: function _fillData(){
        if(PageController._configData.status === 'on'){
            $('#active_radio').prop("checked", true);
            $("#title").attr("data-validation", "required");
            $("#text").attr("data-validation", "");
            $("#media_type").attr("data-validation", "required");
            $("#media_link").attr("data-validation", "required");
        }
        $("#title").val(PageController._configData.data.title);
        $("#text").val(PageController._configData.data.text);
        $("#media_type").val(PageController._configData.data.media_type);
        $("#media_link").val(PageController._configData.data.media_link);
    },

    _radioChange: function _radioChange(value){
        if(value === true){
            // Activate validations
            $("#title").attr("data-validation", "required");
            $("#text").attr("data-validation", "");
            $("#media_type").attr("data-validation", "required");
            $("#media_link").attr("data-validation", "required");
        }else{
            // Reset errors
            $(PageController.FORM).get(0).reset();
            $(PageController.NOTICE_CONTAINER).html("");
            // Disable validation
            $("#title").attr("data-validation", "");
            $("#text").attr("data-validation", "");
            $("#media_type").attr("data-validation", "");
            $("#media_link").attr("data-validation", "");
        }
    },

    _validateFields: function _validateFields(){
        $.validate({
            form : PageController.FORM,
            onError : function($form) {
                return false;
            },
            onSuccess : function($form) {
                $(PageController.NOTICE_CONTAINER).hide();
                $(PageController.NOTICE_CONTAINER).html("");
                // TurnOff the save button
                $(PageController.SAVE_BUTTON).attr('disabled', true).html('<i class="fa fa-spinner"></i> Aguarde');
                setTimeout(PageController._saveData, 0);
                return false; // Will stop the submission of the form
            }
        });
    },

    _saveData: function _saveData(){
        let formData = new FormData($(PageController.FORM)[0]);
        let sending = JSON.parse(PageController.sendForm(formData));
        if(sending === true){
            $(PageController.NOTICE_CONTAINER).html('<div class="alert alert-success" role="alert"> Informações salvas com sucesso !</div>').show();
            $(PageController.SAVE_BUTTON).attr('disabled', false).html('<i class="fa fa-save"></i> Salvar');
        }else{
            $(PageController.NOTICE_CONTAINER).html('<div class="alert alert-warning" role="alert">' + sending + '</div>').show();
            $(PageController.SAVE_BUTTON).attr('disabled', false).html('<i class="fa fa-save"></i> Salvar');
        }
    },



    // ---------------------------------------------- sendForm --------------------------------------------------//
    sendForm: function sendForm(formData){
        let callback = false;
        $.ajax({
            url: BASE_URL + 'homePageTutorialCMS/saveData',
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

    start: function start(configData){
        // Storage data
        this._configData = configData;

        // Activate listeners
        this._listeners();
    }
};