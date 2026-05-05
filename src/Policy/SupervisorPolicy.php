<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Supervisor;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;
use Cake\ORM\TableRegistry;

class SupervisorPolicy implements BeforePolicyInterface
{
  
  public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
  {
    if ($identity) {
      $user_data = $identity->getOriginalData();
      if ($user_data and $user_data['administrador_id']) {
        return true;
      }
    }
    return null;
  }
  
  public function canIndex()
  {
      return new Result(false, 'Erro: supervisor index policy not authorized');
  }
  
  public function canAdd(IdentityInterface $userSession, Supervisor $userData)
  {
    $supervisoresTable = TableRegistry::getTableLocator()->get('Supervisores');
    $supervisorCadastrado = $supervisoresTable->find()->where(['user_id' => $userSession->id]);

    if ($supervisorCadastrado->count() > 0) {
      return new Result(false, 'Erro: supervisores add policy not authorized');
    } else {
      return new Result(true);
    }
    
  }
  
  public function canView(IdentityInterface $userSession, Supervisor $userData)
  {
    if ($this->sameUser($userSession, $supervisorData)) {
      return new Result(true);
    } else {
      return new Result(false, 'Erro: supervisor view policy not authorized');
    }
  }
  
  public function canEdit(IdentityInterface $userSession, Supervisor $userData)
  {
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

  public function canBuscar()
  {
    return new Result(false, 'Erro: supervisor buscar policy not authorized');
  }
  
  protected function sameUser(IdentityInterface $userSession, Supervisor $supervisorData)
  {
    return ($userSession->id == $supervisorData->user_id);
  }
  
}