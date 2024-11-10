<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\ResultInterface;

class UserPolicy implements BeforePolicyInterface
{
  
  public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
  {
    if ($identity->getOriginalData()->categoria_id == 1) {
      return true;
    }
    return null;
  }
  
  public function canAdd()
  {
      return new Result(true);
  }
  
  public function canView(IdentityInterface $userSession, User $userData)
  {
    if (!$userSession) return new Result(false, 'Erro: Preciso estar logado');
    if ($this->sameUser($userSession, $userData)) {
      return new Result(true);
    } else {
      return new Result(false, 'Erro: policy not authorized');
    };
  }
  
  public function canEdit(IdentityInterface $userSession, User $userData)
  {
    if (!$userSession) return new Result(false, 'Erro: Preciso estar logado');
    if ($this->sameUser($userSession, $userData)) {
      return new Result(true);
    } else {
      return new Result(false, 'Erro: policy not authorized');
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