<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('backend.products.index',[
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $request->validate([
                'name'=>['required','min:3'],
                'price'=>['required','min:2'],
                'category_name'=>['required','min:2'],
                'description'=>['required','min:10'],
                'image'=>['required']
            ]);
            Product::create([
                'name'=>$request->name,
                'price'=>$request->price,
                'category_name'=>$request->category_name,
                'description'=>$request->description,
                'image'=>$this->uploadImage(request()->file('image')),
                'status'=>$request->boolean('status')
            ]);

            return redirect()->route('products.index')->withMessage('product is added successfully');
        }
        catch(QueryException $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('backend.products.show',[
            'product'=>$product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('backend.products.edit',[
            'product'=>$product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try
        {
            $request->validate([
                'name'=>['required','min:3'],
                'price'=>['required','min:2'],
                'category_name'=>['required','min:2'],
                'description'=>['required','min:10'],
                'image'=>['required']
            ]);
            
            $requestData = [
                'name'=>$request->name,
                'price'=>$request->price,
                'category_name'=>$request->category_name,
                'description'=>$request->description,
                'status'=>$request->boolean('status')
        ];

        if($request->hasFile('image'))
        {
            $requestData['image'] = $this->uploadImage(request()->file('image'));
        }

        $product->update($requestData);

        return redirect()->route('products.index')->withMessage('product is successfully updated!');
        }
        catch(QueryException $e)
        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }

    public function uploadImage($file)
    {
        $fileName = time().'.'.$file->getClientOriginalExtension();
        'Image'::make($file)->resize(200,200)
                          ->save(storage_path().'/app/public/'.$fileName);
                          return $fileName;
    }
}
