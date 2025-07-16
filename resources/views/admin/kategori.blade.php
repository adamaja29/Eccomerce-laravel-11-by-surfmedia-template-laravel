@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Kategori</h3>
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
                    <div class="text-tiny">Kategori</div>
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
                <a class="tf-button style-1 w208" href="{{ route('admin.create.kategori')}}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    @if(Session::has('status'))
                        <p class="alert alert-success">{{Session::get('status')}}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gambar</th>
                                <th>nama</th>
                                <th>Kode</th>
                                <th>Produk</th>
                                <th>Action</th>
                                
                            </tr>
                            <?php
                $no = 1;
                foreach($kategoris as $category) {
                ?>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <td>{{$no++}}</td>
                                <td class="pnama">
                                    @if($category->image)
                                        <img 
                                        title="Preview Image"
                                        src="{{ asset('uploads/kategori/' . $category->image) }}" 
                                        alt="{{ $category->nama }}" 
                                        class="image" 
                                        style="cursor:pointer; max-width: 200px; border-radius: 5px;" 
                                        onclick="showImagePopup('{{ asset('uploads/kategori/' . $category->image) }}')"
                                    />
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td class="nama">
                                    <div class="nama">
                                        <a href="#" class="body-title-2">{{$category->nama}}</a>
                                    </div>
                                </td>
                                <td>{{$category->kode}}</td>
                                <td><a href="#" target="_blank">1</a></td>
                                <td>
                                    <div class="list-icon-function">
                                        <a href="{{ route('admin.edit.kategori', ['id'=>$category->id])}}" class="item edit">
                                            <div class="item edit">
                                                <i class="icon-edit-3"></i>
                                            </div>
                                        </a>
                                        <form action="{{ route('admin.delete.kategori', ['id'=>$category->id])}}" method="POST">
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
                    {{ $kategoris->links('pagination::bootstrap-5') }}
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
                text: "You want to delete this category!",
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