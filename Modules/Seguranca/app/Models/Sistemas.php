<?php

namespace Modules\Seguranca\Models;

use Modules\Base\Models\BaseModel;

class Sistemas extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seg_sistemas';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'sis_id';

    /**
     * Contem os campos que podem ser utilizados para realizar o search do grid
     * Utilizado para o search do grid do bootstrap-table
     *
     * @var array
     */
    protected $searchable = [
        'sis_nome',
        'sis_icone'
    ];

    protected $fillable = [
        'sis_nome', 'sis_icone'
    ];

    public function rules()
    {
        return [
            'sis_nome' => "required|max:45|unique:seg_sistemas,sis_nome,{$this->sis_id},sis_id",
            'sis_icone' => 'max:45',
        ];
    }

    public function atribbutesLabel()
    {
        return [
            'sis_nome' => __('Nome do sistema'),
            'sis_icone' => __('Nome do icone')
        ];
    }

    /** Relação de que um sistema possui varios modulos 1:N */
    public function modulos()
    {
        //return $this->hasMany(\Modules\Seguranca\Entities\Modulos::class, 'sis_id');
    }

    /** Relação de muitos pra muitos entre sistemas e usuarios */
    public function usuariosSistemas()
    {
        return $this->belongsToMany(\Modules\Seguranca\Models\Usuarios::class,'seg_sistemas_usuarios', 'sis_id', 'usr_id');
    }

    /**
     * Retorna os sistemas disponiveis de acordo com os papeis (planos) que estão liberados do cliente gestor
     *
     * @param boolean $checkGestor
     * @return object
     */
    public function getSistemas($checkGestor = false)
    {
        if($checkGestor){
            return Sistemas::select('seg_sistemas.sis_id', 'seg_sistemas.sis_nome', 'seg_sistemas.sis_icone')
            ->join('seg_modulos', 'seg_modulos.sis_id', '=', 'seg_sistemas.sis_id')
            ->join('seg_funcionalidades', 'seg_funcionalidades.mod_id', '=', 'seg_modulos.mod_id')
            ->join('seg_privilegios', 'seg_privilegios.func_id', '=', 'seg_funcionalidades.func_id')
            ->join('seg_privilegios_papeis', 'seg_privilegios_papeis.priv_id', '=', 'seg_privilegios.priv_id')
            ->join('seg_papeis', 'seg_papeis.papel_id', '=', 'seg_privilegios_papeis.papel_id')
            ->join('gestor_planos', 'gestor_planos.papel_id', '=', 'seg_papeis.papel_id')
            ->where('gestor_planos.gestor_id', '=', $this->getGestorId())
            ->distinct()
            ->orderBy('sis_nome','ASC')
            ->get();
        }else{
            return $this->orderBy('sis_nome','ASC')->get();
        }
    }
}
