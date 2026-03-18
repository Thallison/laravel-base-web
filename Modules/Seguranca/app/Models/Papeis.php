<?php

namespace Modules\Seguranca\Models;

use Illuminate\Support\Facades\DB;
use Modules\Base\Models\BaseModel;

class Papeis extends BaseModel 
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seg_papeis';

     /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'papel_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'papel_nome'
    ];

    
    protected $casts = [
        //'birthday'  => 'date:Y-m-d',
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    protected $fillable = [
        'papel_nome',  'created_at', 'updated_at'
    ];

    /**
     * Define as roles da entidade
     *
     * @return array
     */
    public function rules()
    {
        return [
            'papel_nome' => "required|max:45"
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
            'papel_id' => __('#'),
            'papel_nome' => __('Nome Grupo'),
            'papel_dt_criacao' => __('Data criação'),
            'papel_dt_alteracao' => __('Data Alteração'),
        ];
    }

    /** Relação de muitos pra muitos entre papel e privilegio */
    public function privilegios()
    {
        return $this->belongsToMany(\Modules\Seguranca\Models\Privilegios::class,'seg_privilegios_papeis', 'papel_id', 'priv_id')->withTimestamps();
    }

    /**Retorna os ids de todos os siatemas que o papel tenha alguma funcionalidade vinculada */
    public function getSistemasPapeis()
    {
        if(!$this->papel_id){
            return false;
        }

        return DB::table('seg_sistemas')
                    ->select('seg_sistemas.sis_id')
                    ->join('seg_modulos', 'seg_modulos.sis_id', '=', 'seg_sistemas.sis_id')
                    ->join('seg_funcionalidades', 'seg_funcionalidades.mod_id', '=', 'seg_modulos.mod_id')
                    ->join('seg_privilegios', 'seg_privilegios.func_id', '=', 'seg_funcionalidades.func_id')
                    ->join('seg_privilegios_papeis', 'seg_privilegios_papeis.priv_id', '=', 'seg_privilegios.priv_id')
                    ->Where('seg_privilegios_papeis.papel_id', '=', $this->papel_id)
                    ->distinct()
                    ->get()
                    ->pluck('sis_id');
    }

    /** Relação de muitos pra muitos entre papel e privilegio */
    public function usuarios()
    {
        return $this->belongsToMany(\Modules\Seguranca\Models\Usuarios::class,'seg_usuarios_papeis', 'papel_id', 'usr_id');
    }

    /**
     * Vincula os privilegios do papel e atualiza os sistemas do usuario
     *
     * @param array $privilegios
     * @return void
     */
    public function vinculaPrivilegios(array $privilegios)
    {
        if(!$this){
            return false;
        }

        $this->privilegios()->sync($privilegios);

        if($this->usuarios()->get()->count()){
            //Atualiza os sistemas do usuario de acordo com o papel
            foreach ($this->usuarios()->get() as $usr ){
                $usr->atualizaSistemasUsuario();
            }
        }
    }

    /**Verifica se algum privilegio possui funcionalidade pai
     * e adiciona automaticamente o privilegio do pai
     * ex: Relatorio
     *          -> Relatorio vendas
     * se tiver privilegio para relatorio de vendas, irá adicionar
     * automaticamente o privilegio do 'relatorio'
     */
    public function verificaPrivFuncPai(array $privilegios)
    {
        $modelPriv = new Privilegios();
        $privPai = [];
        foreach ($privilegios as $privId) {
            //verifica se existe privilegio com funcionalidade pai
            $funcPai = DB::table('seg_privilegios')
                            ->select('seg_funcionalidades.func_id_pai')
                            ->join('seg_funcionalidades', 'seg_funcionalidades.func_id', '=', 'seg_privilegios.func_id')
                            ->where('priv_id', '=', $privId )
                            ->whereNull('seg_funcionalidades.func_id_pai', 'and', true)
                            ->get()->first();

            if($funcPai){
                //busca o privilegio da funcionalidade pai
                $funcPrivPai = DB::table('seg_privilegios')
                            ->select('seg_privilegios.priv_id')
                            ->where('seg_privilegios.func_id', '=', $funcPai->func_id_pai )
                            ->get()->first();

                if($funcPrivPai){
                    $privPai[] = $funcPrivPai->priv_id;
                }
            }
        }

        $privilegios = array_merge($privPai, $privilegios);
        return $privilegios;
    }

    /**
     * Retorna o papel de acordo com o gestor logado
     *
     * @param [type] $papelId
     * @return void
     */
    public function findData($papelId)
    {
        return Papeis::select('seg_papeis.*')
        ->where('seg_papeis.papel_id','=',$papelId)
        ->firstOrFail();
    }


    protected function searchSelect($query, $search = null)
    {
        
    }

    protected function searchJoin($query)
    {
    }

    protected function searchWhere($query, $search = null)
    {        
    }
}
