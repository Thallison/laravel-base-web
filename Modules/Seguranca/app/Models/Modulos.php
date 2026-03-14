<?php

namespace Modules\Seguranca\Models;

use Modules\Base\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class Modulos extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seg_modulos';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'mod_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'mod_nome',
        'mod_icone'
    ];

    protected $fillable = [
        'mod_nome', 'mod_icone','sis_id'
    ];

    public function rules()
    {
        return [
            'mod_nome' => "required|max:45|unique:seg_modulos,mod_nome,{$this->mod_id},mod_id",
            'mod_icone' => 'max:45',
            'sis_id' => 'required'
        ];
    }

    public function atribbutesLabel()
    {
        return [
            'mod_nome' => __('Nome do modulo'),
            'mod_icone' => __('Nome do icone'),
            'sis_nome' => __('Nome do sistema')
        ];
    }

    /**Relação do modulo pertence a um sistema 1:N */
    public function sistema()
    {
        return $this->belongsTo(\Modules\Seguranca\Models\Sistemas::class, 'sis_id');
    }

    /** Relação de que um modulo possui varios funcionalidades 1:N */
    public function funcionalidades()
    {
        //return $this->hasMany(\Modules\Seguranca\Entities\Funcionalidades::class, 'mod_id');
    }

    /** Utilizado para busca personalizada dos campos bootstrap-table */
    protected function searchSelect($query, $search = null)
    {
        $query->select([
            'mod_id',
            'mod_nome',
            'mod_icone',
            'sis_nome'
        ]);
    }

    /**Utilizado para o search da tela com bootstrap table */
    protected function searchJoin($data)
    {
        $data->join('seg_sistemas', 'seg_sistemas.sis_id','=','seg_modulos.sis_id');
    }

    /**Busca os modulos do usuario*/
    public static function getModulosSistemaUser($sisId, $usrId)
    {
        return DB::table('seg_usuarios_papeis')
                    ->select('seg_modulos.mod_id', 'seg_modulos.mod_nome', 'seg_modulos.mod_icone')
                    ->join('seg_papeis', 'seg_papeis.papel_id', '=', 'seg_usuarios_papeis.papel_id')
                    ->join('seg_privilegios_papeis', 'seg_privilegios_papeis.papel_id', '=', 'seg_papeis.papel_id')
                    ->join('seg_privilegios', 'seg_privilegios.priv_id', '=', 'seg_privilegios_papeis.priv_id')
                    ->join('seg_funcionalidades', 'seg_funcionalidades.func_id', '=', 'seg_privilegios.func_id')
                    ->join('seg_modulos', 'seg_modulos.mod_id', '=', 'seg_funcionalidades.mod_id')
                    ->where('seg_modulos.sis_id', '=', $sisId)
                    ->Where('seg_usuarios_papeis.usr_id', '=', $usrId)
                    ->groupBy('seg_modulos.mod_id')
                    ->orderBy('seg_modulos.mod_nome', 'ASC')
                    ->get();
    }

    /**
     * Retorna os modulos disponiveis para o cliente gestor de acordo com seu plano ou se não
     * for validar cliente gestor retorna todos
     *
     * @param boolean $checkGestor
     * @return void
     */
    public function getModulosSistema($sisId, $checkGestor = false)
    {
        if($checkGestor){
            return Modulos::select('seg_modulos.mod_id', 'seg_modulos.mod_nome', 'seg_modulos.mod_icone')
            ->join('seg_funcionalidades', 'seg_funcionalidades.mod_id', '=', 'seg_modulos.mod_id')
            ->join('seg_privilegios', 'seg_privilegios.func_id', '=', 'seg_funcionalidades.func_id')
            ->join('seg_privilegios_papeis', 'seg_privilegios_papeis.priv_id', '=', 'seg_privilegios.priv_id')
            ->join('seg_papeis', 'seg_papeis.papel_id', '=', 'seg_privilegios_papeis.papel_id')
            ->join('gestor_planos', 'gestor_planos.papel_id', '=', 'seg_papeis.papel_id')
            ->where('gestor_planos.gestor_id', '=', $this->getGestorId())
            ->where('seg_modulos.sis_id', '=', $sisId)
            ->distinct()
            ->orderBy('mod_nome','ASC')
            ->get();
        }else{
            return $this->where('sis_id', $sisId)->orderBy('mod_nome','ASC')->get();
        }
    }
}
