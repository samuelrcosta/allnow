const PageController = {
    // ids
    INPUT_IMAGE: "#image",
    // Resize
    RESIZE: new window.resize(),

    _listeners: function _listeners(){
        // When choose a image
        $(PageController.INPUT_IMAGE).change(PageController._renderizeImage);
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
                let imageTag = "<h5>Pré-visulização da imagem:</h5><img style='width: auto; max-width: 100%' src='" + imagem + "' >";
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

    // ---------------------------------------------- start --------------------------------------------------//

    start: function start(){
        // Initializing resize library
        PageController.RESIZE.init();
        // Activate listeners
        this._listeners();
    }
};