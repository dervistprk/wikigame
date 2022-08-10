<div class="card">
    <div class="card-body">
        <table class="table table-responsive table-bordered">
            <tbody>
            <tr>
                <th><img src="{{asset('assets/sys_req_icons/cpu.png')}}" class="img-fluid" alt="cpu_min" width="25" height="25"> İşlemci</th>
                <td>{{ $system_req_rec->cpu }}</td>
            </tr>
            <tr>
                <th><img src="{{asset('assets/sys_req_icons/gpu.png')}}" alt="gpu_min" width="25" height="25"> Ekran Kartı</th>
                <td>{{ $system_req_rec->gpu }}</td>
            </tr>
            <tr>
                <th><img src="{{asset('assets/sys_req_icons/ram.png')}}" alt="ram_min" width="25" height="25"> Bellek</th>
                <td>{{ $system_req_rec->ram }} @if($system_req_rec->ram_unit == 0) MB @else GB @endif</td>
            </tr>
            <tr>
                <th><img src="{{asset('assets/sys_req_icons/storage.png')}}" alt="storage_min" width="25" height="25"> Depolama Alanı</th>
                <td>{{ $system_req_rec->storage }} @if($system_req_rec->storage_unit == 0) MB @else GB @endif</td>
            </tr>
            <tr>
                <th><img src="{{asset('assets/sys_req_icons/os.png')}}" alt="os_min" width="25" height="25"> İşletim Sistemi</th>
                <td>{{ $system_req_rec->os }}</td>
            </tr>
            </tbody>
        </table>

    </div>
</div>
