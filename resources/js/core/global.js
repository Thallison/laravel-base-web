App._flgGrid = function (value) {
    var ativo = '<span style="color:#dc3545;font-weight: bold;">Não</span>';
    if(value == 1){
        ativo = '<span  style="color:#28a745;font-weight: bold;">Sim</span>';
    }
    return [
        ativo
    ].join("");
}

App.tipoMensagem = function(value, row, index)
{
    let msg;
    switch (value) {
        case 1:
            msg = '<span class="badge bg-success">Ativo</span>';
            break;
        case 0:
            msg = '<span class="badge bg-danger">Inativo</span>';
            break;
        default:
            msg = '<span class="badge"> </span>';
            break;
    }

    return msg;
}

App.segundosParaTime = function(segundos) {
    if(segundos == null)
        return '-';

    const horas = Math.floor(segundos / 3600);
    const minutos = Math.floor((segundos % 3600) / 60);

    return String(horas).padStart(2, '0') + ':' + 
        String(minutos).padStart(2, '0');
}