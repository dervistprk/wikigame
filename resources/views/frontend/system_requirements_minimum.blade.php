<div class="card game-info">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>
                        <img src="{{asset('assets/sys_req_icons/cpu.png')}}" class="img-fluid" alt="cpu_min" width="25"
                             height="25"> {{ __('İşlemci') }}
                    </th>
                    <td>{{ $game->systemReqMin->cpu_min }}</td>
                </tr>
                <tr>
                    <th>
                        <img src="{{asset('assets/sys_req_icons/gpu.png')}}" alt="gpu_min" width="25"
                             height="25"> {{ __('Ekran Kartı') }}
                    </th>
                    <td>{{ $game->systemReqMin->gpu_min }}</td>
                </tr>
                <tr>
                    <th>
                        <img src="{{asset('assets/sys_req_icons/ram.png')}}" alt="ram_min" width="25"
                             height="25"> {{ __('Bellek') }}
                    </th>
                    <td>{{ $game->systemReqMin->ram_min }} @if($game->systemReqMin->ram_min_unit == 0)
                            MB
                        @else
                            GB
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        <img src="{{asset('assets/sys_req_icons/storage.png')}}" alt="storage_min" width="25"
                             height="25"> {{ __('Depolama Alanı') }}
                    </th>
                    <td>{{ $game->systemReqMin->storage_min }} @if($game->systemReqMin->storage_min_unit == 0)
                            MB
                        @else
                            GB
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>
                        <img src="{{asset('assets/sys_req_icons/os.png')}}" alt="os_min" width="25"
                             height="25"> {{ __('İşletim Sistemi') }}
                    </th>
                    <td>{{ $game->systemReqMin->os_min }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
