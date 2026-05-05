<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\SupervisoresTable;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

class SupervisoresTablePolicy implements BeforePolicyInterface
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
  
  public function canIndex()
  {
    return new Result(false, 'Erro: supervisores index policy not authorized');
  }
  
  public function canView()
  {
    return new Result(false, 'Erro: supervisores view policy not authorized');
  }
  
  public function canEdit()
  {
    return new Result(false, 'Erro: supervisores delete policy not authorized');
  }
  
  public function canDelete()
  {
    return new Result(false, 'Erro: supervisores delete policy not authorized');
  }
  
  public function scopeIndex($user, $query)
  {
    return $query->where(['Supervisores.user_id' => $user->getIdentifier()]);
  }

  public function canAdd()
  {
    return new Result(false, 'Erro: supervisores add policy not authorized');
  }
  
  public function canBuscar()
  {
    return new Result(false, 'Erro: supervisores busca policy not authorized');
  }


}