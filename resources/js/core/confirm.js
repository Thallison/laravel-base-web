App.confirm = function(options = {}) {

    const config = {
        title: options.title || "Confirmação",
        message: options.message || "Deseja realmente executar esta ação?",
        url: options.url || null,
        method: options.method || "DELETE",
        table: options.table || null
    };

    const modalHtml = `
        <div class="modal fade" id="appConfirmModal" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">${config.title}</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        ${config.message}
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-danger" id="confirmYes">Sim</button>
                    </div>

                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML("beforeend", modalHtml);

    const modalEl = document.getElementById("appConfirmModal");
    const modal = new bootstrap.Modal(modalEl);

    modal.show();

    document.getElementById("confirmYes").addEventListener("click", function(){

        if(config.url){
            App.fetch({
                url: config.url,
                method: config.method,
                success: function(response){
                    if(response.message){
                        App.message(response.message, response.type || "success");
                    }

                    if(config.table){
                        $('#'+config.table).bootstrapTable('refresh');
                    }
                }
            });
        }

        modal.hide();
        modalEl.remove();

    });

};