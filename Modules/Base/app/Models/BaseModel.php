<?php

namespace Modules\Base\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class BaseModel extends Model
{
    use HasFactory;

    /**
     * Desativa a criação de datas padrão laravel
     *
     * @var boolean
     */
    public $timestamps = true;

    /**
     * Contem os campos que podem ser acessados para realizar o cadastro
     *
     * @var array
     */
    protected $fillable = [];

        /**
        * Contem os campos que podem ser utilizados para realizar o search do grid
        * Utilizado para o search do grid do bootstrap-table
        *
        * @var array
        */
    protected $searchable = [];

    /**
      * Retorna o nome dos atributos definido na entidade
      * pelo metodo atribbutesLabel
      *
      * @param [string|int] $key
      * @return void
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
    public function search(Request $request)
    {
        $limit  = $request->input('limit', 25);
        $offset = $request->input('offset', 0);
        $search = $request->input('search');

        $sort  = $this->getKeyName();
        $order = $request->input('order', 'asc');

        $query = $this->newQuery();
        
        $this->searchSelect($query);
        $this->searchJoin($query);
        $this->searchWhere($query, $search);

        $total = $query->count();

        $this->searchOrderby($query, $sort, $order);

        $rows = $query
            ->offset($offset)
            ->limit($limit)
            ->get();

        return ['total' => $total, 'rows' => $rows];
    }

    /**
     * Utilizado para alterar o select utilizado na grid bootstrap table
     *
     * @param object $data
     * @return void
     */
    protected function searchSelect($query)
    {
    }

    /**
     * Utilizado para alterar o join utilizado na grid bootstrap table
     *
     * @param object $query
     * @return void
     */
    protected function searchJoin($query)
    {
    }

    /**
     * Utilizado para definir as restrições where
     *
     * @param object $query utilizado para a query da grid
     * @return void
     */
    protected function searchWhere($query, $search = null)
    {
        if (!$search || empty($this->searchable)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            foreach ($this->searchable as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
            }
        });
    }

    /**
     * utilizado para ordenar os registros
     *
     * @param object $query
     * @return void
     */
    protected function searchOrderby($query, $sort, $order)
    {
        return $query->orderBy($sort, $order);
    }

    /**
     * Função para retornar o id do gestor que está na sessão
     *
     * @return void
     */
    protected function getGestorId()
    {
        return session()->get('gestor_id');
    }

    /**
     * Metodo para retornar os dados da entidade a ser procurada
     *
     * Sobreescrever esse metodo no model para tratar dados apenas do gestor atual
     * @param [type] $id
     * @return void
     */
    public function findData($id)
    {
        return $this->findOrFail($id);
    }
}
