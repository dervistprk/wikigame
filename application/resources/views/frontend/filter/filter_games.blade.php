<form method="get" action="{{ route('all-games') }}">
    <div class="d-sm-flex">
        <div class="me-sm-2 w-25 filter mt-2">
            <div id="filter" class="p-2 bg-light ms-sm-2 border">
                <div class="border-bottom h4 text-uppercase">{{ __('Filtreleme') }}</div>
                <div class="box border-bottom">
                    <div class="box-label text-uppercase d-flex align-items-center h6">{{ __('Kategori') }}
                        <button class="btn ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#categories"
                                aria-expanded="false" aria-controls="categories">
                            <span class="fas fa-plus filter-wrapper"></span>
                        </button>
                    </div>
                    <div id="categories" class="collapse @if(Request::has('categories')) show @endif">
                        <div class="my-1">
                            @foreach($categories as $category)
                                <label class="form-label d-block filter-fields">{{ $category->name }}
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                           @if(Request::has('categories'))
                                               @if(in_array($category->id, (array)Request::get('categories'))) checked @endif
                                           @endif class="float-end">
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="box border-bottom">
                    <div class="box-label text-uppercase d-flex align-items-center h6">{{ __('Tür') }}
                        <button class="btn ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#genres"
                                aria-expanded="false" aria-controls="genres">
                            <span class="fas fa-plus filter-wrapper"></span>
                        </button>
                    </div>
                    <div id="genres" class="collapse @if(Request::has('genres')) show @endif">
                        <div class="my-1">
                            @foreach($genres as $genre)
                                <label class="form-label d-block filter-fields">{{ $genre->name }} <input
                                            type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                            @if(Request::has('genres'))
                                                @if(in_array($genre->id, (array)Request::get('genres'))) checked @endif
                                            @endif class="float-end">
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="box border-bottom">
                    <div class="box-label text-uppercase d-flex align-items-center h6">{{ __('Platform') }}
                        <button class="btn ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#platforms"
                                aria-expanded="false" aria-controls="platforms">
                            <span class="fas fa-plus filter-wrapper"></span>
                        </button>
                    </div>
                    <div id="platforms" class="collapse @if(Request::has('platforms')) show @endif">
                        <div class="my-1">
                            @foreach($platforms as $platform)
                                <label class="form-label d-block filter-fields">{{ $platform->name }} <input
                                            type="checkbox" name="platforms[]" value="{{ $platform->id }}"
                                            @if(Request::has('platforms'))
                                                @if(in_array($platform->id, (array)Request::get('platforms'))) checked @endif
                                            @endif class="float-end">
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="box border-bottom">
                    <div class="box-label text-uppercase d-flex align-items-center h6">{{ __('Geliştiriciler') }}
                        <button class="btn ms-auto" type="button" data-bs-toggle="collapse"
                                data-bs-target="#developers" aria-expanded="false" aria-controls="developers">
                            <span class="fas fa-plus filter-wrapper"></span>
                        </button>
                    </div>
                    <div id="developers" class="collapse @if(Request::has('developers')) show @endif">
                        <div class="my-1">
                            @foreach($developers as $developer)
                                <label class="form-label d-block filter-fields">{{ $developer->name }} <input
                                            type="checkbox" name="developers[]" value="{{ $developer->id }}"
                                            @if(Request::has('developers'))
                                                @if(in_array($developer->id, (array)Request::get('developers'))) checked @endif
                                            @endif class="float-end">
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-label text-uppercase d-flex align-items-center h6">{{ __('Dağıtıcılar') }}
                        <button class="btn ms-auto" type="button" data-bs-toggle="collapse"
                                data-bs-target="#publishers" aria-expanded="false" aria-controls="publishers">
                            <span class="fas fa-plus filter-wrapper"></span>
                        </button>
                    </div>
                    <div id="publishers" class="collapse @if(Request::has('publishers')) show @endif">
                        <div class="my-1">
                            @foreach($publishers as $publisher)
                                <label class="form-label d-block filter-fields">{{ $publisher->name }} <input
                                            type="checkbox" name="publishers[]" value="{{ $publisher->id }}"
                                            @if(Request::has('publishers'))
                                                @if(in_array($publisher->id, (array)Request::get('publishers'))) checked @endif
                                            @endif class="float-end">
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <button class="btn btn-sm btn-warning text-uppercase fw-bold"
                            type="submit">{{ __('Filtrele') }}
                    </button>
                    <a class="btn btn-sm btn-secondary text-uppercase fw-bold m-2 disabled" id="clear-btn" href="{{ route('all-games') }}">
                        {{ __('Temizle') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@section('custom-css')
    <style>
        .filter-fields {
            cursor : pointer;
        }

        .filter-fields:hover {
            transition : 0.3s;
            color      : #ff8c00ff;
        }
    </style>
@endsection