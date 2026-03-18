<?php

namespace Modules\Seguranca\Models;

use Illuminate\Support\Facades\DB;
use Modules\Base\Models\BaseModel;

class Funcionalidades extends BaseModel 
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seg_funcionalidades';

     /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'func_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'func_controller',
        'func_label'
    ];

    protected $fillable = [
        'mod_id','func_id_pai','func_controller',
        'func_label', 'func_tipo', 'func_acesso_menu',
        'func_icon', 'func_rota_padrao'
    ];

    /**
     * Define as roles da entidade
     *
     * @return array
     */
    public function rules()
    {
        return [
            'func_controller' => "required|max:100",
            'func_label' => 'required|max:45',
            'func_acesso_menu' => 'required',
            'func_tipo' => 'required',
            'func_icon' => 'max:45',
            'mod_id' => 'required',
            'func_rota_padrao' => 'max:100'
        ];
    }

    /**
     * Define o nome dos atributos label para utilizar nos formularios
     *
     * @return array
     */
    public function atribbutesLabel()
    {
        return [
            'func_controller' => __('Controller'),
            'func_label' => __('Nome'),
            'func_acesso_menu' => __('Visível no menu'),
            'func_tipo' => __('Tipo'),
            'func_icon' => __('Ícone'),
            'func_id_pai' => __('Funcionalidade Pai'),
            'mod_id' => __('Módulo'),
            'func_rota_padrao' => __('Rota padrão')
        ];
    }

    /**
     * Relação do modulo pertence a um sistema 1:N
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modulo()
    {
        return $this->belongsTo(\Modules\Seguranca\Models\Modulos::class, 'mod_id');
    }

    /**
     * Relação de que um funcionalidade possui varios privilegios 1:N
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function privilegios()
    {
        return $this->hasMany(\Modules\Seguranca\Models\Privilegios::class, 'func_id');
    }

    /** Utilizado para busca personalizada dos campos bootstrap-table */
    protected function searchSelect($query, $search = null)
    {
        $query->select([
            'seg_funcionalidades.func_id',
            'seg_modulos.mod_nome',
            'seg_funcionalidades.func_id_pai',
            'seg_funcionalidades.func_controller',
            'seg_funcionalidades.func_label',
            'seg_funcionalidades.func_tipo',
            'seg_funcionalidades.func_acesso_menu',
            'seg_funcionalidades.func_icon',
            'func_pai.func_label AS func_pai_label',
            'seg_funcionalidades.func_rota_padrao'
        ]);
    }

    /**Utilizado para o search da tela com bootstrap table */
    protected function searchJoin($data)
    {
        $data->join('seg_modulos', 'seg_modulos.mod_id','=','seg_funcionalidades.mod_id');
        $data->leftJoin('seg_funcionalidades AS func_pai', 'func_pai.func_id','=','seg_funcionalidades.func_id_pai');
    }

    /**
     * Monta um array contendo todos os sistemas, módulos, privilégios e sub-privilégios
     * com um nível de até 4 funcionalidades filhas. Usado principalmente para criar
     * os tabs-navs para adicionar os papeis */
    public function preencheFuncionalidades($checkGestor = false)
    {
        $modelFuncionalidades = new Funcionalidades();
        $modelPrivilegio = new Privilegios();
        $modelSistemas = new Sistemas();
        $modelModulo = new Modulos();

        $listaSistema = $modelSistemas->getSistemas($checkGestor);

        $modulosSistema = array();
        $funcionalidadePais = array();
        $funcionalidadeFilhasN1 = array();
        $funcionalidadeFilhasN2 = array();
        $funcionalidadeFilhasN3 = array();
        $funcionalidadeFilhasN4 = array();

        foreach ($listaSistema as $sistema) {
            $modulosSistema['func'][$sistema->sis_id] = $modelModulo->getModulosSistema($sistema->sis_id, $checkGestor);
            
            foreach ($modulosSistema['func'][$sistema->sis_id] ?? [] as $modulo) {
                $funcionalidadePais['func'][$modulo->mod_id] = $modelFuncionalidades->getFuncionalidades($modulo->mod_id, NULL, $checkGestor);
                if ($funcionalidadePais['func'][$modulo->mod_id]) {
                    foreach ($funcionalidadePais['func'][$modulo->mod_id] ?? [] as $func1) {
                        $funcionalidadeFilhasN1['func'][$func1->func_id] = $modelFuncionalidades->getFuncionalidades($modulo->mod_id, $func1->func_id, $checkGestor);
                        $funcionalidadeFilhasN1['priv'][$func1->func_id] = $modelPrivilegio->getPrivilegios($func1->func_id, $checkGestor);

                        if($funcionalidadeFilhasN1['func'][$func1->func_id]?->count()){
                            foreach ($funcionalidadeFilhasN1['func'][$func1->func_id] ?? [] as $func2 ){
                                $funcionalidadeFilhasN2['func'][$func2->func_id] = $modelFuncionalidades->getFuncionalidades($modulo->mod_id, $func2->func_id, $checkGestor);
                                $funcionalidadeFilhasN2['priv'][$func2->func_id] = $modelPrivilegio->getPrivilegios($func2->func_id, $checkGestor);

                                if($funcionalidadeFilhasN2['func'][$func2->func_id]?->count()){
                                    foreach ( $funcionalidadeFilhasN2['func'][$func2->func_id] ?? [] as $func3 ){
                                        $funcionalidadeFilhasN3['func'][$func3->func_id] = $modelFuncionalidades->getFuncionalidades($modulo->mod_id, $func3->func_id, $checkGestor);
                                        $funcionalidadeFilhasN3['priv'][$func3->func_id] = $modelPrivilegio->getPrivilegios($func3->func_id, $checkGestor);

                                        if($funcionalidadeFilhasN3['func'][$func3->func_id]?->count()){
                                            foreach ( $funcionalidadeFilhasN3['func'][$func3->func_id] ?? [] as $func4 ){
                                                $funcionalidadeFilhasN4['func'][$func4->func_id] = $modelFuncionalidades->getFuncionalidades($modulo->mod_id, $func3->func4, $checkGestor);
                                                $funcionalidadeFilhasN4['priv'][$func4->func_id] = $modelPrivilegio->getPrivilegios($func4->func_id, $checkGestor);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return array(
            'listaSistemas'=>$listaSistema,
            'modulosSistema'=>$modulosSistema,
            'funcPaiModulos'=>$funcionalidadePais,
            'funcFilhasN1' => $funcionalidadeFilhasN1,
            'funcFilhasN2' => $funcionalidadeFilhasN2,
            'funcFilhasN3' => $funcionalidadeFilhasN3,
            'funcFilhasN4' => $funcionalidadeFilhasN4
        );
    }

    /**
     * Lista todas as funcionalidade pai do modulo passado por parametro de um usuario
     * @param integer $modulo
     * @return object
     */
    public static function getFuncPai($usrId, $modulo){

        return DB::table('seg_usuarios_papeis')
                    ->select('seg_funcionalidades.func_id', 'seg_funcionalidades.func_label',
                            'seg_funcionalidades.func_icon', 'seg_funcionalidades.func_rota_padrao' )
                    ->join('seg_papeis', 'seg_papeis.papel_id', '=', 'seg_usuarios_papeis.papel_id')
                    ->join('seg_privilegios_papeis', 'seg_privilegios_papeis.papel_id', '=', 'seg_papeis.papel_id')
                    ->join('seg_privilegios', 'seg_privilegios.priv_id', '=', 'seg_privilegios_papeis.priv_id')
                    ->join('seg_funcionalidades', 'seg_funcionalidades.func_id', '=', 'seg_privilegios.func_id')
                    ->Where('seg_usuarios_papeis.usr_id', '=', $usrId)
                    ->Where('seg_funcionalidades.mod_id', '=', $modulo)
                    ->where('seg_funcionalidades.func_acesso_menu', '=', 1)
                    ->whereNull('seg_funcionalidades.func_id_pai')
                    ->groupBy('seg_funcionalidades.func_id')
                    ->orderBy('seg_funcionalidades.func_label', 'ASC')
                    ->get();
    }

    /**
     * Retorna todas as funcionalidades filhas da funcionalidade pai
     * @param integer $funcPai
     * @return object \Illuminate\Database\Query\Builder
     */
    public static function getFuncFilhas($usrId, $funcPai){

        return DB::table('seg_usuarios_papeis')
                    ->select('seg_funcionalidades.func_id', 'seg_funcionalidades.func_label',
                                'seg_funcionalidades.func_icon', 'seg_funcionalidades.func_rota_padrao')
                    ->join('seg_papeis', 'seg_papeis.papel_id', '=', 'seg_usuarios_papeis.papel_id')
                    ->join('seg_privilegios_papeis', 'seg_privilegios_papeis.papel_id', '=', 'seg_papeis.papel_id')
                    ->join('seg_privilegios', 'seg_privilegios.priv_id', '=', 'seg_privilegios_papeis.priv_id')
                    ->join('seg_funcionalidades', 'seg_funcionalidades.func_id', '=', 'seg_privilegios.func_id')
                    ->Where('seg_usuarios_papeis.usr_id', '=', $usrId)
                    ->Where('seg_funcionalidades.func_id_pai', '=', $funcPai)
                    ->where('seg_funcionalidades.func_acesso_menu', '=', 1)
                    ->groupBy('seg_funcionalidades.func_id')
                    ->orderBy('seg_funcionalidades.func_label', 'ASC')
                    ->get();
    }


    /**
     * Retorna as funcionalidades de acordo com o plano que o cliente gestor tem disponivel
     * ou se não for pra verificar cliente gestor retorna todas
     *
     * @param [type] $modId
     * @param [type] $funcPaiId
     * @param boolean $checkGestor
     * @return void
     */
    public function getFuncionalidades($modId, $funcPaiId = NULL, $checkGestor = false)
    {
        if($checkGestor){
            return Funcionalidades::select('seg_funcionalidades.*')
            ->join('seg_privilegios', 'seg_privilegios.func_id', '=', 'seg_funcionalidades.func_id')
            ->join('seg_privilegios_papeis', 'seg_privilegios_papeis.priv_id', '=', 'seg_privilegios.priv_id')
            ->join('seg_papeis', 'seg_papeis.papel_id', '=', 'seg_privilegios_papeis.papel_id')
            ->join('gestor_planos', 'gestor_planos.papel_id', '=', 'seg_papeis.papel_id')
            ->where('gestor_planos.gestor_id', '=', $this->getGestorId())
            ->where('seg_funcionalidades.mod_id', '=', $modId)
            ->where('seg_funcionalidades.func_id_pai', '=', $funcPaiId)
            ->distinct()
            ->orderBy('func_label','ASC')
            ->get();
        }else{
            return $this->where(['mod_id' => $modId,'func_id_pai' => $funcPaiId])->orderBy('func_label','ASC')->get();
        }
    }
}
