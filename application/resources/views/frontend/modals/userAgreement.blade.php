<div class="modal fade" id="user-agreement-modal" tabindex="-1" aria-labelledby="user-agreement-modal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-body" id="user-agreement-modal">{{ __('Site Kuralları') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-body">
                <p>
                    {!! trans('messages.user_agreement_top_text') !!}
                </p>
                <hr>
                <ul>
                    <li>{{ __('E-posta adresimin site veritabanı tarafından kaydedilmesini kabul ediyorum.') }}</li>
                    <li>{{ __('Doğum tarihi, cinsiyet gibi özel bilgilerimin kaydedilmesini kabul ediyorum.') }}</li>
                    <li>{{ __('Küfür, argo vb. kötü sözleri kullanmayacağımı kabul ediyorum.') }}</li>
                    <li>{{ __('Moderatörlerle tartışmaya girmeyeceğimi, hakkımda verdikleri kararlara saygı duyacağımı kabul ediyorum.') }}</li>
                    <li>{{ __('Diğer kullanıcılara saygısızlık yapmayacağımı kabul ediyorum.') }}</li>
                    <li>{{ __('Diğer kullanıcılarla din, siyaset, ırkçılık gibi konularda tartışma çıkarmayacağımı kabul ediyorum.') }}</li>
                    <li>{{ __('Özel oyun haberleri gibi önemli gelişmelerde Wikigame\'den e-posta almak istediğimi kabul ediyorum.') }}</li>
                </ul>
                <hr>
                <p>
                    {!! trans('messages.user_agreement_bottom_text') !!}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Kapat') }}</button>
            </div>
        </div>
    </div>
</div>
