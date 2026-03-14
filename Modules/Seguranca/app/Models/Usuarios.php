<?php

namespace Modules\Seguranca\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Usuarios extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seg_usuarios';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'usr_id';


    protected $fillable = [
        'usr_login', 'email', 'usr_nome', 'usr_status', 'password',
        'usr_dt_ultimo_acesso', 'usr_dt_alteracao'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        //'birthday'  => 'date:Y-m-d',
        'usr_dt_ultimo_acesso' => 'datetime:d/m/Y H:i:s',
        'usr_dt_alteracao' => 'datetime:d/m/Y H:i:s',
        'usr_dt_criacao' => 'datetime:d/m/Y H:i:s',
    ];

    public function rules()
    {
        return [
            'usr_login' => "required|max:50|unique:seg_usuarios,usr_login,{$this->usr_id},usr_id",
            'password' => 'max:255',
            'senha' => 'max:255',
            'usr_nome' => 'required|max:100',
            'email' => "required|email|max:255|unique:seg_usuarios,email,{$this->usr_id},usr_id",
            'usr_status' => 'required'
        ];
    }

    public function atribbutesLabel()
    {
        return [
            'usr_id' => __('#'),
            'usr_login' => __('Login'),
            'password' => __('Senha'),
            'usr_nome' => __('Nome'),
            'email' => __('E-mail'),
            'usr_status' => __('Status'),
            'usr_dt_criacao' => __('Data criação'),
            'usr_dt_alteracao' => __('Data alteração'),
            'usr_dt_ultimo_acesso' => __('Data ultimo acesso'),
        ];
    }

    /**
     * Retorna o nome dos atributos definido na entidade
     * pelo metodo atribbutesLabel
     */
    public function getAttributeLabel($key)
    {
        if(method_exists($this, 'atribbutesLabel')){
            return $this->atribbutesLabel()[$key];
        }
    }

    /**
     * search
     * Utilizado para implementar o serach do grid do bootstrap-table
     *
     * @return array
     */
    public function search()
    {
        $query = $this->query();
        $this->searchSelect($query);
        $this->searchJoin($query);
        $this->searchWhere($query);

        $total = $query->count();

        return ['total' => $total, 'rows' => $query->get()];

    }
}