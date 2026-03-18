<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('perfil','Plano acesso: <span class="text-danger">*</span>', [], false) }}

            {{ Form::select('perfil', $papeis, null, [
                'class' => 'form-control',
                'required' => true ])
            }}
            @error('func_tipo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <a class="btn btn-xs bg-teal btn-float" id="adicionar_perfil" href="#"><i class="icon-plus2"></i> {{ __('Adicionar Planos') }}</a>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table class="table" id="div_perfil">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center">Planos</th>
                    </tr>
                    <tr>
                        <th>Plano</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($planos))
                        @foreach ($planos as $plano)
                            <tr>
                                <td>{{ $plano->papel_nome }}</td>
                                <td>
                                    <input type="hidden" name="papeis[]" value="{{ $plano->papel_id }}" />
                                    <a class="list-icons-item text-danger-600" id="excluirPapel" data-perfil="papel_{{ $plano->papel_id }}" href="#"  title="Excluir"><i class="icon-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('script')
<script>
    $( function(){

        var arr_perfil = [];

        // Adiciona os planos carregados no array de controle
        $('input[name^=papeis]').each( function(){
            let perfil_val;

            perfil_val = 'papel_'+this.value;
            if(arr_perfil.indexOf(perfil_val) == '-1'){
                arr_perfil.push(perfil_val);
            }
        });

        /*$('#perfil').select2({
            minimumResultsForSearch: Infinity,
        });*/

        $(document).on('click', 'a[id^=adicionar_perfil]', function(){
            let perfil_val;

            perfil_val = 'papel_'+$('#perfil :selected').val();
            if(arr_perfil.indexOf(perfil_val) != '-1'){
                $.alert('Este plano já está inserido.', 'warning');
                return;
            }

            arr_perfil.push(perfil_val);

            let perfil_text = $('#perfil :selected').text();
            let inputHidden = '<input type="hidden" name="papeis[]" value="'+$('#perfil :selected').val()+'" />';
            let input_del = '<a class="list-icons-item text-danger-600" id="excluirPapel" data-perfil="'+perfil_val+'" href="#"  title="Excluir"><i class="icon-trash"></i></a>';
            let tr = '<tr>'
                        +'<td>'+perfil_text+'</td>'
                        +'<td>'+inputHidden+input_del+'</td>'
                    +'</tr>';
            $('#div_perfil tbody').append(tr);

        });

        $(document).on('click','a[id^=excluirPapel]', function(){
            let indice;
            indice = arr_perfil.indexOf($(this).data('perfil'));

            if(indice == '-1'){
                $.alert('Ocorreu erro ao remover o plano', 'danger');
                return;
            }

            arr_perfil.splice(indice, 1);

            $(this).parent().parent().remove();
        });

    });

</script>
@append
