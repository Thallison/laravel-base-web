App.modal = function(url, modalId = "modal_default", container = "modal-default-sistema"){
    App.fetch({
        url: url,
        method: "GET",
        responseType: "html",
        success: function(html){

            const modalContainer = document.getElementById(container);
            
            if(!modalContainer){
                console.error("Container do modal não encontrado:", container);
                return;
            }

            modalContainer.innerHTML = html;

            new bootstrap.Modal(
                document.getElementById(modalId)
            ).show();
        }
    });
};