<div class="modal fade" id="modalTambahAlamat" tabindex="-1" role="dialog" aria-labelledby="modalTambahAlamatLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Alamat Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup" onclick="$('#modalTambahAlamat').modal('hide');">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('user.alamat.store') }}">
          @csrf
          <div class="form-group">
            <label for="namaPenerima">Nama Penerima</label>
            <input type="text" name="nama_penerima" class="form-control" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="phone">No. HP</label>
            <input type="number"  name="phone" class="form-control" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="provinsi">Provinsi</label>
            <input type="text"  name="provinsi" class="form-control" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="kota">Kota</label>
            <input type="text"  name="kota" class="form-control" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <input type="text" " name="kecamatan" class="form-control" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label for="fullAddress">Alamat Lengkap</label>
            <textarea  name="full_address" class="form-control" rows="3" autocomplete="off" required></textarea>
          </div>

          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Simpan Alamat</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
