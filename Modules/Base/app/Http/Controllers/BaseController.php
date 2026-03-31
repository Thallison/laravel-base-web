<?php

namespace Modules\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Seguranca\Logging\BaseLog;

class BaseController extends Controller
{
    use ValidatesRequests;

    /**
     * Define o nome do modulo
     *
     * @var string
     */
    protected $modulo;

    /**
     * Define a entidade que está usando com base no nome da controller
     * ou seja a entidade e a controller tem que ter o mesmo nome
     *
     * @var object
     */
    protected $model;

     /**
      * Define a rota para acessar as views
      *
      * @var string
      */
    protected $rota;


    /**
     * Variavel que recebe a request do sistema
     *
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->init(get_called_class());
    }
    
    /**
     * Metodo index padrão para tela
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $model = $this->getModel();

         if($request->ajax()){
            $dados = $model->search($request);
            return response()->json($dados);
        }

        $attributeView = array_merge($this->getAttributesView(), ['model' => $model]);
        return view($this->getRota().".index", $attributeView);
    }

    /**
     * Metodo padrão utilizado para criar as views de criação
     *
     * @return void
     */
    public function create()
    {
        $model = $this->getModel();
        $attributeView = array_merge($this->getAttributesView(), ['model' => $model]);
        return view($this->getRota().".create", $attributeView);
    }

    /**
      * Metodo padrão utilizado para salvar os dados de criação da view create
      *
      * @param Request $request
      * @return void
      */
    public function store(Request $request) 
    {
        $this->validaRoles($request, $this->getModel());

        $dados = $this->processesDataStore($request->all());
        
        $this->getModel()->create($dados);

        BaseLog::info($request, json_encode($dados) );
        
        return redirect()->route($this->getRota().'.index')->with('message', [
            'type' => 'success',
            'text' => 'Cadastro realizado com sucesso'
        ]);

    }

    /**
     * Metodo padrão utilizado para vizualização rapida de conteúdo
     * exemplo um modal
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $model = $this->getModel();

        $dados = $model->findData($id);
        $attributeView = array_merge($this->getAttributesView(), ['dados' =>$dados, 'model' => $model]);

        return view($this->getRota().".show", $attributeView);
    }

    /**
     * Metodo padrão para visualização dos dados na view para edição
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        $model = $this->getModel();
        $dados = $model->findData($id);

        $attributeView = array_merge($this->getAttributesView(), ['dados' =>$dados, 'model' => $model]);

        return view($this->getRota().".edit", $attributeView);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) 
    {
        $retEntity = $this->getModel()->findData($id);
        $dadoAtual = $retEntity->toArray();

        $this->validaRoles($request, $retEntity);

        $dados = $this->processesDataUpdate($request->all());

        $retEntity->update($dados);

        $log = [
            'Atual' => $dadoAtual,
            'Novo' => $dados
        ];

        BaseLog::info($request, json_encode($log) );

        if($request->input('_dataType') == 'json'){
            return $this->getResponseJson([
                'message' => 'Registro editado com sucesso.',
                'type' => 'success'
            ]);
        }

        return redirect()->route($this->getRota().'.index')
        ->with('message', [
            'type' => 'success',
            'text' => 'Registro editado com sucesso.'
        ]);
    }

    /**
     * Metodo padrão para exclusão de registros
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        try {
            $dados = $this->getModel()->findData($id);

            $dados->delete();

            BaseLog::info($this->request, 'Realizando Exclusão ID: '.$id);

            $mensagem = 'Exclusão realizada com sucesso.';
            $type = 'success';

        } catch (\Exception $th) {
            $mensagem = 'Ocorreu um erro ao excluir o registro. Verifique se o registro não possui vinculos.';
            $type = 'danger';
        }

        return $this->getResponseJson(['message' => $mensagem, 'type' => $type]);
    }

    /**
     * Metodo padrão para retornar dados em JSON
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getResponseJson(array $data = [])
    {
        $default = [
            'message' => '',
            'type' => ''
        ];

        $merge = array_merge($default, $data);

        return response()->json($merge);
    }

    /**
     * Metodo utilizado para validar as roles das entidades[model]
     *
     * @param Request $request
     * @param [entity] $entity
     * @return void
     */
    protected function validaRoles(Request $request, $entity, $rules = [])
    {
        $atribbutesLabel = [];
        if(method_exists($entity, 'atribbutesLabel')){
            $atribbutesLabel = $entity->atribbutesLabel();
        }

        if($rules){
            $this->validate($request, $rules, [], $atribbutesLabel);
        }else{
            if(method_exists($entity, 'rules')){
                $this->validate($request, $entity->rules(), [], $atribbutesLabel);
            }
        }
    }

    /**
     * Setar nome do modulo
     *
     * @param string $modulo
     * @return void
     */
    protected function setModulo($modulo)
    {
        $this->modulo = $modulo;
        return $this;
    }

    /**
     * Buscar modulo
     *
     * @return void
     */
    protected function getModulo()
    {
        return $this->modulo;
    }

    /**
     * Setar a entidade/model a utilizar
     *
     * @param [v] $model
     * @return object
     */
    protected function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Buscar a entidade que estar utilizando
     *
     * @return object
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * Setar a rota utilizada
     *
     * @param string $rota
     * @return void
     */
    protected function setRota($rota)
    {
        $this->rota = $rota;
        return $this;
    }

    /**
     * Busca a rota utilizada
     *
     * @return void
     */
    protected function getRota()
    {
        return $this->rota;
    }

    /**
     * Define o nome do modulo com base na classe que estende dessa classe
     *
     * @param get_called_class $class
     * @return void
     */
    private function init(string $class): void
    {
        $split = explode("\\", (string) $class);
        $model = str_replace("Controller", "", $split[4]);
        $modulo = $split[1];
        $rota = strtolower($modulo.'::'.$model);

        $this->setModulo($modulo);
        $this->setRota($rota);

        $newModel = 'Modules\\'.$this->getModulo().'\\Models\\'.$model;

        if(class_exists($newModel)){
            $newModel = new $newModel;
            $this->setModel($newModel);
        }
    }

    /**
     * getAttributesView
     *
     * Array com os atributos para as view
     * chave do array é o nome do atributo que irá acessar na view
     * ['base'] = 'VALOR'
     * @return array
     */
    protected function getAttributesView()
    {
        return [];
    }

    /**
     * Este metodo tem por finalidade tratar quaisquer informação no objeto antes de salvar
     */
    protected function processesDataStore(array $data = [])
    {
        return $data;
    }

    /**
     * Este metodo tem por finalidade tratar quaisquer informação no objeto antes de editar
     */
    protected function processesDataUpdate(array $data = [])
    {
        return $data;
    }
}
