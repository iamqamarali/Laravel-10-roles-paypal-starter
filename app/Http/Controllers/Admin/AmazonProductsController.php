<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AmazonProduct;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AmazonProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:super-admin']);
    }

    /** 
     * Display a listing of the resource.
     */
    public function index(Group $group)
    {        
        $this->authorize('viewAny', AmazonProduct::class);

        return view('products.index', [
            'group' => $group,
            'products' => $group->amazon_products()->latest()->paginate(50),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Group $group)
    {
        $this->authorize('create', AmazonProduct::class);
        
        return view('products.create', ['group' => $group]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Group $group)
    {
        $this->authorize('create', AmazonProduct::class);

        $request->validate([
            'products_file' => 'required|mimes:xlsx|max:10240',
        ]);
        
        // save the file as products.xlsx
        $file = $request->file('products_file');
        $file->storeAs('products','products.xlsx', 'public');

        // read .xlsx file  
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('storage/products/products.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();

        foreach ($worksheet->getRowIterator() as $row) {
            $index = $row->getRowIndex();

            if($index == 1) 
                continue;

            if(!$title = $worksheet->getCell('A' . $index)->getValue()) 
                break;

            $product_json = [
                'name' => $title,
                'store_to_amz' => $worksheet->getCell('B' . $index)->getValue(),
                'store_link' => $worksheet->getCell('C' . $index)->getValue(),
                'amz_link' => $worksheet->getCell('D' . $index)->getValue(),
                'monthly_sales' => $worksheet->getCell('E' . $index)->getValue(),
                'bsr' => $worksheet->getCell('F' . $index)->getValue(),
                'selling_price' => $worksheet->getCell('G' . $index)->getValue(),
                'sup_price_tax' => $worksheet->getCell('H' . $index)->getValue(),
                'prep' => $worksheet->getCell('I' . $index)->getValue(),
                'amz_ship' => $worksheet->getCell('J' . $index)->getValue(),
                'fba_fee' => $worksheet->getCell('K' . $index)->getValue(),
                'profit' => $worksheet->getCell('L' . $index)->getCalculatedValue(),
                'roi' => $worksheet->getCell('M' . $index)->getFormattedValue(),
                'discount_code' => $worksheet->getCell('N' . $index)->getValue(),
                'date' => $worksheet->getCell('O' . $index)->getFormattedValue(),
            ];

            // create the products in db from .xlsx file
            $product = new AmazonProduct();
            $product->group_id = $group->id;
            $product->title = $title;
            $product->data = $product_json;
            $product->save();
        }    

        return redirect()
                    ->route('groups.products.index', $group->id)
                    ->with('success', 'products for group '. $group->name .' added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(AmazonProduct $amazonProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AmazonProduct $amazonProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AmazonProduct $amazonProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($amazonProduct)
    {
        $this->authorize('delete', AmazonProduct::class);

        $amazonProduct = AmazonProduct::find($amazonProduct);
        $group_id = $amazonProduct->group_id;
        $amazonProduct->delete();

        return redirect()->route('groups.products.index', $group_id)
                        ->with('success', 'Product deleted successfully');
    }
}
