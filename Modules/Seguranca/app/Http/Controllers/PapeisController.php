<?php

namespace Modules\Seguranca\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\Seguranca\Models\Funcionalidades;
use Modules\Seguranca\Models\Privilegios;
use Illuminate\Support\Facades\DB;

class PapeisController extends BaseController
{
    public function edit($id)
    {
        $model = $this->getModel();
        $dados = $model->findOrFail($id);

        $subPrivIds = $dados->privilegios()
                        ->get(['seg_privilegios_papeis.priv_id'])
                        ->pluck('priv_id')
                        ->toArray();

        $attributeView = array_merge($this->getAttributesView(), [
            'dados' =>$dados,
            'model' => $model,
            'subPrivIds' => $subPrivIds
        ]);

        return view($this->getRota().".edit", $attributeView);
    }

    public function store(Request $request)
    {
        $dados = $request->all();

        if(!$dados['privilegios']){
            return redirect()->back()->withInput($dados)->with('message', [
                'type' => "warning",
                'text' => "Necessário cadastrar pelo menos 1 privilégio."
            ]);
        }

        $this->validaRoles($request, $this->getModel());
        $papel = $this->getModel()->create($dados);

        $papel->vinculaPrivilegios($dados['privilegios']);

        return redirect()->route($this->getRota().'.index')->with('message', [
            'type' => "success",
            'text' => "Cadastro realizado com sucesso."
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $dados = $request->all();

            if(!$dados['privilegios']){
                return redirect()->back()->withInput($dados)->with('message', [
                    'type' => "warning",
                    'text' => "Necessário cadastrar pelo menos 1 privilégio."
                ]);
            }

            $dados['privilegios'] = $this->getModel()->verificaPrivFuncPai($dados['privilegios']);

            $retEntity = $this->getModel()->findOrFail($id);
           

            $this->validaRoles($request, $retEntity);

            DB::beginTransaction();

            $retEntity->update($dados);
            $retEntity->vinculaPrivilegios($dados['privilegios']);

            DB::commit();

            $mensagem = 'Registro editado com sucesso.';
            $type = 'success';
        } catch (\Throwable $th) {
            DB::rollback();
            $mensagem = 'Ocorreu um erro ao editar o registro.';
            $type = 'danger';
        }

        return redirect()->route($this->getRota().'.index')->with('message', [
            'type' => $type,
            'text' => $mensagem
        ]);
    }

    public function destroy($id)
    {
        try {
            $papel = $this->getModel()->findOrFail($id);

            DB::beginTransaction();

            $papel->privilegios()->detach();
            $papel->delete();

            DB::commit();

            $mensagem = 'Exclusão realizada com sucesso.';
            $type = 'success';
        } catch (\Exception $th) {
            DB::rollback();

            $mensagem = 'Ocorreu um erro ao excluir o registro. Verifique se o registro não possui vinculos.';
            $type = 'danger';
        }

        return $this->getResponseJson(['message' => $mensagem, 'type' => $type]);
    }

     /** Set atributos da view */
    protected function getAttributesView()
    {
        $modelFuncionalidade = new Funcionalidades();
        $arrayFunc = $modelFuncionalidade->preencheFuncionalidades();
        return array(
            'privilegios' => (new Privilegios())->get()->count(),
            'sistemas' => $arrayFunc['listaSistemas'],
            'modulosSistema'=>$arrayFunc['modulosSistema'],
            'funcPaiModulos'=>$arrayFunc['funcPaiModulos'],
            'funcFilhasN1' => $arrayFunc['funcFilhasN1'],
            'funcFilhasN2' => $arrayFunc['funcFilhasN2'],
            'funcFilhasN3' => $arrayFunc['funcFilhasN3'],
            'funcFilhasN4' => $arrayFunc['funcFilhasN4']
        );
    }
}
