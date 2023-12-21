<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        $user->update(['ref_code' => $user->getRefCode()]);
        $user->nairaWallet()->create();
        $user->goldWallet()->create();
        $user->silverWallet()->create();
    }
}
