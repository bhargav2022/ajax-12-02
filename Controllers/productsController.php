<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use DB;


class productsController extends Controller
{

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //  echo "hello";
        return view('create');
    }

     public function edit( Request $request, $id)
     {
//print_r($_POST);
  $update= products::where('id',$id)->update([
      'name' => $request->input('name'),
      'price' => $request->input('price'),
      'desc' => $request->input('desc'),
      'qty' => $request->input('qty'),
      'discount' => $request->input('discount'),
      'total' => $request->input('total'),
   ]);


    //     $update=products::find($id);
    //    $update=products::where('id',$update->id)->update(['name'=>'$name']);
        if(empty($update)){
            echo "0";
        }
        else{
            echo "1";
        }
        
     }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product= $request->all();
    //  // $destinationPath = public_path().'\images/' ;
    //    $files=$product['productimg'];
    //    print_r($files)
    //    die();

      /*image upload in ajax */
     $file = $product['productimg'];
    $fileName = $file->getClientOriginalName();
     $destinationPath = public_path().'\images/' ;
     $file->move($destinationPath, $fileName);
/*image upload in ajax end */
    
         $values=$_POST;
       
        $products = new products;
                $products->name = $values['name'];
                $products->productimg =  $file_name;
                $products->price = $values['price'];
				$products->desc = $values['desc'];
                $products->qty = $values['qty'];
                $products->discount = $values['discount'];
                $products->total = $values['total'];
                $products->save();
                if(empty($product)){
                    echo "1";
                }
                else{
                    echo "0";
                }
    
    
    //     $products->productimg = $request->file('productimg')->storeAs(
    //         'public/images./', $products->productimg
    // );
    //    $imagepath = $request->file('productimg')->storeAs(
    //         'public/images./', $products->productimg
  //  );
    // $products->save();
   
//      //   $imagename = $files = time() .'.'. $request->image->extension();
//       //  $imagestore =  $request->file->move(public_path('images'),$imagename);
//         $imagepath = $request->file->store('public/images');
//         // $file = $request->file->store('public/images');
//   // 
  
       // DB::table('products')->insert($values);
          
          
			//	return redirect('create')->with('status',"Insert successfully");
         //die();
       //echo 'WERFG';
       //return $data = $request->all();
           //echo "hello";
        //  $request->validate([
        //     'name' => 'required',
        //     'price' => 'required',
        //     'description' => 'required',
        //     'qty' => 'required',
            
        // ]);
        //  products::store($request->all());
        // return json_encode(array(
        //   "statusCode"=>200
        //  ));
   
        //  $data=new products;
        //  $data->name= $request('name');
        // //  print_r($data->name);
        //  $data->price=$request('price');
        //  $data->description=$request('desc');
        //  $data->qty=$request('qty');
        //  $data->discount=$request('discount');
        //  $data->total=$request('total');
        //  $data->save();
        // products::create([
        //     'name'=>$request-> name,
        //     'price'=>$request-> price,
        //     'description'=>$request-> description,
        //     'qty'=>$request-> qty,
        //     'discount'=>$request-> discount,
        //     'total'=> $request->total,  
        //   ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     function prolist()
    {


        
      $product = DB::table('products')->select( 'id','name', 'price','desc','qty','discount','total')->where('status',1)->get();

        // $blog = products::find(1);
        // print_r($blog);
      // return response($product);
       return view('list',compact('product'));
       //return view('list')->with('product',$product)
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)  
    {
     
    //   echo "hello".$id;
     $data = DB::table('products')->select( 'id','name', 'price','desc','qty','discount','total')->where('id',$id)->get();
     return view("update",["data"=>$data]);
     //print_r($data);
    //   $update=products::find($id);
    //   $update=products::where('id',$update->id)->update(['name'=>'']);
    //   if(empty($update)){
    //       echo "0";
    //   }
    //   else{
    //       echo "1";
    //   }
    //     $product = DB::table('products')->select( 'name', 'price','desc','qty','discount','total')->where('id',$id)->get(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
       // echo "hello".$id;
       // $product = DB::table('products')->select( 'name', 'price','desc','qty','discount','total')->where('id',$id)->get();
        $delete=products::find($id);
        $delete=products::where('id',$delete->id)->update(['status'=>'0']);
        if(empty($delete)){
            echo "0";
        }
        else{
            echo "1";
        }
        
    }
}
