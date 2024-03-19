<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

        
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function checkAccessForUpdate($user){
        return (
            auth()->user()->hasRole('Super_admin') ||
            (auth()->user()->hasRole('Admin') && $user->roles[0]->name !== 'Super_admin' ) ||
            (auth()->user()->hasRole('Editor') && $user->roles[0]->name !== 'Super_admin' && $user->roles[0]->name !== 'Admin' )
        );
    }
    public function checkAccessForDelete($user){
        $isSuperAdmin = auth()->user()->hasRole('Super_admin');
        $isAdmin = auth()->user()->hasRole('Admin');
        $isEditor = auth()->user()->hasRole('Editor');
        return (
            ( auth()->user()->roles[0]->name !== $user->roles[0]->name) &&
            $user->roles[0]->name != 'Super_admin' ||
            ($isSuperAdmin  && auth()->user()->id != $user->id )
        );
    }
    public function checkRoles($role){
        $isSuperAdmin = auth()->user()->hasRole('Super_admin');
        $isAdmin = auth()->user()->hasRole('Admin');
        $isEditor = auth()->user()->hasRole('Editor');
        
        if($isSuperAdmin){
            
            return true;
        }elseif ($isAdmin) {
            
            return $role->name!='Super_admin';
        }elseif ($isEditor) {
            
            return $role->name!='Super_admin' && $role->name!='Admin';
        }else {
            
            return $role->name == 'user';
        }
    }
    public function checkForAssignPermission($role){
        $isSuperAdmin = auth()->user()->hasRole( 'Super_admin');
        $isAdmin = auth()->user()->hasRole( 'Admin');
        $isEditor = auth()->user()->hasRole( 'Editor');
        
        if($isSuperAdmin){
            
            return true;
        }elseif ($isAdmin) {
            
            return $role->name!='Super_admin' && $role->name!='Admin';

        }elseif ($isEditor) {
            
            return $role->name!='Super_admin' && $role->name!='Admin' && $role->name!='Editor';
        }
        else {

            return $role->name == 'user';
        }
    }
    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function UpdateAndDeletePost($post){
        $isSuperAdmin = auth()->user()->hasRole('Super_admin');
        $isAdmin = auth()->user()->hasRole('Admin');
        $isEditor = auth()->user()->hasRole('Editor');
        $existPost = false;
        foreach (auth()->user()->posts as $userPost) {
            if($userPost->id == $post->id){
                $existPost = true;
                break;
            }
        }
        return $isAdmin || $isSuperAdmin || $isEditor || $existPost ;
    }
    public function deleteCommentPermission($comment){
        $isSuperAdmin = auth()->user()->hasRole('Super_admin');
        $isAdmin = auth()->user()->hasRole('Admin');
        $isEditor = auth()->user()->hasRole('Editor');
        $existPost = false;
        foreach (auth()->user()->comments as $userComment) {
            if($userComment->id == $comment->id){
                $existPost = true;
                break;
            }
        }
        return $isAdmin || $isSuperAdmin || $isEditor || $existPost ;
    }
}   
