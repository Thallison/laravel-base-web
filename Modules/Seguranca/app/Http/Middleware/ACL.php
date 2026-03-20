<?php

namespace Modules\Seguranca\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Seguranca\Models\Papeis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;


class ACL
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        return $this->acl($request, $next);
    }

    /**
     * Validações de ACL do usuario
     *
     * @param Request $request
     * @param Closure $next
     * @return void
     */
    private function acl(Request $request, Closure $next)
    {
        //saber qual o menu está selecionado para deixar ativo
        if($request->has('opmn')){
            session()->put('opmn', $request->input('opmn'));
        }

        $rotaAtualName = $request->route()->getName();
        

        //verifica se a rota do usuário é uma rota sem autenticação
        if($this->rotaLivreAuth($rotaAtualName)){
            return $next($request);
        }else{
            //verifica se já possui auth guard
            if (!app('Illuminate\Contracts\Auth\Guard')->guest()) {

                //verifica se o usuario esta autenticado
                if(Auth::check()){

                    $user = Auth::user();
                    $papeisUsuario = $user->papeisUsuario()->get();

                    $actionRoute = $request->route()->getAction();
                    
                    list($controller, $action) = explode('@', $actionRoute['controller']);

                    if($this->rotaLivre($rotaAtualName)){
                        $msgLog = "IP: {$_SERVER['REMOTE_ADDR']}- usr: $user->usr_id - Rota: $rotaAtualName - Controller: $controller - Action: $action - Acesso: Rota livre de acesso.";
                        Log::channel('acesso')->info($msgLog);
                        return $next($request);
                    }

                    if(!$papeisUsuario->count()){
                        $msgLog = "IP: {$_SERVER['REMOTE_ADDR']}- usr: $user->usr_id - Rota: $rotaAtualName - Controller: $controller - Action: $action - Acesso: Acesso não autorizado. Usuário sem papel cadastrado.";
                        Log::channel('acesso')->warning($msgLog);
                        abort(403, 'Acesso não autorizado. Usuário sem perfil cadastrado.');
                    }

                    $this->setPermissionGate($papeisUsuario);

                    $hasAcess = false;
                    foreach ($papeisUsuario as $papel){
                        if($this->hasAcess($papel, $controller, $action)){
                            $hasAcess = true;
                        }
                    }

                    if($hasAcess){
                        //possui acesso
                        $msgLog = "IP: {$_SERVER['REMOTE_ADDR']}- usr: $user->usr_id - Rota: $rotaAtualName - Controller: $controller - Action: $action - Acesso: Acesso autorizado";
                        Log::channel('acesso')->info($msgLog);
                        return $next($request);
                    }else{
                        $msgLog = "IP: {$_SERVER['REMOTE_ADDR']}- usr: $user->usr_id - Rota: $rotaAtualName - Controller: $controller - Action: $action - Acesso: Acesso não autorizado";
                        Log::channel('acesso')->warning($msgLog);
                        abort(403, 'Acesso não autorizado.');
                    }
                }else{
                    ///Redireciona para o login do sistema. Usuário não logado
                    return redirect('login');
                }
            }else{
                //usuário realizando login
                return $next($request);
            }
        }
    }

     /**
     * Verifica se a rota é uma rota livre de autenticação
     * este valor e setado no arquivo config na pasta config
     * @param string $rota
     * @return boolean retorna TRUE caso a rota e livre de autenticacao ou false
     * caso contrario
     */
    private function rotaLivreAuth($rota)
    {
        if (!empty(config('seguranca.rotas.rotas_sem_autenticacao'))) {
            return in_array($rota, config('seguranca.rotas.rotas_sem_autenticacao'));
        } else {
            return false;
        }
    }

    /**
     * Verifica se a rota é uma rota livre. Usuário precisa estar logado
     * este valor e setado no arquivo config na pasta config
     * @param string $rota
     * @return boolean retorna TRUE caso a rota e livre de autenticacao ou false
     * caso contrario
     */
    private function rotaLivre($rota)
    {
        if (!empty(config('seguranca.rotas.rotas_livres'))) {
            return in_array($rota, config('seguranca.rotas.rotas_livres'));
        } else {
            return false;
        }
    }

    /**
     * Verifica se o papel possui o privilegio da funcionalidade passada
     *
     * @param Papeis $papel
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    private function hasAcess(Papeis $papel, $controller, $action)
    {
        if($this->verificaAcessoPriv($papel, $controller, $action)){
            return true;
        }else if($this->verificaDepPriv($papel, $controller, $action)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Verifica se tem privilegio para a rota acessada
     *
     * @param Papeis $papel
     * @param string $controller
     * @param string $action
     * @return void
     */
    private function verificaAcessoPriv(Papeis $papel, $controller, $action)
    {

        return !! $papel->privilegios()
        ->whereHas(
            'funcionalidade' , function($query) use ($controller){
                $query->where('func_controller', '=', $controller);
            }
        )
        ->with('funcionalidade')
        ->where('priv_action', $action)
        ->get()->count();

    }

    /**
     * Verifica se o algum privilegio do papel possui dependencia cadastrada para rota acessada
     *
     * @param Papeis $papel
     * @param string $controller
     * @param string $action
     * @return void
     */
    private function verificaDepPriv(Papeis $papel, $controller, $action)
    {
        $privilegios = $papel->privilegios()->get();

        if($privilegios->count()){

            foreach ($privilegios as $priv) {
                //verifica se as dependencias existem
                $dep = $priv->dependenciasPrivilegios()
                            ->where([
                                'dep_priv_controller' => $controller,
                                'dep_priv_action' => $action
                                ])
                            ->get()->count();
                if($dep){
                    return true;
                }
            }

            return false;
        }else{
            return false;
        }
    }

    /**
     * Define as permissões de todas as rotas para o usuario
     *
     * @param [type] $user
     * @return void
     */
    private function setPermissionGate($papeis)
    {
        if($papeis->count()){
            foreach ($papeis as $papel){
                if($papel->privilegios()->get()->count()){
                    $privilegios = $papel->privilegios()->get();
                    foreach ($privilegios as $priv){
                        Gate::define($priv->priv_label, function($user){return true;});
                    }
                }
            }
        }
    }
}
