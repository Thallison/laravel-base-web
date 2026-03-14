App.message = function(message, type="success"){

    const html = `
    <div class="alert alert-${type} alert-dismissible fade show flash-msg">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    `;

    const container = document.getElementById("content_area");

    if(container){
        container.insertAdjacentHTML("afterbegin", html);
    }

};