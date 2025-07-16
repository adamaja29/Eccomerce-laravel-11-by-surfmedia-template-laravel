@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Kategori infomation</h3>
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
                        <div class="text-tiny">kategori</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit kategori</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.update.kategori')}}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{$kategoris->id}}"/>
                <fieldset class="name">
                    <div class="body-title">kategori <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="kategori" name="nama"
                        tabindex="0" value="{{$kategoris->nama}}" aria-required="true" required="">
                </fieldset>
                @error('nama') <span class="alert alert-danger text-center">{{$message}}</span> 
                @enderror
                <fieldset class="name">
                    <div class="body-title">kategori kode <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="kategori kode" name="kode"
                        tabindex="0" value="{{$kategoris->kode}}" aria-required="true" required="">
                </fieldset>
                @error('kode') <span class="alert alert-danger text-center">{{$message}}</span>
                @enderror
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if($kategoris->image)
                        <div class="item" id="imgpreview" >
                            <img src="{{asset('uploads/kategori')}}/{{$kategoris->image}}" class="effect8" alt="">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{$message}}</span>
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