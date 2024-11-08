<?php
namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;

class UserPolicy
{
  
  public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
  {
    if ($identity->getOriginalData()->categoria_id == 1) {
      return true;
    }
  }
  
  public function canLogin() 
  { 
    return true; 
  }
  
  
  public function canAdd()
  {
      return true;
  }
  
  public function canView(IdentityInterface $userSession, User $userData)
  {
    if (!$userSession) return new Result(false, 'Erro: Preciso estar logado');
    if ($this->sameUser($userSession, $userData)) {
      new Result(true);
    } else {
      new Result(false, 'Erro: policy not authorized');
    };
  }
  
  public function canEdit(IdentityInterface $userSession, User $userData)
  {
    if (!$userSession) return new Result(false, 'Erro: Preciso estar logado');
    if ($this->sameUser($userSession, $userData)) {
      new Result(true);
    } else {
      new Result(false, 'Erro: policy not authorized');
    };
  }
  
  public function canDelete(IdentityInterface $userSession, User $userData)
  {
    return new Result(false, 'Erro: delete user not allowed');
  }

  protected function sameUser(IdentityInterface $userSession, User $userData)
  {
    return ($userSession->id == $userData->id);
  }
  
}