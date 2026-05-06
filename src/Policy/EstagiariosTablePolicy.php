<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\EstagiariosTable;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

class EstagiariosTablePolicy implements BeforePolicyInterface
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

  public function canIndex(IdentityInterface $userSession, EstagiariosTable $estagiariosTableData)
  {
    return new Result(false, 'Erro: estagiarios index policy not authorized');
  }

  public function canAdd(IdentityInterface $userSession, EstagiariosTable $estagiariosTableData)
  {
    return new Result(false, 'Erro: estagiarios add policy not authorized');
  }
  
  public function canView(IdentityInterface $userSession, EstagiariosTable $estagiariosTableData)
  {
    if ($this->isRegistred($userSession)) {
      return new Result(true);
    } else {
      return new Result(false, 'Erro: users view policy not authorized');
    }
  }

  public function canEdit(IdentityInterface $userSession, EstagiariosTable $estagiariosTableData)
  {
    return new Result(false, 'Erro: estagiarios edit policy not authorized');
  }
  
  
  public function scopeIndex($user, $query)
  {
    return $query->where(['Estagiarios.aluno_id' => $user->aluno_id ]);
  }
  
  public function canBuscar(IdentityInterface $userSession, EstagiariosTable $estagiariosTableData)
  {
    return new Result(false, 'Erro: estagiarios buscar policy not authorized');
  }
  
  public function canTermodecompromisso(IdentityInterface $userSession, EstagiariosTable $estagiariosTableData)
  {
    if ($this->isRegistred($userSession)) {
      return new Result(true);
    } else {
      return new Result(false, 'Erro: estagiarios termodecompromisso policy not authorized');
    }
  }

  protected function isRegistred($user)
  {
    return ($user['aluno_id'] OR $user['supervisor_id'] OR $user['professor_id']);
  }

}