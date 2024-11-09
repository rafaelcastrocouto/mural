<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\UsersTable;
use Authorization\IdentityInterface;

class UsersTablePolicy
{
  
  public function before(?IdentityInterface $identity, mixed $resource, string $action): ResultInterface|bool|null
  {
    if ($identity->getOriginalData()->categoria_id == 1) {
      return true;
    }
  }
  
  public function scopeIndex($user, $query)
  {
    //pr($user);
    return $query->where(['Users.id' => $user->getIdentifier()]);
  }
  
}