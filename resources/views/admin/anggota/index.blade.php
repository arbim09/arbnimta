@extends('layout.backend.app',[
    'title' => 'Manage Anggota',
    'pageTitle' =>'Manage Anggota',
])

@push('css')
<link href="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endpush

@section('content')

<div class="card">
    <div class="card-header">
        <!-- Button trigger modal -->
       <a href="{{route('anggota.create')}}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Tambah Data">
        <i class="fas fa-plus mr-1"></i> Tambah Baru
    </a>
    </div>
        <div class="card-body">
            <div class="table-responsive">    
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
</div>
<!-- Destroy Modal -->
<div class="modal fade" id="destroy-modal" tabindex="-1" role="dialog" aria-labelledby="destroy-modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="destroy-modalLabel">Yakin Hapus ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger btn-destroy">Hapus</button>
      </div>
    </div>
  </div>
</div>
<!-- Destroy Modal -->

@stop

@push('js')
<script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('template/backend/sb-admin-2') }}/js/demo/datatables-demo.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script type="text/javascript">

  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
				"url": "{{route('anggota.index')}}",
				"type": "GET" //(untuk mendapatkan data)
			},
        columns: [
            {data: 'DT_RowIndex' , name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'alamat', name: 'alamat'},
            {data: 'action', name: 'action', orderable: false, searchable: true},
        ]
    });
  });

  

  //form hapus
  
</script>

<script>
  function deleteData(id) {
      swal({
          title: "Anda yakin ingin menghapus data ini?",
          type: "warning",
          timer: 10000,
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, hapus data!",
          cancelButtonText: "Batal",
          closeOnConfirm: false
      }, function () {
          $.ajax({
              type: "DELETE",
              url: "{{ route('anggota.destroy', ':id') }}".replace(':id', id),
              data: {
                  "_token": "{{ csrf_token() }}"
              },
              success: function (data) {
                  console.log(data);
                  swal("Berhasil!", "Data telah dihapus.", "success");
                  location.reload(); // Redirect ke halaman index setelah data berhasil dihapus
              },
              error: function (data) {
                  console.log('Error:', data);
                  swal("Oops!", "Terjadi kesalahan saat menghapus data.", "error");
              }
          });
      });
  }
  </script>

@endpush