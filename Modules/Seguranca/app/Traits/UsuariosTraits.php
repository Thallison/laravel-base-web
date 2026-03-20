<?php

namespace Modules\Seguranca\Traits;


use Modules\Seguranca\Models\Papeis;
use Modules\Seguranca\Models\Usuarios as UsuarioModel;

/**
 * Traits com metodos padrões para tratar dados usuários
 */
trait UsuariosTraits
{

    /**Valida os papeis existem e retona papeis e os sistemas desse papeis */
    public function verificaPapeisSistema(array $dados)
    {
        if(!isset($dados['papeis']) && empty($dados['papeis'])){
            return false;
        }

        $papeis = [];
        $sistemas = [];
        foreach($dados['papeis'] as $papel){
            $p = Papeis::find($papel);
            if($p){
                $papeis[] = $p->papel_id;
                $sistemas[] = $p->getSistemasPapeis();//papel é obrigado a ter sistemas
            }
        }

        if(!$papeis){
            return false;
        }

        return [$papeis, $this->organizaSistema($sistemas)];
    }

    /**Organiza os ids dos sistemas para que retorne um array unico */
    private function organizaSistema(array $sistemas)
    {
        $arrSistema = [];
        foreach($sistemas as $sistema){
            foreach ($sistema as $sis){
                if(!in_array($sis, $arrSistema)){
                    $arrSistema[] = $sis;
                }
            }
        }

        return $arrSistema;
    }

    public function validaSenha($senha, $senhaConfimar){
        if(empty($senha)){
            return false;
        }

        return $senha == $senhaConfimar ? false : true;
    }


    /**
     * Realiza o cadastro do usuário do gestor
     *
     * @param array $dados
     * @param Usuarios $entity
     * @return void
     */
    public function cadastraUsuario(array $dados, UsuarioModel $entity)
    {
        $usuario = $entity->create($dados);
        $usuario->papeisUsuario()->sync($dados['papeis']);
        $usuario->sistemasUsuario()->sync($dados['sistemas']);
        return $usuario;
    }


}
