const PageController = {

    FORM: "#pageForm",
    FORM_BANNER: "#bannerForm",
    NOTICE_CONTAINER: ".container-notices",
    SAVE_BUTTON: ".save-button",

    INPUT_IMAGE: "#image",

    _configData: null,
    _banner_array: [],

    RESIZE: new window.resize(),

    _templateAddWord: "",
    _templateWordsList: "",

    _loadTemplates: function _loadTemplates(){
        this._templateAddWord = document.getElementById('template-add-word').innerHTML;
        this._templateWordsList = document.getElementById('template-repeat-word').innerHTML;
    },

    _render: function _render(template, dados){
        return Mustache.render(template, dados);
    },

    _listeners: function _listeners(){
        // Fill data
        PageController._fillData();
        // Validate fields
        PageController._validateFields();
        // On change the active radio
        $("#active_radio").change(function(){
            PageController._radioChange($(this).prop("checked"));
        });
        // When choose a image
        $(PageController.INPUT_IMAGE).change(PageController._renderizeImage);
        // When add a word
        $(PageController.FORM_BANNER).on("click", "#btnAddWord", PageController._addWord);
        // When remove a word
        $(PageController.FORM_BANNER).on('click', ".btnRemoveWord", PageController._removeWord);
        // When click on checkbox
        $("#banner_repeat").change(function(){
            PageController._bannerRadioChange($(this).prop("checked"));
        });
    },

    _fillData: function _fillData(){
      PageController._configData.tutorial_advertisement = JSON.parse(PageController._configData.tutorial_advertisement);
        if(PageController._configData.tutorial_advertisement.status === 'on'){
            $('#active_radio').prop("checked", true);
            $("#title").attr("data-validation", "required");
            $("#text").attr("data-validation", "");
            $("#media_type").attr("data-validation", "required");
            $("#media_link").attr("data-validation", "required");
        }
        $("#title").val(PageController._configData.tutorial_advertisement.data.title);
        $("#text").val(PageController._configData.tutorial_advertisement.data.text);
        $("#media_type").val(PageController._configData.tutorial_advertisement.data.media_type);
        $("#media_link").val(PageController._configData.tutorial_advertisement.data.media_link);

        // Banner area
        $("#banner_text").val(PageController._configData.banner_text);
        PageController._banner_array = JSON.parse(PageController._configData.banner_array);
        if(PageController._banner_array.length > 0){
          $('#banner_repeat').prop("checked", true);
          $("#repeat_words").attr("data-validation", "required");
          PageController._renderBannerWords();
        }
        $(".image-area").html("<img width='600' src='" + BASE_URL + "assets/images/banner/" + PageController._configData.banner_image + "' />");
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
                $(PageController.FORM).find(PageController.NOTICE_CONTAINER).hide();
                $(PageController.FORM).find(PageController.NOTICE_CONTAINER).html("");
                // TurnOff the save button
                $(PageController.FORM).find(PageController.SAVE_BUTTON).attr('disabled', true).html('<i class="fa fa-spinner"></i> Aguarde');
                setTimeout(PageController._saveData, 0);
                return false; // Will stop the submission of the form
            }
        });

      $.validate({
        form : PageController.FORM_BANNER,
        modules : 'security, file',
        onError : function($form) {
          return false;
        },
        onSuccess : function($form) {
          $(PageController.FORM_BANNER).find(PageController.NOTICE_CONTAINER).hide();
          $(PageController.FORM_BANNER).find(PageController.NOTICE_CONTAINER).html("");
          // TurnOff the save button
          $(PageController.FORM_BANNER).find(PageController.SAVE_BUTTON).attr('disabled', true).html('<i class="fa fa-spinner"></i> Aguarde');
          setTimeout(PageController._saveBannerData, 0);
          return false; // Will stop the submission of the form
        }
      });
    },

  _renderBannerWords: function _renderBannerWords(){
    if(PageController._banner_array.length > 0){
      $("#repeat_words").val(PageController._banner_array[0]);
      let array = PageController._banner_array;
      PageController._banner_array.shift();
      let data = PageController._banner_array;
      PageController._banner_array = array;
      let rendered = PageController._render(PageController._templateWordsList, data);
      $(".container-repeat-words").append(rendered);
    }else{
        $("#repeat_words").val("");
    }
  },

  _addWord: function _addWord(){
    $(".container-repeat-words").append(PageController._templateAddWord);
  },

  _removeWord: function _removeWord(){
        $button = $(this);
        $container = $(this).parent().parent().parent();
        $container.remove();
  },

  _bannerRadioChange: function _bannerRadioChange(choose){
        if(choose == true){
            $("#repeat_words").attr("disabled", false);
            $("#btnAddWord").attr("disabled", false);
            $("#repeat_words").attr("data-validation", "required");
        }else{
              // Reset errors
            $("#repeat_words").attr("disabled", true).val("").validate();
            $("#btnAddWord").attr("disabled", true);
            $("#repeat_words").attr("data-validation", "");
            $(".template_repeat_word_add").remove();
        }
  },

    _saveData: function _saveData(){
        let formData = new FormData($(PageController.FORM)[0]);
        let sending = JSON.parse(PageController.sendForm('saveData', formData));
        if(sending === true){
          $(PageController.FORM).find(PageController.NOTICE_CONTAINER).html('<div class="alert alert-success notification" role="alert"> Informações salvas com sucesso !</div>').show();
          $(PageController.FORM).find(PageController.SAVE_BUTTON).attr('disabled', false).html('<i class="fa fa-save"></i> Salvar');
        }else{
          $(PageController.FORM).find(PageController.NOTICE_CONTAINER).html('<div class="alert alert-warning" role="alert">' + sending + '</div>').show();
          $(PageController.FORM).find(PageController.SAVE_BUTTON).attr('disabled', false).html('<i class="fa fa-save"></i> Salvar');
        }
    },

  _saveBannerData: function _saveBannerData(){
    let formData = new FormData($(PageController.FORM_BANNER)[0]);
    let sending = JSON.parse(PageController.sendForm('saveBannerData', formData));
    if(sending === true){
      $(PageController.FORM_BANNER).find(PageController.NOTICE_CONTAINER).html('<div class="alert alert-success notification" role="alert"> Informações salvas com sucesso !</div>').show();
      $(PageController.FORM_BANNER).find(PageController.SAVE_BUTTON).attr('disabled', false).html('<i class="fa fa-save"></i> Salvar');
    }else{
      $(PageController.FORM_BANNER).find(PageController.NOTICE_CONTAINER).html('<div class="alert alert-warning" role="alert">' + sending + '</div>').show();
      $(PageController.FORM_BANNER).find(PageController.SAVE_BUTTON).attr('disabled', false).html('<i class="fa fa-save"></i> Salvar');
    }
  },


  // -------------------------------------- Image rendering -------------------------------------- //
  // Renderiza a imagem
  _renderizeImage: function _renderizeImage() {
    let $elemento = $(this);
    let $container = $elemento.parent().parent();
    // Verify if the navegator have capacity
    if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
      alert('O navegador não suporta os recursos utilizados pelo aplicativo');
      return;
    }
    // Saving the image
    let image = $elemento[0].files;
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
        let progress = 100;
        $container.find('.progresso').text(Math.round(progress) + '%').attr('aria-valuenow', progress).css('width', progress + '%');
        // Shows the error
        $container.find('.progresso').append('Arquivo de imagem inválido');
      }
    }
  },

  _resizeImage: function _resizeImage($elemento, image) {
    let $container = $elemento.parent().parent();
    // If is not a valid image
    if ((typeof image[0] !== 'object') || (image[0] == null)) {
      // Returns error
      return false;
    }else{
      // Resizing the image
      PageController.RESIZE.photo(image[0], 800, 'dataURL', function (imagem) {
        // Creating the image tag
        let imageTag = "<h5>Pré-visulização da imagem:</h5><img width='600' src='" + imagem + "' >";
        // Show the selected image
        $container.find(".image-area").html(imageTag);
        // Refresh the progress bar
        let progress = 100;
        $container.find('.progresso').text(Math.round(progress) + '%').attr('aria-valuenow', progress).css('width', progress + '%');
      });
      // Return success
      return true;
    }
  },


    // ----------------------------------------- sendForm -------------------------------------------//
    sendForm: function sendForm(method, formData){
        let callback = false;
        $.ajax({
            url: BASE_URL + 'homePageCMS/'+method,
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
        // Load Templates
        this._loadTemplates();
        // Initializing resize library
        PageController.RESIZE.init();

        // Storage data
        this._configData = configData;

        // Activate listeners
        this._listeners();
    }
};