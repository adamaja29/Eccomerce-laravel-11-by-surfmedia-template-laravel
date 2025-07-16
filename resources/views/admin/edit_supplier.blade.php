@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Metode Pembayaran</h3>
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
                    <a href="{{ route('admin.create.supplier') }}">
                        <div class="text-tiny">Supplier</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">New Pembayaran</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{route('update.supplier')}}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $supplier->id }}">
                <fieldset class="name">
                    <div class="body-title">Nama Supplier <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Nama" name="nama"
                        tabindex="0" value="{{ $supplier->nama}}" aria-required="true" required="">
                </fieldset>
                @error('name') <span class="alert alert-danger text-center">{{$message}}</span> 
                @enderror
                <fieldset class="email">
                    <div class="body-title ">Email <span class="tf-color-1">*</span>
                    </div>
                    <input class="flex-grow" name="email" placeholder="Email" type="email"
                        tabindex="0" value="{{$supplier->email}}" aria-required="true" required=""></input>
                </fieldset>
                @error('email') <span class="alert alert-danger text-center">{{$message}}</span> 
                @enderror
                <fieldset class="kontak">
                    <div class="body-title ">Kontak <span class="tf-color-1">*</span>
                    </div>
                    <input class="flex-grow" name="kontak" placeholder="kontak" type="number"
                        tabindex="0" value="{{$supplier->kontak}}" aria-required="true" required=""></input>
                </fieldset>
                @error('kontak') <span class="alert alert-danger text-center">{{$message}}</span> 
                @enderror
                <fieldset class="alamat">
                    <div class="body-title ">Alamat <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="flex-grow" name="alamat" placeholder="alamat"
                        tabindex="0" aria-required="true" required="">{{$supplier->alamat}}</textarea>
                    
                </fieldset>
                @error('alamat') <span class="alert alert-danger text-center">{{$message}}</span> 
                @enderror
                <fieldset class="nama_bank">
                    <div class="body-title ">Nama Bank <span class="tf-color-1">*</span>
                    </div>
                    <input class="flex-grow" name="nama_bank" placeholder="nama_bank" type="text"
                        tabindex="0" value="{{$supplier->nama_bank}}" aria-required="true" required=""></input>
                    
                </fieldset>
                @error('nama_bank') <span class="alert alert-danger text-center">{{$message}}</span> 
                @enderror
                <fieldset class="nomor_bank">
                    <div class="body-title ">Nomor Rekening <span class="tf-color-1">*</span>
                    </div>
                    <input class="flex-grow" name="nomor_bank" placeholder="nomor_bank" type="number"
                        tabindex="0" value="{{$supplier->nomor_bank}}" aria-required="true" required=""></input>
                </fieldset>
                @error('nomor_bank') <span class="alert alert-danger text-center">{{$message}}</span> 
                @enderror
                <fieldset class="atas_nama">
                    <div class="body-title ">Atas Nama <span class="tf-color-1">*</span>
                    </div>
                    <input class="flex-grow" name="atas_nama" placeholder="atas_nama" type="text"
                        tabindex="0" value="{{$supplier->atas_nama}}" aria-required="true" required=""></input>
                </fieldset>
                @error('atas_nama') <span class="alert alert-danger text-center">{{$message}}</span> 
                @enderror
                <div class="gap22 cols">
                    <fieldset class="status">
                        <div class="body-title mb-10">status <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="status">
                                <option value="">Ubah status</option>
                                    <option value="aktif" {{ $supplier->status == 'aktif' ? 'selected' : '' }}>active</option>
                                    <option value="nonaktif" {{ $supplier->status == 'nonaktif' ? 'selected' : '' }}>inactif</option>
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