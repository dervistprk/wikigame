<div class="card game-info">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>
                        <img src="{{asset('assets/sys_req_icons/cpu.png')}}" class="img-fluid" alt="cpu_min" width="25" height="25"> İşlemci
                    </th>
                    <td>{{ $game->systemReqRec->cpu_rec }}</td>
                </tr>
                <tr>
                    <th>
                        <img src="{{asset('assets/sys_req_icons/gpu.png')}}" alt="gpu_min" width="25" height="25"> Ekran Kartı
                    </th>
                    <td>{{ $game->systemReqRec->gpu_rec }}</td>
                </tr>
                <tr>
                    <th>
                        <img src="{{asset('assets/sys_req_icons/ram.png')}}" alt="ram_min" width="25" height="25"> Bellek
                    </th>
                    <td>{{ $game->systemReqRec->ram_rec }} @if($game->systemReqRec->ram_rec_unit == 0)
                            MB
                        @else
                            GB
                        @endif</td>
                </tr>
                <tr>
                    <th>
                        <img src="{{asset('assets/sys_req_icons/storage.png')}}" alt="storage_min" width="25" height="25"> Depolama Alanı
                    </th>
                    <td>{{ $game->systemReqRec->storage_rec }} @if($game->systemReqRec->storage_rec_unit == 0)
                            MB
                        @else
                            GB
                        @endif</td>
                </tr>
                <tr>
                    <th>
                        <img src="{{asset('assets/sys_req_icons/os.png')}}" alt="os_min" width="25" height="25"> İşletim Sistemi
                    </th>
                    <td>{{ $game->systemReqRec->os_rec }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
