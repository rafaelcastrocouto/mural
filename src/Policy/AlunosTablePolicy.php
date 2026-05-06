<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AlunosTable;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

class AlunosTablePolicy implements BeforePolicyInterface
{
  
  public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
  {
    if ($identity) {
      $user_data = $identity->getOriginalData();
      if ($user_data and ( $user_data['administrador_id'] || $user_data['professor_id'] || $user_data['supervisor_id'])) {
        return true;
      }
    }
    return null;
  }
  
  public function canIndex(IdentityInterface $userSession, AlunosTable $alunosTable)
  {
    return new Result(false, 'Erro: alunos busca policy not authorized');
  }
  
  public function scopeIndex($user, $query)
  {
    return $query->where(['Alunos.user_id' => $user->getIdentifier()]);
  }

  public function canAdd(IdentityInterface $userSession, AlunosTable $alunosTable)
  {
    $alunocadastrado = $alunosTable->find()->where(['user_id' => $userSession->id]);

    if ($alunocadastrado->count() > 0) {
        return new Result(false, 'Erro: alunos add policy not authorized');
    } else {
      return new Result(true);
    }
    
  }
  public function canView(IdentityInterface $userSession, AlunosTable $alunosTable) {
    if ($this->isRegistred($userSession)) {
      return new Result(true);
    } else {
      return new Result(false, 'Erro: estagiarios termodecompromisso policy not authorized');
    }
  }
  
  public function canBuscar(IdentityInterface $userSession, AlunosTable $alunosTable)
  {
    return new Result(false, 'Erro: alunos busca policy not authorized');
  }
  
  public function canPlanilhacress(IdentityInterface $userSession, AlunosTable $alunosTable)
  {
    return new Result(false, 'Erro: alunos planilha cress policy not authorized');
  }
  
  public function canPlanilhaseguro(IdentityInterface $userSession, AlunosTable $alunosTable)
  {
    return new Result(false, 'Erro: alunos planilha seguro policy not authorized');
  }
  
  public function canCargahoraria(IdentityInterface $userSession, AlunosTable $alunosTable)
  {
    return new Result(false, 'Erro: alunos planilha seguro policy not authorized');
  }

  protected function isRegistred($user)
  {
    return ($user['aluno_id'] OR $user['supervisor_id'] OR $user['professor_id']);
  }

}