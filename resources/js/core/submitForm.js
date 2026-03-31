App.submitForm = function(options = {}) {

    const form = document.querySelector(options.form);

    if (!form) return;

    const formData = new FormData(form);

    const clearValidationErrors = (formElement) => {
        formElement.querySelectorAll('.is-invalid').forEach((el) => {
            el.classList.remove('is-invalid');
        });

        formElement.querySelectorAll('.invalid-feedback').forEach((el) => {
            el.remove();
        });
    };

    const clearModalMessage = (modalElement) => {
        if(!modalElement) return;
        modalElement.querySelectorAll('.modal-alert').forEach((el) => el.remove());
    };

    const appendModalMessage = (modalElement, message, type = 'danger') => {
        if(!modalElement) return;

        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show modal-alert`;
        alert.setAttribute('role', 'alert');
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        const target = modalElement.querySelector('.modal-body') || modalElement.querySelector('form');
        if(target){
            target.insertAdjacentElement('afterbegin', alert);
        }
    };

    const appendValidationErrors = (formElement, errors) => {
        Object.entries(errors).forEach(([fieldName, messages]) => {
            const field = formElement.querySelector(`[name="${fieldName}"]`);
            if(!field){
                return;
            }

            field.classList.add('is-invalid');

            const feedback = document.createElement('span');
            feedback.className = 'invalid-feedback';
            feedback.setAttribute('role', 'alert');
            feedback.innerHTML = '<strong>' + messages[0] + '</strong>';

            field.insertAdjacentElement('afterend', feedback);
        });
    };

    App.fetch({
        url: form.action,
        method: form.method || "POST",
        data: formData,
        success: function(response){
            if(response.type === "success"){
                if(options.reload){
                    App.flash(response.message, response.type);
                    location.reload();
                }
                // fechar modal
                if(options.modal){
                    const modal = document.querySelector(options.modal);
                    if(modal){
                        bootstrap.Modal.getInstance(modal).hide();
                    }
                }

                // atualizar tabela
                if(options.table){
                    $('#'+options.table).bootstrapTable('refresh');
                }

                if(response.message){
                    App.message(response.message, response.type || "success");
                }
            }
        },
        error: function(err){
            if(form){
                clearValidationErrors(form);
            }

            const modal = options.modal ? document.querySelector(options.modal) : null;
            if(modal){
                clearModalMessage(modal);
            }

            if(err && err.data && err.data.errors && form){
                appendValidationErrors(form, err.data.errors);
                return;
            }

            if(err && err.data && err.data.message){
                if(modal){
                    appendModalMessage(modal, err.data.message, 'danger');
                    return;
                }
                App.message(err.data.message, 'danger');
            }
        }
    });

}