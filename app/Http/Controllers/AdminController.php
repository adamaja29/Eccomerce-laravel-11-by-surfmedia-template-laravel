<?php

namespace App\Http\Controllers;


use App\Models\Kategori;
use App\Models\MetodePembayaran;
use App\Models\pesanan;
use App\Models\detail_pesanan;
use Illuminate\Support\Facades\Redirect;
use App\Models\Produk;
use App\Models\Suppliers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\laravel\Facades\Image;

class AdminController extends Controller
{


    public function Kategori(){
        $kategoris = Kategori::orderBy('id', 'desc')->paginate(10);
        return view('admin.kategori', compact('kategoris'));
    }

    public function KategoriCreate(){
        return view('admin.create_kategori');
    }

    public function KategoriStore(Request $request){
        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:kategoris',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $kategori = new Kategori();
        $kategori->nama = $request->nama;
        $kategori->kode = $request->kode;
        
        $kategori->image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GeneratedKategoriThumbnail($request->file('image'), $file_name);
        $kategori->image = $file_name;
        $kategori->save();
        return redirect()->route('admin.kategori')->with('success', 'kategori created successfully.');
    }

    public function KategoriEdit($id){
        $kategoris = Kategori::find($id);
        return view('admin.edit_kategori', compact('kategoris'));
    }

    public function KategoriUpdate(Request $request){
        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:kategoris,kode,' . $request->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $kategori = Kategori::find($request->id);
        $kategori->nama = $request->nama;
        $kategori->kode = $request->kode;

        if ($request->hasFile('image')) {
            // Delete old image
            if (File::exists(public_path('uploads/kategori/' . $kategori->image))) {
                File::delete(public_path('uploads/kategori/' . $kategori->image));
            }

            // Save new image
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GeneratedKategoriThumbnail($request->file('image'), $file_name);
            $kategori->image = $file_name;
        }

        $kategori->save();
        return redirect()->route('admin.kategori')->with('status', 'kategori updated successfully.');
    }

