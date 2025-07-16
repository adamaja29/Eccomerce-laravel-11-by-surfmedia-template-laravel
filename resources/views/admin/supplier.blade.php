@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Supplier</h3>
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
                    <div class="text-tiny">Supplier</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.create.supplier')}}"><i
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
                                <th>Nama Supplier</th>
                                <th>email</th>
                                <th>kontak</th>
                                <th>Alamat</th>
                                <th>Nama Bank</th>
                                <th>Nomor Rekening</th>
                                <th>Atas Nama</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                
                            </tr>
                            <?php
                $no = 1;
                foreach($suppliers as $supplier) {
                ?>
                        </thead>
                        <tbody>  
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$supplier->nama}}</td>
                                <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $supplier->email }}">
                                    {{ $supplier->email }}
                                </td>
                                <td>{{$supplier->kontak}}</td>
                                <td>{{$supplier->alamat}}</td>
                                <td>{{$supplier->nama_bank}}</td>
                                <td>{{$supplier->nomor_bank}}</td>
                                <td>{{$supplier->atas_nama}}</td>
                                <td>{{ $supplier->status}}</td>
                                <td>
                                    <div class="list-icon-function">
                                    <a href="{{route('edit.supplier', ['id' => $supplier->id])}}" class="item edit">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{route('delete.supplier', ['id' => $supplier->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="item text-danger delete">
                                            <i class="icon-trash-2"></i>
                                        </button>
                                    </form>
                            </tr>
                            
                            <?php
                }
                ?>
                        </tbody>
                        
                    </table>
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
                text: "You want to delete this Supplier!",
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
        
</script>
@endpush
