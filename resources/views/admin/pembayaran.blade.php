@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Metode Pembayaran</h3>
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
                    <div class="text-tiny">Metode Pembayaran</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.create.metode')}}"><i
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
                                <th>name</th>
                                <th>description</th>
                                <th>images</th>
                                <th>Status</th>
                                <th>Aksi</th>
                                
                            </tr>
                            <?php
                $no = 1;
                foreach($metode as $metod) {
                ?>
                        </thead>
                        <tbody>  
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$metod->nama}}</td>
                                <td>{{$metod->deskripsi}}</td>
                                <td><img src="{{ asset('uploads/pembayaran/' . $metod->image) }}" ></td>
                                <td>{{ $metod->status == 1 ? 'Aktif' : 'Off' }}</td>
                                <td>
                                    <div class="list-icon-function">
                                    <a href="{{route('edit.metode', ['id' => $metod->id])}}" class="item edit">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{route('delete.metode', ['id' => $metod->id])}}" method="POST">
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
                text: "You want to delete this Metode!",
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
