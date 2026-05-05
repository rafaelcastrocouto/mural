<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\UsersTable;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

class UsersTablePolicy implements BeforePolicyInterface
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
  
  public function canLogin()
  {
    return new Result(true);
  }
  
  public function canAdd()
  {
    return new Result(true);
  }

  public function canIndex()
  {
    return new Result(false, 'Erro: users index policy not authorized');
  }
  
  public function canView()
  {
    return new Result(false, 'Erro: users view policy not authorized');
  }
  
  public function canEdit()
  {
    return new Result(false, 'Erro: users edit policy not authorized');
  }
  
  public function canEditpassword()
  {
    return new Result(false, 'Erro: users buscar policy not authorized');
  }
  
  public function canAlternar()
  {
    return new Result(false, 'Erro: users alternar policy not authorized');
  }
  
  public function scopeIndex($user, $query)
  {
    return $query->where(['Users.id' => $user->getIdentifier()]);
  }

  public function canBuscar()
  {
    return new Result(false, 'Erro: users buscar policy not authorized');
  }
  
}