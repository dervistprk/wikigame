<div class="modal fade" id="detailedSearch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detaylı Arama</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.games') }}" method="get" id="detailed-search-form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name_query" class="col-form-label font-weight-bold">Adı</label>
                                <input type="text" class="form-control" name="name_query" id="name_query"
                                       value="{{ $name_query ?? null }}" placeholder="Oyun Adı Girin">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="status_query" class="col-form-label font-weight-bold">Durum</label>
                                <select class="form-select" name="status_query" id="status_query">
                                    <option value="" selected hidden>Durum Seçin</option>
                                    <option value="0" @if(isset($status_query) && $status_query == 0) selected @endif>
                                        Pasif
                                    </option>
                                    <option value="1" @if(isset($status_query) && $status_query == 1) selected @endif>
                                        Aktif
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="id_query" class="col-form-label font-weight-bold">ID</label>
                                <input type="number" class="form-control" name="id_query" id="id_query"
                                       value="{{ $id_query ?? null }}" placeholder="Oyun ID'si Girin">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="category_query" class="col-form-label font-weight-bold">Kategori</label>
                                <select class="form-select select2" name="category_query" id="category_query">
                                    <option value="" selected hidden>Kategori Seçin</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @if($category_query == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="developer_query" class="col-form-label font-weight-bold">Geliştirici</label>
                                <select class="form-select select2" name="developer_query" id="developer_query">
                                    <option selected hidden value="">Geliştirici Seçin</option>
                                    @foreach($developers as $developer)
                                        <option value="{{ $developer->id }}"
                                                @if($developer_query == $developer->id) selected @endif>
                                            {{ $developer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="publisher_query" class="col-form-label font-weight-bold">Dağıtıcı</label>
                                <select class="form-select select2" name="publisher_query" id="publisher_query">
                                    <option value="" selected hidden>Dağıtıcı Seçin</option>
                                    @foreach($publishers as $publisher)
                                        <option value="{{ $publisher->id }}"
                                                @if($publisher_query == $publisher->id) selected @endif>
                                            {{ $publisher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="platform_query" class="col-form-label font-weight-bold">Platform</label>
                                <select class="form-select select2" name="platform_query[]" id="platform_query"
                                        multiple="multiple">
                                    @foreach($platforms as $platform)
                                        <option value="{{ $platform->id }}"
                                                @if(isset($platform_query)) @if(in_array($platform->id, $platform_query)) selected @endif @endif>
                                            {{ $platform->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="genre_query" class="col-form-label font-weight-bold">Tür</label>
                                <select class="form-select select2" name="genre_query[]" id="genre_query"
                                        multiple="multiple">
                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id }}"
                                                @if(isset($genre_query)) @if(in_array($genre->id, $genre_query)) selected @endif @endif>
                                            {{ $genre->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="release_date_max_query"
                                       class="col-form-label font-weight-bold">Çıkış Tarihi En Fazla</label>
                                <input type="text" value="{{ $release_date_max_query }}" name="release_date_max_query"
                                       id="release_date_max_query" class="form-control date-picker"
                                       placeholder="Tarih Seçin">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="release_date_min_query"
                                       class="col-form-label font-weight-bold">Çıkış Tarihi En Az</label>
                                <input type="text" value="{{ $release_date_min_query }}" name="release_date_min_query"
                                       id="release_date_min_query" class="form-control date-picker"
                                       placeholder="Tarih Seçin">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <button type="submit" id="detailed-search-submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Ara
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
