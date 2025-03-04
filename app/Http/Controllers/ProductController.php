<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Products;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $PassedTime = Carbon::now()->subweeks(2);

	    $products = Products::paginate(8);
	    $new_arrival = Products::where('created_at','>=',$PassedTime)->get();

	    return view('Products.shop',['products'=>$products,'new_arrival'=>$new_arrival]);
    }




    public function ProductFilter($ProductType,$CategoryId){
	    
	    $Products = Products::where('Type',$ProductType)->where('CategoryId',$CategoryId)->get();//->paginate(20);

	    return view('category.view',['products'=> $Products]);

    
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $validateData = $request->validate([
	         
		    'ProductName'=>['required','alpha'],
		    'CategoryId'=>['required'],
		   'Quantity'=>['required'],
		   'Type'=>['required'],
		   'Price'=>['required']
	    
	    ]);


	    $product = new Products;
	    $product->ProductName = $request->input('ProductName');
	    $product->CategoryId = $request->input('CategoryId');
	    $product->Quantity  = $request->input('Quantity');
	    $product->Price = $request->input('Price');
	    $product->Type = $request->input('Type');

	    $product->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    $product = Products::findorfail($id);

	    return view('Products.product-single',['product'=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    //return the product
	    $product = Products::findorfail($id);

	    return view('edit',['products'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

	    $validateData = $request->validate([
	         
		    'ProductName'=>['required','alpha'],
		    'CategoryId'=>['required'],
		   'Quantity'=>['required'],
		   'Type'=>['required'],
		   'Price'=>['required']
	    
	    ]);


	    $product = Products::findorfail($id);
	    $product->ProductName = $request->input('ProductName');
	    $product->CategoryId = $request->input('CategoryId');
	    $product->Quantity  = $request->input('Quantity');
	    $product->Price = $request->input('Price');
	    $product->Type = $request->input('Type');

	    $product->save();




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
