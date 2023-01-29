<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Category;
use Str;
use Redirect;
use Storage;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
   
    
       $query =Category::query();
     
       if( $name = $request->query('name')){
        $query->where('name','LIKE',"%{$name}%");
       }
        if( $status = $request->query('status')){
        $query->where('status','LIKE',"%{$status}%");
       }
        $categories = $query->leftjoin('categories as parents','parents.id','=','categories.parent_id')
        
        ->select([
          'categories.*',
          'parents.name as parent_name'
        ])
        
        ->paginate();
   
        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $parents = Category::all();
          $category = new Category();
          return view('dashboard.categories.create',compact('parents','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
        'name'=>'required|min:3|max:255|',
        'parent_id' =>[
          'int','exists:categories,id','nullable'
        ],
        'image'=>[
          'mimes:png,jpg',
        ],
         'status'=>[
          'required',
        ]
        ]);
 
        $request->merge([
'slug'=> Str::slug($request->post('name'))
]);

$data = $request->except('image');
$data['image'] = $this->uploadImage( $request);


//erquest merge

$categories = Category::create($data);
//flash message
return Redirect::route('categories.index')->with(['success'=> 'category created']);

}

/**
* Display the specified resource.
*
* @param int $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
//
}

/**
* Show the form for editing the specified resource.
*
* @param int $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
try {

$category = Category::findOrFail($id);
$parents = Category::where('id','!=',$id)
->where(function($query) use($id){
$query->whereNull('parent_id')->orwhere('parent_id','!=',$id);
})
->get();
return view('dashboard.categories.edit',compact('category','parents'));

}
catch(Exception $e){

return Redirect::route('categories.index')->with(['info'=> '!!!!!']);
}

}

/**
* Update the specified resource in storage.
*
* @param \Illuminate\Http\Request $request
* @param int $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{

   $request->validate([
        'name'=>"required|min:3|max:255|unique:categories,name,$id",
        'parent_id' =>[
         'exists:categories,id'
        ],
        'image'=>[
          'mimes:png,jpg',
        ]
        ]);

        
$Category = Category::find($id);
$old_image = $Category->image;
$data = $request->except('image');


$data['image'] = $this->uploadImage( $request);


if($old_image && isset( $data['image'])) {
Storage::disk('public')->delete($old_image);
}

$Category->update($data);

return Redirect::route('categories.index')->with(['success'=> 'category updated']);
}

/**
* Remove the specified resource from storage.
*
* @param int $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
  
try{
 
    if(!empty($id)){
    $Category  = Category::where('id',$id)->first();

    $Category->delete();
    
  }


if($Category->image) {
Storage::disk('public')->delete($Category->image);
}
 return Redirect::route('categories.index')->with(['success'=> 'category deleted']);

  
}catch(Exception $e){

  return Redirect::route('categories.index')->with(['errors'=> 'category deleted']);

}
}

    protected function uploadImage(Request $request){

if(!$request->hasFile('image')){

return;
}
$file = $request->file('image');
$path = $file->store('uploads');
return $path;

}


public function trash(){
   print_r(55 );exit;
  try{

    $Category = category::onlyTrashed()->paginate();
    return view('dashboard.categories.trashed',compact('Category'));
  }catch(Exception $e ){

  }
 }


 public function restore(Request $request,$id){
            $Category =  category::onlyTrashed()->findOrfail($id);
              $Category->restore();
                  return view('dashboard.categories.trashed')->with('succes','Category restord');
 }
 
 


 public function forceDelete($id){
    $Category =  category::onlyTrashed()->findOrfail($id);
    $Category->forceDelete();
         return redirect()->route('categories.trash')->with('succes','Category deleted forever ');
}


}