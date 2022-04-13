<?php

namespace App\Repositories;

use App\Models\Dislike;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersRepository
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function getRandomUser(): User
    {
        $allLikes = [];
        $likes = Like::whereIn('user_id', [auth()->id()])
            ->get('liked_user_id');
        foreach ($likes as $like) {
            $allLikes[] = $like['liked_user_id'];
        };

        $allDislikes = [];
        $dislikes = Dislike::whereIn('user_id', [auth()->id()])
            ->get('liked_user_id');
        foreach ($dislikes as $dislike) {
            $allDislikes[] = $dislike['liked_user_id'];
        };

        $result = User::with('profile')
            ->inRandomOrder()
            ->whereNotIn('id', [$this->user->id])
            ->whereHas('profile', function (Builder $query) {
                $query
                    ->where('gender', $this->user->profile->interested_in)
                    ->whereIn('interested_in', [$this->user->profile->gender, "Everyone"])
                    ->whereBetween('birthday', [
                        date("Y-m-d", strtotime(date("Y-m-d") . " - {$this->user->profile->age_to} year")),
                        date("Y-m-d", strtotime(date("Y-m-d") . " -{$this->user->profile->age_from} year")),
                    ])
                    ->where('age_from', '<=', $this->user->getAgeAttribute())
                    ->where('age_to', '>=', $this->user->getAgeAttribute());
            })
            ->whereNotIn('id', $allLikes)
            ->whereNotIn('id', $allDislikes)
            ->first();

        if (auth()->user()->profile->interested_in === "Everyone") {
            $result = User::with('profile')
                ->whereNotIn('id', [$this->user->id])
                ->whereHas('profile', function (Builder $query) {
                    $query
                        ->whereIn('interested_in', [$this->user->profile->gender, 'Everyone'])
                        ->where('age_from', '<=', $this->user->getAgeAttribute())
                        ->where('age_to', '>=', $this->user->getAgeAttribute())
                        ->whereBetween('birthday', [
                            date("Y-m-d", strtotime(date("Y-m-d") . " -{$this->user->profile->age_to} year")),
                            date("Y-m-d", strtotime(date("Y-m-d") . " -{$this->user->profile->age_from} year")),
                        ]);
                })
                ->whereNotIn('id', $allLikes)
                ->whereNotIn('id', $allDislikes)
                ->inRandomOrder()
                ->first();
        }

        if ($result === null) {
            $result = User::with('profile')
                ->whereNotIn('id', [$this->user->id])
                ->inRandomOrder()
                ->first();
        }
        return $result;
    }
}
