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
      $data = $identity->getOriginalData();
      if ($data and $data->categoria_id == 1) {
        return true;
      }
    }
    return null;
  }
  
  public function scopeIndex($user, $query)
  {
    return $query->where(['Users.id' => $user->getIdentifier()]);
  }
  
}