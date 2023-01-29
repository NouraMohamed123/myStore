<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Locales;
use Symfony\Component\Intl\Languages;
class ProfileController extends Controller
{
    public function edit(){
     
        $user = Auth::user();
        
        return view('dashboard.profile.edit',
    
    [
        'user'=>$user,
        'countries'=> Countries::getNames('en'),
        'locales' =>['gg','lll','kk'],
        'Languages' =>Languages::getName('en'),
    
    
    ]
    
    );
        
    }
     public function update(Request $request){
        
        // $profile = $user->profile;
        // if ($profile->first_name) {
        //     $profile->update($request->all());
        // } else {
        //     // $request->merge([
        //     //     'user_id' => $user->id,
        //     // ]);
        //     // Profile::create($request->all());

        //     $user->profile()->create($request->all());
        // }

         $user = Auth::user();
      
        $user->profile->fill( $request->all() )->save();
      
         
  return redirect()->route('dashboard.profile.edit')
            ->with('success', 'Profile updated!');

        
    }
}