@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Kategori infomasi</h3>
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
                        <div class="text-tiny">Kategori</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">New Kategori</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form" method="POST" enctype="multipart/form-data" action="{{ route('admin.pembelian.store') }}">
                @csrf
                <div class="wg-box">
                    <div class="gap22 cols">
                        <fieldset class="supplier">
                            <div class="body-title mb-10">supplier <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="supplier_id" id="supplier-select">
                                    <option value="">Pilih supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" @if(isset($supplier_id) && $supplier_id == $supplier->id) selected @endif>{{ $supplier->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                    </div>

                    <div id="produk-container">
                        <div class="produk-entry">
                            <fieldset class="produk">
                                <div class="body-title mb-10">Produk <span class="tf-color-1">*</span></div>
                                <div class="select">
                                    <select name="produk_id[]" class="produk-select" required>
                                        <option value="">Pilih produk</option>
                                        @foreach($produks as $produk)
                                            <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                            @error('produk_id.*') 
                                <span class="alert alert-danger text-center">{{ $message }}</span> 
                            @enderror

                            <fieldset class="jumlah">
                                <div class="body-title mb-10">Jumlah <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="number" placeholder="Enter produk jumlah" name="jumlah[]" value="{{ old('jumlah.0') }}" required>
                                <div class="text-tiny"></div>
                            </fieldset>
                            @error('jumlah.*') 
                                <span class="alert alert-danger text-center">{{ $message }}</span> 
                            @enderror

                            <div class="cols gap22">
                                <fieldset class="name">
                                    <div class="body-title mb-10">Harga Beli<span class="tf-color-1">*</span></div>
                                    <input class="mb-10" type="number" placeholder="Enter Harga" name="harga_beli[]" value="{{ old('harga_beli.0') }}" required>
                                </fieldset>
                                @error('harga_beli.*') 
                                    <span class="alert alert-danger text-center">{{ $message }}</span> 
                                @enderror
                            </div>
                            <button type="button" class="remove-produk tf-button">Remove Produk</button>
                        </div>
                    </div>

                    <button type="button" id="add-produk" class="tf-button">Add Produk</button>

                    <fieldset class="tanggal">
                        <div class="body-title mb-10">Tanggal Pembelian <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="date" name="tanggal_pembelian" value="{{ old('tanggal_pembelian') }}" required>
                    </fieldset>
                    @error('tanggal_pembelian') 
                        <span class="alert alert-danger text-center">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Add produk</button>
                </div>
            </form>
            <script>
                document.getElementById('supplier-select').addEventListener('change', function() {
                    var supplierId = this.value;
                    var url = new URL(window.location.href);
                    if (supplierId) {
                        url.searchParams.set('supplier_id', supplierId);
                        url.searchParams.delete('produk_id');
                    } else {
                        url.searchParams.delete('supplier_id');
                    }
                    window.location.href = url.toString();
                });

                document.getElementById('produk-container').addEventListener('click', function(e) {
                    if (e.target && e.target.classList.contains('remove-produk')) {
                        e.target.closest('.produk-entry').remove();
                    }
                });

                document.getElementById('add-produk').addEventListener('click', function() {
                    var container = document.getElementById('produk-container');
                    var index = container.querySelectorAll('.produk-entry').length;
                    var newEntry = document.createElement('div');
                    newEntry.classList.add('produk-entry');
                    newEntry.innerHTML = `
                        <fieldset class="produk">
                            <div class="body-title mb-10">Produk <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="produk_id[]" class="produk-select" required>
                                    <option value="">Pilih produk</option>
                                    @foreach($produks as $produk)
                                        <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="jumlah">
                            <div class="body-title mb-10">Jumlah <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="number" placeholder="Enter produk jumlah" name="jumlah[]" required>
                        </fieldset>
                        <fieldset class="cols gap22">
                            <fieldset class="name">
                                <div class="body-title mb-10">Harga Beli<span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="number" placeholder="Enter Harga" name="harga_beli[]" required>
                            </fieldset>
                            </fieldset>
                        </fieldset>
                        <button type="button" class="remove-produk tf-button">Remove Produk</button>
                    `;
                    container.appendChild(newEntry);
                });
            </script>
        </div>
    </div>
</div>

<script>
    document.getElementById('supplier-select').addEventListener('change', function() {
        var supplierId = this.value;
        var url = new URL(window.location.href);
        if (supplierId) {
            url.searchParams.set('supplier_id', supplierId);
            url.searchParams.delete('produk_id');
        } else {
            url.searchParams.delete('supplier_id');
        }
        window.location.href = url.toString();
    });

    document.getElementById('produk-select').addEventListener('change', function() {
        var produkId = this.value;
        var url = new URL(window.location.href);
        if (produkId) {
            url.searchParams.set('produk_id', produkId);
            url.searchParams.delete('supplier_id');
        } else {
            url.searchParams.delete('produk_id');
        }
        window.location.href = url.toString();
    });
</script>

@endsection
