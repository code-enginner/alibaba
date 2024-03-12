<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article, Admin $admin): bool
    {

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
//        if ((int)$user->id === (int)$article->user_id) {
//            return TRUE;
//        }
//        return FALSE;
        return (int)$user->id === (int)$article->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article, Admin $admin): bool
    {
        return $admin->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Article $article, Admin $admin): bool
    {
        return $admin->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article, Admin $admin): bool
    {
        return $admin->isAdmin();
    }


    public function approve(User $user, Article $article, Admin $admin): bool
    {
        return $admin->isAdmin();
    }
}
