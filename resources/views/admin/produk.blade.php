@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Produk</h3>
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
                    <div class="text-tiny">Produk</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="nama">
                            <input type="text" placeholder="Search here..." class="" nama="nama"
                                tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.create.produk')}}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    @if(Session::has('status'))
                        <p class="alert alert-success">{{Session::get('status')}}</p>
                    @endif
                    <table class="table table-bordered table-produk">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gambar</th>
                                <th>nama Produk</th>
                                <th>Kode Produk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Supplier</th>
                                <th>Action</th>
                                
                            </tr>
                            <?php
                $no = 1;
                foreach($produks as $produk) {
                ?>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td>{{$no++}}</td>
                                <td>
                                    @if($produk->image)
                                        <img 
                                        title="Preview Image"
                                        src="{{ asset('uploads/produk/thumbnails/' . $produk->image) }}" 
                                        alt="{{ $produk->nama }}" 
                                        class="image" 
                                        style="cursor:pointer; max-width: 200px; border-radius: 5px;" 
                                        onclick="showImagePopup('{{ asset('uploads/produk/thumbnails/' . $produk->image) }}')"
                                    />
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>{{$produk->nama}}</td>
                                <td>{{$produk->kode}}</td>
                                <td>Rp {{$produk->harga_beli}}</td>
                                <td>Rp {{$produk->harga_jual}}</td>
                                <td>{{$produk->stok}}</td>
                                <td>{{$produk->kategori->nama}}</td>
                                <td>{{$produk->deskripsi}}</td>
                                <td>{{$produk->suppliers->nama}}</td>
                                
                                <td>
                                    <div class="list-icon-function">
                                        <a href="#" target="_blank">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </a>
                                        <a href="{{ route('admin.edit.produk', ['id'=>$produk->id])}}" class="item edit">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('admin.delete.produk', ['id'=>$produk->id])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="item text-danger delete">
                                                <i class="icon-trash-2"></i>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php
                }
                ?>
                            
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $produks->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function(){
        $('.delete').on('click', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "You want to delete this produk!",
                type: "warning",
                buttons: ["cancel", "yes"],
                confirmButtonColor: "#DD6B55",
            }).then(function(result) {
                if (result) {
                    form.submit();
                }
            })
        });
    });

    window.showImagePopup = function(imageUrl) {
        swal({
            title: "Preview Gambar",
            text: "",
            content: {
                element: "div",
                attributes: {
                    innerHTML: '<img src="' + imageUrl + '" style="max-width:100%; border-radius:10px;" />'
                }
            },
            buttons: {
                cancel: "Tutup"
            }
        });
    };
        
</script>
@endpush