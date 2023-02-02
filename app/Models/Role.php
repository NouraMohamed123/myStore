<?php

namespace App\Models;

use App\Models\RoleAbilites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamp = false;

    public function abilities()
    {
        return $this->hasMany('App\Models\RoleAbilites');
    }
    public function users()
    {
        return $this->belongsToMany(
            'role_user' //bivot tableS
            // 'product_id', //fk in bivot table
            // 'tag_id', //fk in bivot table
            // 'id',
            // 'id'
        );
    }
    public static function createWithAbilities(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->post('name'),
            ]);

            foreach ($request->post('abilities') as $ability => $value) {
                RoleAbilites::create([
                    'role_id' => $role->id,
                    'ability' => $ability,
                    'type' => $value,
                ]);
            }

            DB::table('role_user')->insert([
                'role_id' => $role->id,
                'authorizable_type' => 'admin',
                'authorizable_id' => Auth::user()->id,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $role;
    }

    public function updateWithAbilities(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->update([
                'name' => $request->post('name'),
            ]);

            foreach ($request->post('abilities') as $ability => $value) {
                RoleAbilites::updateOrCreate(
                    [
                        'role_id' => $this->id,
                        'ability' => $ability,
                    ],
                    [
                        'type' => $value,
                    ]
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this;
    }
}