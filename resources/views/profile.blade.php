@extends('layout.anggotaLayouts.main')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
        <!-- Your Page Content Goes Here-->
        <div class="page-content header-clear-medium">

            <div class="card card-style">
                <form>
                    <div class="content mb-0">
                        <h6 class="font-700 mb-n1 color-highlight">Pengaturan Akun</h6>
                        <h1 class="pb-2">Profil</h1>  
                        <div class="file-data">
                            <img id="image-data" src="{{asset('anggotatemplate/images/pictures/23.jpg')}}" class="img-fluid rounded-s" alt="img">
                            <span class="upload-file-name d-block text-center"
                                  data-text-before="<i class='bi bi-check-circle-fill color-green-dark pe-2'></i> Image:"
                                  data-text-after=" is ready.">
                            </span>
                            <div>
                                <input type="file" class="upload-file" accept="image/*">
                                <p class="btn btn-full btn-m text-uppercase font-700 font-11 rounded-s upload-file-text shadow-0 color-black">Ubah foto profil</p>
                            </div>
                        </div>
        
                        <div class="divider"></div>
        
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-person-circle font-14"></i>
                            <input type="text" class="form-control rounded-xs" id="c1" placeholder="Nama" value="{{ Auth::user()->name }}"/>
                            <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Nama</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-at font-16"></i>
                            <input type="email" class="form-control rounded-xs" id="c1" placeholder="Email" value="{{ Auth::user()->email }}"/>
                            <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Email</label>
                            <span>(required)</span>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-star font-16"></i>
                            <select class="form-select rounded-xs" id="c1" name="agama">
                                <option value="Islam" {{ Auth::user()->agama == "Islam" ? "selected" : "" }}>Islam</option>
                                <option value="Kristen" {{ Auth::user()->agama == "Kristen" ? "selected" : "" }}>Kristen</option>
                                <option value="Katholik" {{ Auth::user()->agama == "Katholik" ? "selected" : "" }}>Katholik</option>
                                <option value="Hindu" {{ Auth::user()->agama == "Hindu" ? "selected" : "" }}>Hindu</option>
                                <option value="Budha" {{ Auth::user()->agama == "Budha" ? "selected" : "" }}>Budha</option>
                                <option value="Khonghucu" {{ Auth::user()->agama == "Khonghucu" ? "selected" : "" }}>Khonghucu</option>
                                <option value="Lainya" {{ Auth::user()->agama == "Lainya" ? "selected" : "" }}>Lainya</option>
                            </select>
                            <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Agama</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-person-fill font-16"></i>
                            <select class="form-select select2" name="pekerjaan_id">
                                @foreach ($kerja as $krj)
                                  <option value="{{ $krj->id }}" {{ Auth::user()->pekerjaan_id == $krj->id ? 'selected' : '' }}>{{ $krj->nama }}</option>
                                @endforeach
                              </select>
                            <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Pekerjaan</label>
                          </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-phone font-16"></i>
                            <input type="text" class="form-control rounded-xs" id="c1" placeholder="No Telephone" value="{{ Auth::user()->no_hp }}"/>
                            <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Phone</label>
                            <span>(required)</span>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-alt font-16"></i>
                            <input type="text" class="form-control rounded-xs" id="c1" placeholder="Alamat" value="{{ Auth::user()->alamat }}"/>
                            <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Address</label>
                            <span>(required)</span>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-person font-16"></i>
                            <select class="form-control rounded-xs" name="gender" id="gender">
                                <option value="">- Pilih Gender -</option>
                                <option value="Laki-laki" {{ Auth::user()->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ Auth::user()->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <label for="gender" class="color-theme form-label-always-active font-10 opacity-50">Jenis Kelamin</label>
                            <span>(required)</span>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-geo-alt font-16"></i>
                            <input type="text" class="form-control rounded-xs" id="c1" placeholder="Tempat Lahir" value="{{ Auth::user()->tempat_lahir }}"/>
                            <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Tempat Lahir</label>
                            <span>(required)</span>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-calendar2-event font-16"></i>
                            <input type="date" class="form-control rounded-xs" id="c1" placeholder="Tanggal Lahir" value="{{ \Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->format('Y-m-d') }}" />
                            <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Tanggal Lahir</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-book font-16"></i>
                            <select class="form-select rounded-xs" id="c2" name="pendidikan">
                                <option value="Tidak/Belum Sekolah" {{ Auth::user()->pendidikan == "Tidak/Belum Sekolah" ? "selected" : "" }}>Tidak/Belum Sekolah</option>
                                <option value="Belum Tamat SD/Sederajat" {{ Auth::user()->pendidikan == "Belum Tamat SD/Sederajat" ? "selected" : "" }}>Belum Tamat SD/Sederajat</option>
                                <option value="Tamat SD/Sederajat" {{ Auth::user()->pendidikan == "Tamat SD/Sederajat" ? "selected" : "" }}>Tamat SD/Sederajat</option>
                                <option value="SLTP/Sederajat" {{ Auth::user()->pendidikan == "SLTP/Sederajat" ? "selected" : "" }}>SLTP/Sederajat</option>
                                <option value="SLTA/Sederajat" {{ Auth::user()->pendidikan == "SLTA/Sederajat" ? "selected" : "" }}>SLTA/Sederajat</option>
                                <option value="Diploma I/II" {{ Auth::user()->pendidikan == "Diploma I/II" ? "selected" : "" }}>Diploma I/II</option>
                                <option value="Akademi/Diploma III/S. muda" {{ Auth::user()->pendidikan == "Akademi/Diploma III/S. muda" ? "selected" : "" }}>Akademi/Diploma III/S. muda</option>
                                <option value="Diploma IV/Strata I" {{ Auth::user()->pendidikan == "Diploma IV/Strata I" ? "selected" : "" }}>Diploma IV/Strata I</option>
                                <option value="Strata II" {{ Auth::user()->pendidikan == "Strata II" ? "selected" : "" }}>Strata II</option>
                                <option value="Strata III" {{ Auth::user()->pendidikan == "Strata III" ? "selected" : "" }}>Strata III</option>
                            </select>
                            <label for="c2" class="color-theme form-label-always-active font-10 opacity-50">Pendidikan</label>
                        </div>
                        <div class="form-custom form-label form-icon mb-3">
                            <i class="bi bi-at font-16"></i>
                            <input type="password" class="form-control rounded-xs" id="c1" placeholder="********" value="{{ substr(Auth::user()->password, 0, 8) . '...' }}"/>
                            <label for="c1" class="color-theme form-label-always-active font-10 opacity-50">Password</label>
                            <span>(required)</span>
                        </div>
                    </div>
                    <a href="#" class="btn mx-3 mb-4 btn-full btn-margins gradient-blue shadow-bg shadow-bg-s rounded-s btn-m text-uppercase font-900">Save Information</a>
                </form>
            </div>
    
        </div>
        <!-- End of Page Content-->
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
           $('.select2').select2();
           placeholder: "Select a pekerjaan",
            allowClear: true
        });
     </script>
@endpush