@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add produk</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap5">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.produk') }}">
                        <div class="text-tiny">produk</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <div class="text-tiny">Tambah Produk Baru</div>
                </li>
            </ul>
        </div>

        <form class="tf-section-2 form-add-produk" method="POST" enctype="multipart/form-data" action="{{ route('admin.store.produk') }}">
            @csrf
            <div class="wg-box">
                <div class="gap22 cols">
                    <fieldset class="supplier">
                        <div class="body-title mb-10">supplier <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="supplier_id">
                                <option>Pilih supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                </div>

                <fieldset class="name">
                    <div class="body-title mb-10">Nama Produk <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter produk name" name="nama" value="{{ old('nama') }}" required>
                    <div class="text-tiny">Do not exceed 100 characters when entering the produk name.</div>
                </fieldset>
                @error('nama') 
                    <span class="alert alert-danger text-center">{{ $message }}</span> 
                @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">kode Produk <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter produk kode" name="kode" value="{{ old('kode') }}" required>
                    <div class="text-tiny">Do not exceed 100 characters when entering the produk name.</div>
                </fieldset>
                @error('kode') 
                    <span class="alert alert-danger text-center">{{ $message }}</span> 
                @enderror

                <div class="gap22 cols">
                    <fieldset class="kategori">
                        <div class="body-title mb-10">Kategori <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="kategori_id">
                                <option>Pilih kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Harga Beli<span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter Harga" name="harga_beli" value="{{ old('harga_beli') }}" required>
                    </fieldset>
                    @error('harga_beli') 
                        <span class="alert alert-danger text-center">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Harga Jual<span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter Harga" name="harga_jual" value="{{ old('harga_jual') }}" required>
                    </fieldset>
                    @error('harga_jual') 
                        <span class="alert alert-danger text-center">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stok <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter Stok" name="stok" required>
                    </fieldset>
                    @error('stok') 
                        <span class="alert alert-danger text-center">{{ $message }}</span> 
                    @enderror
                </div>
            </div>

            <div class="wg-box">
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="../../../localhost_8000/images/upload/upload-1.png" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
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
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
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
                    <textarea class="mb-10" name="deskripsi" placeholder="deskripsi" required>{{ old('deskripsi') }}</textarea>
                </fieldset>
                @error('deskripsi') 
                    <span class="alert alert-danger text-center">{{ $message }}</span> 
                @enderror

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Add produk</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function() {
        $('#myFile').on('change', function() {
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });

        $('#gFile').on('change', function() {
            const gphotos = this.files;
            $.each(gphotos, function(key, val) {
                $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}"/></div>`);
            });
        });

        $("input[name='name']").on("change", function() {
            $("input[name='kode']").val();
        });
    });

    function stringTokode(Text) {
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
