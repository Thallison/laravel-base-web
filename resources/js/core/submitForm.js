App.submitForm = function(options = {}) {

    const form = document.querySelector(options.form);

    if (!form) return;

    const formData = new FormData(form);

    App.fetch({
        url: form.action,
        method: form.method || "POST",
        data: Object.fromEntries(formData.entries()),

        success: function(response){

            if(response.type === "success"){

                // fechar modal
                if(options.modal){
                    App.message(response.message, response.type);
                    const modal = document.querySelector(options.modal);
                    if(modal){
                        bootstrap.Modal.getInstance(modal).hide();
                    }
                }

                // atualizar tabela
                if(options.table){
                    $('#'+options.table).bootstrapTable('refresh');
                }

            }

        }
    });

}