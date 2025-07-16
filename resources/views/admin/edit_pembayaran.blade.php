@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>EDIT Metode Pembayaran</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('admin.create.kategori') }}">
                        <div class="text-tiny">Pembayaran</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit Pembayaran</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{route('update.metode')}}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{$metode->id}}"/>
                <fieldset class="name">
                    <div class="body-title">Nama Pembayaran <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Nama" name="nama"
                        tabindex="0" value="{{$metode->nama}}" aria-required="true" required="">
                </fieldset>
                @error('name') <span class="alert alert-danger text-center">{{$message}}</span> 
                @enderror
                <fieldset class="deskripsi">
                    <div class="body-title mb-10">Deskripsi <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="deskripsi" placeholder="deskripsi"
                        tabindex="0" aria-required="true" required="">{{$metode->deskripsi}}</textarea>
                    
                </fieldset>
                @error('deskripsi') <span class="alert alert-danger text-center">{{$message}}</span> 
                @enderror
                <fieldset>
                    <div class="body-title">Upload image <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" >
                            <img src="{{asset('uploads/pembayaran')}}/{{$metode->image}}" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror
                <div class="gap22 cols">
                    <fieldset class="status">
                        <div class="body-title mb-10">status <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="status">
                                <option>Ubah status</option>
                                
                                    <option value="1">active</option>
                                    <option value="0">inactif</option>
                                
                            </select>
                        </div>
                    </fieldset>
                </div>
                @error('status') <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror
                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
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