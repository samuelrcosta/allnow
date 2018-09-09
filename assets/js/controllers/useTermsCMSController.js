const PageController = {

  FORM: "#pageForm",
  NOTICE_CONTAINER: ".container-notices",
  SAVE_BUTTON: ".save-button",

  _text: null,

  _listeners: function _listeners(){
    // Fill data
    PageController._fillData();
    // Validate fields
    PageController._validateFields();
  },

  _fillData: function _fillData(){
    $("#text").val(PageController._text);
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
    let formData = new FormData();
    formData.append('text', CKEDITOR.instances.text.getData());
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
      url: BASE_URL + 'useTermsCMS/saveData',
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

  start: function start(text){
    // Storage data
    this._text = text;
    //CKEDITOR
    CKEDITOR.replace('text');

    // Activate listeners
    this._listeners();
  }
};