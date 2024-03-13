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
        return (int)$user->id === (int)$article->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Article $article): bool
    {
        return $admin->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Article $article): bool
    {
        return $admin->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Article $article): bool
    {
        return $admin->isAdmin();
    }


    public function approve(Admin $admin, Article $article): bool
    {
        return $admin->isAdmin();
    }
}
