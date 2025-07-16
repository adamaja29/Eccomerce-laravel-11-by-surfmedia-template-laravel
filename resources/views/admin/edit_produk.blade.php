@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
                           <!-- main-content-wrap -->
                           <div class="main-content-wrap">
                               <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                   <h3>Edit produk</h3>
                                   <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                       <li>
                                           <a href="{{ route('admin.dashboard') }}" class="flex items-center gap5">
                                               <div class="text-tiny">Dashboard</div>
                                           </a>
                                       </li>
                                       <li>
                                           <i class="icon-chevron-right"></i>
                                       </li>
                                       <li>
                                           <a href="{{route('admin.produk')}}">
                                               <div class="text-tiny">produk</div>
                                           </a>
                                       </li>
                                       <li>
                                           <i class="icon-chevron-right"></i>
                                       </li>
                                       <li>
                                           <div class="text-tiny">Edit produk</div>
                                       </li>
                                   </ul>
                               </div>
                               <!-- form-add-produk -->
                               @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                               
                                <form class="tf-section-2 form-add-produk"  method="POST" enctype="multipart/form-data" action="{{ route('admin.update.produk') }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" value="{{ $produks->id }}" />
                                    
                                    <div class="wg-box">
                                        <fieldset class="suppliers">
                                            <div class="body-title mb-10" >suppliers Produk <span class="tf-color-1">*</span></div>
                                            <div class="select">
                                                <select name="supplier_id" required>
                                                    <option value="">Pilih suppliers</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}" {{ $produks->suppliers_id == $supplier->id ? 'selected' : '' }}>
                                                            {{ $supplier->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </fieldset>
                                        
                                        @error('kategori')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror
                                        <fieldset class="name">
                                            <div class="body-title mb-10">Nama Produk <span class="tf-color-1">*</span></div>
                                            <input class="mb-10" type="text" placeholder="Enter produk name" name="nama" value="{{ $produks->nama }}" required>
                                            <div class="text-tiny">Do not exceed 100 characters when entering the produk name.</div>
                                        </fieldset>
                                        @error('nama')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror

                                        <fieldset class="name">
                                            <div class="body-title mb-10">Kode Produk <span class="tf-color-1">*</span></div>
                                            <input class="mb-10" type="text" placeholder="Enter produk kode" name="kode" value="{{ $produks->kode }}" required>
                                            <div class="text-tiny">Do not exceed 100 characters when entering the produk kode.</div>
                                        </fieldset>
                                        @error('kode')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror

                                        <fieldset class="kategori">
                                            <div class="body-title mb-10" >Kategori Produk <span class="tf-color-1">*</span></div>
                                            <div class="select">
                                                <select name="kategori_id" required>
                                                    <option value="">Pilih kategori</option>
                                                    @foreach($kategoris as $kategori)
                                                        <option value="{{ $kategori->id }}" {{ $produks->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                            {{ $kategori->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </fieldset>
                                        
                                        @error('kategori')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror

                                        <fieldset class="name">
                                            <div class="body-title mb-10">Harga <span class="tf-color-1">*</span></div>
                                            <input class="mb-10" type="number" placeholder="Enter Harga" name="harga_beli" value="{{ $produks->harga_beli }}" required>
                                        </fieldset>
                                        @error('harga_beli')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror
                                        <fieldset class="name">
                                            <div class="body-title mb-10">Harga <span class="tf-color-1">*</span></div>
                                            <input class="mb-10" type="number" placeholder="Enter Harga" name="harga_jual" value="{{ $produks->harga_jual }}" required>
                                        </fieldset>
                                        @error('harga_jual')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror

                                        <fieldset class="name">
                                            <div class="body-title mb-10">Stok <span class="tf-color-1">*</span></div>
                                            <input class="mb-10" type="text" placeholder="Enter Stok" name="stok" value="{{ $produks->stok }}" required>
                                        </fieldset>
                                        @error('stok')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="wg-box">
                                        <fieldset>
                                            <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                                            <div class="upload-image flex-grow">
                                                @if($produks->image)
                                                    <div class="item" id="imgpreview">
                                                        <img src="{{ asset('uploads/produk/thumbnails/' . $produks->image) }}" alt="{{ $produks->nama }}" />
                                                    </div>
                                                @endif
                                                <div id="upload-file" class="item up-load">
                                                    <label class="uploadfile" for="myFile">
                                                        <span class="icon">
                                                            <i class="icon-upload-cloud"></i>
                                                        </span>
                                                        <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                                        <input type="file" id="myFile" name="image" accept="image/*">
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                        @error('image')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror

                                        <fieldset>
                                            <div class="body-title mb-10">Upload Gallery Images</div>
                                            <div class="upload-image mb-16">
                                                @if($produks->images)
                                                    @foreach(explode(',', $produks->images) as $image)
                                                        <div class="item gitems">
                                                            <img src="{{ asset('uploads/produk/' . trim($image)) }}" alt="" />
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <div id="galUpload" class="item up-load">
                                                    <label class="uploadfile" for="gFile">
                                                        <span class="icon">
                                                            <i class="icon-upload-cloud"></i>
                                                        </span>
                                                        <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                                        <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
                                        @error('images')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror

                                        <fieldset class="deskripsi">
                                            <div class="body-title mb-10">Deskripsi <span class="tf-color-1">*</span></div>
                                            <textarea class="mb-10" name="deskripsi" placeholder="Deskripsi" required>{{ $produks->deskripsi }}</textarea>
                                        </fieldset>
                                        @error('deskripsi')
                                            <span class="alert alert-danger text-center">{{ $message }}</span>
                                        @enderror

                                        <div class="cols gap10">
                                            <button class="tf-button w-full" type="submit">Update Produk</button>
                                        </div>
                                    </div>
                                </form>
                               <!-- /form-add-produk -->
                           </div>
                           <!-- /main-content-wrap -->
                       </div>
@endsection

@push('scripts')
   <script>
       $(function(){
           $('#myFile').on('change', function(e){
               const photoInp = $("#myFile");
               const [file] = this.files;
               if (file) 
               {
                   $("#imgpreview img").attr('src', URL.createObjectURL(file));
                   $("#imgpreview").show();
               }
           });

           $('#gFile').on('change', function(e){
               const photoInp = $("#gFile");
               const gphotos = this.files;
               $.each(gphotos, function(key, val){
                   $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}"/></div>`);
               });
           });

           $("input[name='name']").on("change", function() {
               $("input[name='kode']").val();
             
           });
       });

       function stringTokode(Text)
       {
           return Text.toLowerCase()
               .replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ/g, 'a')
               .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ/g, 'o')
               .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, 'u')
               .replace(/í|ì|ỉ|ĩ|ị/g, 'i')
               .replace(/ý|ỳ|ỷ|ỹ|ỵ/g, 'y')
               .replace(/đ/g, 'd')
               .replace(/[^a-zA-Z0-9\s]/g, '')
               .replace(/\s+/g, '-');
       }
   </script>
   
@endpush