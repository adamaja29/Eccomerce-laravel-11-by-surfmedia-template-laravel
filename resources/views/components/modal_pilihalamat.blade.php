<!-- resources/views/components/modal-pilih-alamat.blade.php -->

<div class="modal fade" id="modalPilihAlamat" tabindex="-1" role="dialog" aria-labelledby="modalPilihAlamatLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pilih Alamat Pengiriman</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @foreach($semuaAlamat as $alamat)
            <div class="card mb-2 {{ $alamatAktif && $alamatAktif->id == $alamat->id ? 'border-primary' : '' }}">
              <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                  <strong>{{ $alamat->nama_penerima }}</strong><br>
                  {{ $alamat->phone }}<br>
                  {{ $alamat->provinsi }}, {{ $alamat->kota }}, {{ $alamat->kecamatan }}<br>
                  {{ $alamat->full_address }}
                </div>
                <form method="POST" action="{{ route('user.alamat.pilih') }}">
                  @csrf
                  <input type="hidden" name="address_id" value="{{ $alamat->id }}">
                  <button type="submit" class="btn btn-sm btn-primary">Pilih</button>
                </form>
              </div>
            </div>
          @endforeach

          <button type="button" class="btn btn-outline-primary" data-target="#modalTambahAlamat" id="btnTambahAlamat">
            Tambah Alamat Baru
        </button>
        
        </div>
      </div>
    </div>
  </div>
  @include('components.modal-tambah-alamat')
  
  