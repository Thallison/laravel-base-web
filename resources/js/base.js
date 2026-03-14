/*
    Plugin base para criação de alguns componentes para o sistema como modal, confirm entre outros
    necessário ter o boostrap
*/
if (typeof jQuery === 'undefined') {
    throw new Error('Plugin base\'s JavaScript requires jQuery');
}

var pluginBase = function() {

    var _color = function(colors){
        switch (colors) {
            case 'danger':
                cor = 'bg-danger';
                classHeader = 'bg-danger';
                break;
            case 'primary':
                cor = 'bg-primary';
                classHeader = 'bg-primary';
                break;
            case 'success':
                cor = 'bg-success';
                classHeader = 'bg-success';
                break;
            case 'info':
                cor = 'bg-info';
                classHeader = 'bg-info';
                break;
            case 'warning':
                cor = 'bg-warning';
                classHeader = 'bg-warning';
                break;
            default:
                cor = 'bg-primary'
                classHeader = '';
        }

        return [cor,classHeader];
    };

    /** Modal base para criação  */
    var _baseDialog = function(options, seletor){

        var modal = '\
            <div id="modal_'+options.type+'" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">'
                +'<div class="modal-dialog '+options.size+'">'
                    +'<div class="modal-content">'
                        +'<div class="modal-header '+options.classHeader+'">'
                            +'<h5 class="modal-title">'+options.title+'</h5>'
                            +'<button type="button" class="close" data-dismiss="modal">×</button>'
                        +'</div>'
                        +'<div class="modal-body">'
                            +'<span class="font-weight-semibold">'+options.body+'</span>'
                        +'</div>'
                        +'<div class="modal-footer">'+options.footer+'</div>'
                    +'</div>'
                +'</div>'
            +'</div>';

        $("body").append(modal);

        $("#modal_"+options.type).on('hidden.bs.modal', function (e) {
            $("#modal_"+options.type).remove();
        });

        $("#no_").click( function(){
            if (typeof options.no === "function") {
                options.no();
            }
            $("#modal_" + options.type).modal("hide");
        });

        $("#yes_").click(function () {

           //$('html, body').animate({scrollTop:0}, 'slow');

            if (typeof options.yes === "function") {
                options.yes();
            }

            if (seletor) {
                var obj = $(seletor);
                if (obj && obj.data('url') != undefined) {
                    //Realiza a requisição ajax automaticamente se tiver configurado o data-url no campo
                    var method = 'POST';
                    if(obj.data('method')){
                        method = obj.data('method');
                    }
                    var table = reloadPage ='';
                    if(obj.data('table')){
                        table = obj.data('table');
                    }
                    if(obj.data('reload')){
                        reloadPage = obj.data('reload');
                    }

                    $.ajax({
                        type: method,
                        data: {
                            '_token' : $('input[name=_token]').val()
                        },
                        url: obj.data('url'),
                        beforeSend: function(e) {
                            $.blockUI({
                                message: '<i class="icon-spinner4 spinner"></i><span class="text-semibold display-block">Carregando...</span>',
                                overlayCSS: {
                                    backgroundColor: '#1b2024',
                                    opacity: 0.8,
                                    cursor: 'wait'
                                },
                                css: {
                                    border: 0,
                                    color: '#fff',
                                    padding: 0,
                                    backgroundColor: 'transparent'
                                }
                            });
                        },
                        success: function(msg){
                            if(reloadPage){
                                window.location.reload();
                            }else{
                                if(msg.type){
                                    $.message(msg.message, msg.type)
                                }
                                if(table){
                                    $('#'+table).bootstrapTable('refresh');
                                }

                                $.unblockUI();
                            }
                        },
                        statusCode: {
                            401 : function(){
                                $.alert({title: 'ERRO 401',body: 'Acesso não autorizado.'}, 'danger');
                            },
                            403 : function(){
                                $.alert({title: 'ERRO 403',body: 'Acesso não autorizado.'}, 'danger');
                            },
                            404 : function(){
                                $.alert("Rota não encontrada", 'danger');
                            },
                            500 : function(){
                                $.alert("Ocorreu um erro ao executar o conteúdo da página requisitada!", 'danger');
                            }
                        }
                    });
                }
            }

            $("#modal_" + options.type).modal("hide");

        });

        $("#modal_"+options.type).modal();
    };

    var _componenteConfirm = function(){

        $.confirm = function(option, colors, seletores){
            //classes para exibição da cor do confirm
            var cores = _color(colors);

            var botao = '<button type="button" id="no_" class="btn btn-link" data-dismiss="modal"> Não </button>'
                        +'<button type="button" id="yes_" class="btn '+cores[0]+'"> Sim </button>';

            var options = $.extend({
                title: 'Confirme',
                body: 'Confirmar a operação?',
                footer: botao,
                size: 'modal-sm',
                classHeader: cores[1],
                yes: function () {},
                no: function () {}
            }, option);

            options.type = 'confirm';

            if (typeof option === "function") {
                options.yes = option;
            } else if (typeof option === 'string') {
                options.body = option;
                if (typeof confirm === 'function') {
                    options.yes = option;
                }
            }

            if (seletores != undefined && seletores.length) {
                $.each(seletores, function () {
                    var seletor = this;
                    $(seletor).click(function () {
                        _baseDialog(options, seletor);
                        return false;
                    });
                });
            } else {
                if(typeof seletores === 'object'){
                    _baseDialog(options, $(seletores));
                }else{
                    _baseDialog(options, this);
                }
                return false;
            }
        }

        $.fn.confirm = function (option, colors){
            if(this.length){
                return $.confirm(option, colors, this);
            }
        }
    };

    var _componenteAlert = function(){

        $.alert = function (option, colors, seletores) {

            var cores = _color(colors);
            var botao = '<button type="button" id="yes_" class="btn '+cores[0]+'"> Ok </button>';

            var options = $.extend({
                title: 'Alerta',
                body: 'Atenção!!!',
                footer: botao,
                size: 'modal-sm',
                classHeader: cores[1],
                yes: function () {}
            }, option);

            options.type = 'alert';

            if (typeof option === "function") {
                options.yes = option;
            } else if (typeof option === 'string') {
                options.body = option;
                if (typeof confirm === 'function') {
                    options.yes = option;
                }
            }

            if (seletores != undefined && seletores.length) {
                $.each(seletores, function () {
                    var seletor = this;
                    $(seletor).click(function () {
                        _baseDialog(options, seletor);
                        return false;
                    });
                });
            } else {
                _baseDialog(options, this);
                return false;
            }

        };

        $.fn.alert = function(option, colors){
            return $.alert(option, colors, this);
        }
    };

    var _componenteAjax = function(){

        $.ajaxBase = function (option) {

            var options = $.extend({
                type: 'POST',
                async: true,
                data: {},
                url: '',
                beforeSend: function (e) {
                    $.blockUI({
                        message: '<i class="icon-spinner4 spinner"></i><span class="text-semibold display-block">Carregando...</span>',
                        overlayCSS: {
                            backgroundColor: '#1b2024',
                            opacity: 0.8,
                            cursor: 'wait'
                        },
                        css: {
                            border: 0,
                            color: '#fff',
                            padding: 0,
                            backgroundColor: 'transparent'
                        }
                    });
                },
                success: function(e){
                    if($('div[id=edit]').length){
                        $('div[id=edit]').html(e);
                        if(option.modal){
                            $('div[id=edit]').show();
                            $('#'+option.modal).modal();
                        }
                    }

                    if(e.type){
                        $.message(e.message, e.type)
                    }

                    if(option.table){
                        $('#'+option.table).bootstrapTable('refresh');
                    }

                    if(option.reloadPage){
                        window.location.reload();
                    }else{
                        $.unblockUI();
                    }
                },
                error: function(e){
                    $.unblockUI();
                    if(e.responseJSON.errors){
                        $('.invalid-feedback').remove();
                        $.each(e.responseJSON.errors, function(i,v){
                            $('div[id=edit]'+' #'+i).addClass('is-invalid');
                            $('div[id=edit]'+' #'+i).after(
                                '<span class="invalid-feedback" role="alert">'
                                    +'<strong>'+v[0]+'</strong>'
                                +'</span>');
                        });
                        $('.invalid-feedback').show();
                    }

                },
                statusCode: {
                    401 : function(){
                        $.unblockUI();
                        $.alert({title: 'ERRO 401',body: 'Acesso não autorizado.'}, 'danger');
                    },
                    403 : function(){
                        $.unblockUI();
                        $.alert({title: 'ERRO 403',body: 'Acesso não autorizado.'}, 'danger');
                    },
                    404 : function(){
                        $.unblockUI();
                        $.alert("Rota não encontrada", 'danger');
                    },
                    500 : function(){
                        $.unblockUI();
                        $.alert("Ocorreu um erro ao executar o conteúdo da página requisitada!", 'danger');
                    }
                }

            }, option);

            $.ajax({
                type: options.type,
                async: options.async,
                data: options.data,
                url: options.url,
                beforeSend: options.beforeSend,
                success: options.success,
                error: options.error,
                statusCode: options.statusCode
            });

        };
    }

    var _componenteMessage = function(){

        $.message = function(message, type){
            //type: success - danger - info - warning
            let divMessage = ''
            + '<div class="alert alert-'+type+' "role="alert">'
            +  ''+message+''
            + '</div>';

            $('div.alert').remove();
            $('#content_area').prepend(divMessage);
            $('div.alert').not('.alert-important').delay(6000).fadeOut(350);
        }
    }

    var _componenteCPFCNPJ = function(){

        $.formataCpfCnpj = function(text){
            let cnpjCpf = text.replace(/\D/g, '');

            if (cnpjCpf.length === 11) {
                return cnpjCpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3-\$4");
            }

            return cnpjCpf.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g, "\$1.\$2.\$3/\$4-\$5");
        }

        $.validaCNPJ = function(cnpj){
            let CNPJ = cnpj;
            if (!CNPJ) {
                return false;
            }
            erro = 0;
            cnpjv = CNPJ;
            if (cnpjv.length == 18 || cnpjv.length == 14) {
                cnpjv = cnpjv.replace('.', '');
                cnpjv = cnpjv.replace('.', '');
                cnpjv = cnpjv.replace('/', '');
                cnpjv = cnpjv.replace('-', '');

                cnpj_invalido = [
                    "00000000000000", "11111111111111", "22222222222222", "33333333333333", "44444444444444",
                    "55555555555555", "66666666666666", "77777777777777", "88888888888888", "99999999999999",
                    "00000000000191"
                ];

                if (cnpj_invalido.indexOf(cnpjv) !== -1) {
                    erro = 1; //"Número de cnpj inválido!"
                }
                var a = [];
                var b = new Number;
                var c = cnpjv.length - 2;
                var pos = c-7;
                //faço um for do total de campos que quero validar
                for (i = 0; i < c; i++) {
                    a[i] = cnpjv.charAt(i);
                    b += (a[i] * pos--);
                    if (pos < 2)
                        pos = 9;
                }
                if ((x = b % 11) < 2) {
                    a[12] = 0;
                } else {
                    a[12] = 11 - x;
                }
                b = 0;
                c = cnpjv.length - 1;
                pos = c-7;
                for (y = 0; y < c; y++){
                    a[y] = cnpjv.charAt(y);
                    b += (a[y] * pos--);
                    if (pos < 2)
                        pos = 9;
                }
                if ((x = b % 11) < 2) {
                    a[13] = 0;
                } else {
                    a[13] = 11 - x;
                }

                if ((cnpjv.charAt(12) != a[12]) || (cnpjv.charAt(13) != a[13])) {
                    erro = 1; //"Número de cnpj inválido.";
                }

            } else {
                if (cnpjv.length == 0) {
                    return false;
                } else {
                    erro = 1; // "Número de cnpj inválido.";
                }
            }
            if (erro) {
                return false;
            }
            return this;
        }

        $.fn.validaCNPJ = function () {
            let cnpj = $(this).val();
            if(!cnpj.length) return false;

            let valida = $.validaCNPJ(cnpj);
            $('.invalid-feedback').remove();
            $(this).removeClass('is-invalid');
            if(!valida){
                $(this).addClass('is-invalid');
                $(this).after(
                    '<span class="invalid-feedback" role="alert">'
                        +'<strong>CNPJ inválido.</strong>'
                    +'</span>');
                $('.invalid-feedback').show();
                return false;
            }else{
                return valida;
            }
        }
    }

    return {
        init: function(){
            _componenteConfirm();
            _componenteAlert();
            _componenteAjax();
            _componenteMessage();
            _componenteCPFCNPJ();
        }
    }
}();


//Iniciando modulo
document.addEventListener('DOMContentLoaded', function() {
    pluginBase.init();
});
