<?php

namespace App\Http\Controllers\App\ConfirmaExcluirTarefa;

use \App\Http\Controllers\Framework\Base;
use \App\Models\Packages\Sistema\Handler\{HandlerCss, HandlerJs};

class Get extends Base
{
    public function configure(): self {
        // INSTÂNCIA DOS ARQUIVOS DE ESTILO
        $obHandlerCSS = new HandlerCss;
        $obHandlerJS  = new HandlerJs;
    
        // DEFINE O NOME DO ARQUIVO DE HANDLER
        $obHandlerCSS->defineHandlerFileName('handler-senha-alterada');
        $obHandlerJS->defineHandlerFileName('handler-senha-alterada');
    
        // CONFIGURAÇÃO DOS ARQUIVOS
        $obHandlerCSS->setFilesAndFolders([
          'geral', 'botstrap', 'confirma_excluir_tarefa'
        ]);
        $obHandlerJS->setFilesAndFolders([
          'geral', 'botstrap'
        ]);
    
        // DEFINIÇÃO DOS OBJETOS
        $this->handlerCSS = $obHandlerCSS;
        $this->handlerJS  = $obHandlerJS;
    
        return $this;
    }

    public function consultarPagina() {
        $this->configure();
    
        // MONTA OS ARQUIVO DE HANDLER
        $this->atualizarHandlers();
    
        return $this->getConteudo('confirma-excluir-tarefa');
      }

}