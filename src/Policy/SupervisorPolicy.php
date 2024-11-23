<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Supervisor;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

class SupervisorPolicy implements BeforePolicyInterface
{
  
  public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
  {
    if ($identity) {
      $data = $identity->getOriginalData();
      if ($data and $data->categoria_id == 1) {
        return true;
      }
    }
    return null;
  }
  
  public function canAdd()
  {
      return new Result(true);
  }
  
  public function canView()
  {
    return new Result(true);
  }
  
  public function canEdit(IdentityInterface $userSession, Supervisor $userData)
  {
    if (!$userSession) return new Result(false, 'Erro: Preciso estar logado para editar');
    if ($this->sameUser($userSession, $supervisorData)) {
      return new Result(true);
    } else {
      return new Result(false, 'Erro: supervisor edit policy not authorized');
    }
  }
  
  public function canDelete(IdentityInterface $userSession, Supervisor $supervisorData)
  {
    return new Result(false, 'Erro: supervisor delete policy not allowed');
  }

  
  protected function sameUser(IdentityInterface $userSession, Supervisor $supervisorData)
  {
    return ($userSession->id == $supervisorData->user_id);
  }
  
}