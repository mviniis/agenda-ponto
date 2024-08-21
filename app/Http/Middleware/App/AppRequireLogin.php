<?php

namespace App\Http\Middleware\App;

use \Closure;
use \App\Models\Packages\App\Usuario\Sessao\UsuarioSessao;

/**
 * class AppRequirelogin
 * 
 * Classe responsável por realizar a validação do login
 * 
 * @author Matheus Vinicius
 */
class AppRequireLogin {
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @param  string|null  ...$guards
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle($request, Closure $next) {
    $rotaAtualAcesso      = $request->route()->getName();
    $rotasSemAutenticacao = [
      'web.ver.login', 'web.ver.cadastro', 'web.ver.recuperacao',
      'web.ver.recuperacaop2', 'web.ver.recuperacaop3'
    ];
    $possuiUsuarioLogado  = (new UsuarioSessao)->usuarioEstaLogado();

    // VERIFICO SE O USUÁRIO NÃO LOGADO ESTÁ TENTANDO ACESSAR UM RECURSO EM QUE ELE DEVE ESTAR LOGADO
    if(!in_array($rotaAtualAcesso, $rotasSemAutenticacao) && !$possuiUsuarioLogado) {
      return redirect('/');
    }

    // VERIFICO SE O USUÁRIO LOGADO ESTÁ TENTANDO ACESSAR UM RECURSO EM QUE ELE NÃO DEVE ESTAR LOGADO
    if(in_array($rotaAtualAcesso, $rotasSemAutenticacao) && $possuiUsuarioLogado) {
      return redirect('/listagem-tarefas');
    }

    return $next($request);
  }
}