    public function GeneratedKategoriThumbnail($image, $image_name)
    {
        $destinationPath = public_path('uploads/kategori');
        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $image_name);
    }

    public function KategoriDelete($id){
        $kategori = Kategori::find($id);
        if (File::exists(public_path('uploads/kategori/' . $kategori->image))) {
            File::delete(public_path('uploads/kategori/' . $kategori->image));
        }
        $kategori->delete();
        return redirect()->route('admin.kategori')->with('status', 'Kategori deleted successfully.');

    }

    public function Produk(){
        $produks = Produk::orderBy('id', 'desc')->paginate(10);
        $suppliers = Suppliers::get();
        return view('admin.produk', compact('produks', 'suppliers'));
    }

    public function ProdukCreate(){
        $kategoris = Kategori::orderBy('id', 'desc')->get();
        $suppliers = Suppliers::orderBy('id', 'desc')->get();
        return view('admin.create_produk', compact('kategoris', 'suppliers'));
    }

    public function ProdukStore(Request $request){
        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:produks',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'required',
            'supplier_id' => 'required',
            'kategori_id' => 'required|exists:kategoris,id|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            
        ]);

        $produk = new Produk();
        $produk->nama = $request->nama;
        $produk->kode = $request->kode;
        $produk->harga_beli = $request->harga_beli;
        $produk->harga_jual = $request->harga_jual;
        $produk->supplier_id = $request->supplier_id;
        $produk->stok = $request->stok;
        $produk->deskripsi = $request->deskripsi;
        $produk->kategori_id = $request->kategori_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GeneratedProdukThumbnail($image, $imageName);
            $produk->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if ($request->hasFile('images')) {
            $allowedfileExtension = ['jpeg', 'png', 'jpg', 'gif'];
            $files = $request->file('images');
            foreach($files as $file){
                $getextension = $file->getClientOriginalExtension();
                $gcheck = in_array($getextension, $allowedfileExtension);
                if($gcheck){
                    $gfileName = $current_timestamp . $counter . '.' . $file->extension();
                    $this->GeneratedProdukThumbnail($file, $gfileName);
                    array_push($gallery_arr, $gfileName);
                    $counter = $counter +1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
            }
        $produk->images = $gallery_images;
        $produk->save();
        return redirect()->route('admin.produk')->with('status', 'produk created successfully.');
        }

        public function ProdukEdit($id){
            $produks = Produk::find($id);
            $kategoris = Kategori::select('id', 'nama')->orderBy('nama', 'desc')->get();
            $suppliers = Suppliers::orderBy('id', 'desc')->get();
            return view('admin.edit_produk', compact('produks', 'kategoris', 'suppliers'));
        }

        public function ProdukUpdate(Request $request){
            $request->validate([
                'nama' => 'required',
                'kode' => 'required|unique:produks,kode,' . $request->id,
                'harga_beli' => 'required|numeric',
                'harga_jual' => 'required|numeric',
                'supplier_id' => 'required',
                'stok' => 'required|numeric',
                'deskripsi' => 'required',
                'kategori_id' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $produk = Produk::find($request->id);
            $produk->nama = $request->nama;
            $produk->kode = $request->kode;
            $produk->harga_beli = $request->harga_beli;
            $produk->harga_jual = $request->harga_jual;
            $produk->supplier_id = $request->supplier_id;
            $produk->stok = $request->stok;
            $produk->deskripsi = $request->deskripsi;
            $produk->kategori_id = $request->kategori_id;
            
            $current_timestamp = Carbon::now()->timestamp;

            if ($request->hasFile('image')) {
                // Delete old image
                if (File::exists(public_path('uploads/produk/' . $produk->image))) 
                {
                    File::delete(public_path('uploads/produk/' . $produk->image));
                }
                if (File::exists(public_path('uploads/produk/thumbnails/' . $produk->image))) 
                {
                    File::delete(public_path('uploads/produk/thumbnails/' . $produk->image));
                }

                $image = $request->file('image');
                $imageName = $current_timestamp . '.' . $image->extension();
                $this->GeneratedProdukThumbnail($image, $imageName);
                $produk->image = $imageName;
            }

            $gallery_arr = array();
            $gallery_images = "";
            $counter = 1;

            if ($request->hasFile('images')) {
                foreach (explode(',', $produk->images) as $ofile) {
                    if (File::exists(public_path('uploads/produk/' . $ofile))) {
                        File::delete(public_path('uploads/produk/' . $ofile));
                    }
                    if (File::exists(public_path('uploads/produk/thumbnails/' . $ofile))) {
                        File::delete(public_path('uploads/produk/thumbnails/' . $ofile));
                    }
                }
                $allowedfileExtension = ['jpeg', 'png', 'jpg', 'gif'];
                $files = $request->file('images');
                foreach($files as $file){
                    $getextension = $file->getClientOriginalExtension();
                    $gcheck = in_array($getextension, $allowedfileExtension);
                    if($gcheck){
                        $gfileName = $current_timestamp . $counter . '.' . $file->extension();
                        $this->GeneratedProdukThumbnail($file, $gfileName);
                        array_push($gallery_arr, $gfileName);
                        $counter = $counter +1;
                    }
                }
                $gallery_images = implode(',', $gallery_arr);
                $produk->images = $gallery_images;
            }
            
            $produk->save();
            return redirect()->route('admin.produk')->with('status', 'produk updated successfully.');
        }

        public function ProdukDelete($id){
            $produk = Produk::find($id);
            if (File::exists(public_path('uploads/produk/' . $produk->image))) {
                File::delete(public_path('uploads/produk/' . $produk->image));
            }
            if (File::exists(public_path('uploads/produk/thumbnails' . $produk->images))) {
                File::delete(public_path('uploads/produk/thumbnails' . $produk->images));
            }

            foreach (explode(',', $produk->images) as $ofile) {
                if (File::exists(public_path('uploads/produk/' . $ofile))) {
                    File::delete(public_path('uploads/produk/' . $ofile));
                }
                if (File::exists(public_path('uploads/produk/thumbnails' . $ofile))) {
                    File::delete(public_path('uploads/produk/thumbnails' . $ofile));
                }
            }
            $produk->delete();
            return redirect()->route('admin.produk')->with('status', 'Produk deleted successfully.');
            
        }
    

    public function GeneratedProdukThumbnail($image, $image_name)
    {
        $destinationPathThumbnail = public_path('uploads/produk/thumbnails/');
        $destinationPath = public_path('uploads/produk/');
        $img = image::read($image->path());

        $img->cover(540, 648, "top");
        $img->resize(540, 648, function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $image_name);

        $img->resize(104, 104, function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail . '/' . $image_name);
    }

    public function MetodePembayaran()
    {
        $metode = DB::table('metode_pembayaran')->orderBy('id', 'desc')->get();

        return view('admin.pembayaran', compact('metode'));
    }

    public function createMethod()
    {
        return view('admin.create_metode');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',    
        ]);

        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'status' => '1',
        ];
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/pembayaran'), $imageName);
            $data['image'] = $imageName;
        }
        DB::table('metode_pembayaran')->insert($data);
        return redirect()->route('admin.metode.pembayaran')->with('status', 'Metode pembayaran created successfully.');
    }
    public function editMethod($id)
    {
        $metode = DB::table('metode_pembayaran')->where('id', $id)->first();
        return view('admin.edit_pembayaran', compact('metode'));
    }

    public function updateMethod(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:metode_pembayaran,id',
            'nama' => 'required',
            'deskripsi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:1,0',
        ]);
        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ];
        $metode = DB::table('metode_pembayaran')->where('id', $request->id)->first();
        if ($request->hasFile('image')) {
            // Delete old image
            if ($metode && $metode->image && File::exists(public_path('uploads/pembayaran/' . $metode->image))) {
                File::delete(public_path('uploads/pembayaran/' . $metode->image));
            }
    
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/pembayaran'), $imageName);
            $data['image'] = $imageName;
        }
        DB::table('metode_pembayaran')->where('id', $request->id)->update($data);
        return redirect()->route('admin.metode.pembayaran')->with('status', 'Metode pembayaran berhasil diperbarui.');
    }

    public function deleteMethod($id)
    {
        $metode = DB::table('metode_pembayaran')->where('id', $id)->first();
        if ($metode) {
            if (File::exists(public_path('uploads/pembayaran/' . $metode->image))) {
                File::delete(public_path('uploads/pembayaran/' . $metode->image));
            }
            DB::table('metode_pembayaran')->where('id', $id)->delete();
            return redirect()->route('admin.metode.pembayaran')->with('status', 'Metode pembayaran deleted successfully.');
        }
        return redirect()->route('admin.metode.pembayaran')->with('error', 'Metode pembayaran not found.');
    }

    public function Supplier()
    {
        $suppliers = Suppliers::orderBy('id', 'desc')->paginate(10);
        return view('admin.supplier', compact('suppliers'));
    }

    public function createSupplier()
    {
        return view('admin.create_supplier');
    }

    public function storeSupplier(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:suppliers,email',
            'kontak' => 'required',
            'alamat' => 'required',
            'nama_bank' => 'required',
            'nomor_bank' => 'required',
            'atas_nama' => 'required',
        ]);

        $supplier = new Suppliers();
        $supplier->nama = $request->nama;
        $supplier->email = $request->email;
        $supplier->kontak = $request->kontak;
        $supplier->alamat = $request->alamat;
        $supplier->nama_bank = $request->nama_bank;
        $supplier->nomor_bank = $request->nomor_bank;
        $supplier->atas_nama = $request->atas_nama;
        $supplier->status = 'aktif'; // Default status to active
        $supplier->save();

        return redirect()->route('admin.supplier')->with('status', 'Supplier created successfully.');
    }

    public function editSupplier($id)
    {
        $supplier = Suppliers::findOrFail($id);
        return view('admin.edit_supplier', compact('supplier'));
    }

    public function updateSupplier(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:suppliers,id',
            'nama' => 'required',
            'email' => 'required|email|unique:suppliers,email,' . $request->id,
            'kontak' => 'required',
            'alamat' => 'required',
            'nama_bank' => 'required',
            'nomor_bank' => 'required',
            'atas_nama' => 'required',
        ]);

        $supplier = Suppliers::findOrFail($request->id);
        $supplier->nama = $request->nama;
        $supplier->email = $request->email;
        $supplier->kontak = $request->kontak;
        $supplier->alamat = $request->alamat;
        $supplier->nama_bank = $request->nama_bank;
        $supplier->nomor_bank = $request->nomor_bank;
        $supplier->atas_nama = $request->atas_nama;
        // Status can be updated if needed
        if ($request->has('status')) {
            $supplier->status = $request->status;
        }
        $supplier->save();

        return redirect()->route('admin.supplier')->with('status', 'Supplier updated successfully.');
    }

    public function deleteSupplier($id)
    {
        $supplier = Suppliers::findOrFail($id);
        $supplier->delete();
        return redirect()->route('admin.supplier')->with('status', 'Supplier deleted successfully.');
    }

    
}

    

