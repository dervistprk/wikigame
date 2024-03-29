<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Doğrulama Mesajları
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki öğeler doğrulama sınıfı tarafından kullanılan varsayılan hata
    | mesajlarını içermektedir. `size` gibi bazı kuralların birden çok çeşidi
    | bulunmaktadır. Her biri ayrı ayrı düzenlenebilir.
    |
    */

    'accepted'             => ':attribute kabul edilmelidir.',
    'active_url'           => ':attribute geçerli bir URL olmalıdır.',
    'after'                => ':attribute değeri :date tarihinden sonra olmalıdır.',
    'after_or_equal'       => ':attribute değeri :date tarihinden sonra veya eşit olmalıdır.',
    'alpha'                => ':attribute sadece harflerden oluşmalıdır.',
    'alpha_dash'           => ':attribute sadece harfler, rakamlar ve tirelerden oluşmalıdır.',
    'alpha_num'            => ':attribute sadece harfler ve rakamlar içermelidir.',
    'array'                => ':attribute dizi olmalıdır.',
    'before'               => ':attribute değeri :date tarihinden önce olmalıdır.',
    'before_or_equal'      => ':attribute değeri :date tarihinden önce veya eşit olmalıdır.',
    'between'              => [
        'numeric' => ':attribute :min - :max arasında olmalıdır.',
        'file'    => ':attribute :min - :max arasındaki kilobayt değeri olmalıdır.',
        'string'  => ':attribute :min - :max arasında karakterden oluşmalıdır.',
        'array'   => ':attribute :min - :max arasında nesneye sahip olmalıdır.',
    ],
    'boolean'              => ':attribute sadece doğru veya yanlış olmalıdır.',
    'confirmed'            => ':attribute tekrarı eşleşmiyor.',
    'date'                 => ':attribute geçerli bir tarih olmalıdır.',
    'date_equals'          => ':attribute ile :date aynı tarihler olmalıdır.',
    'date_format'          => ':attribute :format biçimi ile eşleşmiyor.',
    'declined'             => ':attribute alanı reddedilmelidir.',
    'declined_if'          => ':attribute alanı, :other alanı :value değerine sahipken reddedilmelidir.',
    'different'            => ':attribute ile :other birbirinden farklı olmalıdır.',
    'digits'               => ':attribute :digits haneden oluşmalıdır.',
    'digits_between'       => ':attribute :min ile :max arasında haneden oluşmalıdır.',
    'dimensions'           => ':attribute görsel ölçüleri geçersiz.',
    'distinct'             => ':attribute alanı yinelenen bir değere sahip.',
    'email'                => ':attribute alanına girilen e-posta adresi geçersiz.',
    'ends_with'            => ':attribute, şunlardan biriyle bitmelidir :values',
    'exists'               => 'Seçili :attribute geçersiz.',
    'file'                 => ':attribute dosya olmalıdır.',
    'filled'               => ':attribute alanının doldurulması zorunludur.',
    'gt'                   => [
        'numeric' => ':attribute, :value değerinden büyük olmalı.',
        'file'    => ':attribute, :value kilobayt boyutundan büyük olmalı.',
        'string'  => ':attribute, :value karakterden uzun olmalı.',
        'array'   => ':attribute, :value taneden fazla olmalı.',
    ],
    'gte'                  => [
        'numeric' => ':attribute, :value kadar veya daha fazla olmalı.',
        'file'    => ':attribute, :value kilobayt boyutu kadar veya daha büyük olmalı.',
        'string'  => ':attribute, :value karakter kadar veya daha uzun olmalı.',
        'array'   => ':attribute, :value tane veya daha fazla olmalı.',
    ],
    'image'                => ':attribute alanı resim dosyası olmalıdır.',
    'in'                   => ':attribute değeri geçersiz.',
    'in_array'             => ':attribute alanı :other içinde mevcut değil.',
    'integer'              => ':attribute tamsayı olmalıdır.',
    'ip'                   => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4'                 => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6'                 => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json'                 => ':attribute geçerli bir JSON değişkeni olmalıdır.',
    'lt'                   => [
        'numeric' => ':attribute, :value değerinden küçük olmalı.',
        'file'    => ':attribute, :value kilobayt boyutundan küçük olmalı.',
        'string'  => ':attribute, :value karakterden kısa olmalı.',
        'array'   => ':attribute, :value taneden az olmalı.',
    ],
    'lte'                  => [
        'numeric' => ':attribute, :value kadar veya daha küçük olmalı.',
        'file'    => ':attribute, :value kilobayt boyutu kadar veya daha küçük olmalı.',
        'string'  => ':attribute, :value karakter kadar veya daha kısa olmalı.',
        'array'   => ':attribute, :value tane veya daha az olmalı.',
    ],
    'max'                  => [
        'numeric' => ':attribute değeri :max değerinden küçük olmalıdır.',
        'file'    => ':attribute değeri :max kilobayt değerinden küçük olmalıdır.',
        'string'  => ':attribute değeri :max karakterden küçük olmalıdır.',
        'array'   => ':attribute değeri :max adedinden az nesneye sahip olmalıdır.',
    ],
    'mimes'                => ':attribute dosya biçimi :values olmalıdır.',
    'mimetypes'            => ':attribute dosya biçimi :values olmalıdır.',
    'min'                  => [
        'numeric' => ':attribute değeri :min değerinden büyük olmalıdır.',
        'file'    => ':attribute değeri :min kilobayt değerinden büyük olmalıdır.',
        'string'  => ':attribute değeri :min karakterden büyük olmalıdır.',
        'array'   => ':attribute en az :min nesneye sahip olmalıdır.',
    ],
    'multiple_of'          => ':attribute :value değerinin katsayısı olmalıdır.',
    'not_in'               => 'Seçili :attribute geçersiz.',
    'not_regex'            => ':attribute biçimi geçersiz.',
    'numeric'              => ':attribute sayı olmalıdır.',
    'password'             => 'Parola geçersiz.',
    'present'              => ':attribute alanı mevcut olmalıdır.',
    'regex'                => ':attribute biçimi geçersiz.',
    'required'             => ':attribute alanı gereklidir.',
    'required_if'          => ':attribute alanı, :other :value değerine sahip olduğunda zorunludur.',
    'required_unless'      => ':attribute alanı, :other alanı :value değerlerinden birine sahip olmadığında zorunludur.',
    'required_with'        => ':attribute alanı :values varken zorunludur.',
    'required_with_all'    => ':attribute alanı herhangi bir :values değeri varken zorunludur.',
    'required_without'     => ':attribute alanı :values yokken zorunludur.',
    'required_without_all' => ':attribute alanı :values değerlerinden herhangi biri yokken zorunludur.',
    'prohibited'           => ':attribute alanının doldurulması yasak.',
    'prohibited_if'        => ':other alanı :value değerine sahipken :attribute alanının doldurulması yasak.',
    'prohibited_unless'    => ':other alanı :values değerine sahip değilken :attribute alanının doldurulması yasak.',
    'same'                 => ':attribute ile :other eşleşmelidir.',
    'size'                 => [
        'numeric' => ':attribute :size olmalıdır.',
        'file'    => ':attribute :size kilobyte olmalıdır.',
        'string'  => ':attribute :size karakter olmalıdır.',
        'array'   => ':attribute :size nesneye sahip olmalıdır.',
    ],
    'starts_with'          => ':attribute şunlardan biri ile başlamalıdır: :values',
    'string'               => ':attribute dizge olmalıdır.',
    'timezone'             => ':attribute geçerli bir saat dilimi olmalıdır.',
    'unique'               => ':attribute daha önceden kayıt edilmiş.',
    'uploaded'             => ':attribute yüklemesi başarısız.',
    'url'                  => ':attribute biçimi geçersiz.',
    'uuid'                 => ':attribute bir UUID formatına uygun olmalı.',

    /*
    |--------------------------------------------------------------------------
    | Özelleştirilmiş Doğrulama Mesajları
    |--------------------------------------------------------------------------
    |
    | Bu alanda her niteleyici (attribute) ve kural (rule) ikilisine özel hata
    | mesajları tanımlayabilirsiniz. Bu özellik, son kullanıcıya daha gerçekçi
    | metinler göstermeniz için oldukça faydalıdır.
    |
    | Örnek olarak:
    |
    | 'email.email': 'Girdiğiniz e-posta adresi geçerli değil.'
    | 'x.regex': 'x alanı için "a-b.c" formatında veri girmelisiniz.'
    |
    */

    'custom' => [
        'x' => [
            'regex' => 'x alanı için "a-b.c" formatında veri girmelisiniz.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Özelleştirilmiş Niteleyici İsimleri
    |--------------------------------------------------------------------------
    |
    | Bu alandaki bilgiler "email" gibi niteleyici isimlerini "e-posta adresi"
    | gibi daha okunabilir metinlere çevirmek için kullanılır. Bu bilgiler
    | hata mesajlarının daha temiz olmasını sağlar.
    |
    | Örnek olarak:
    |
    | 'email' => 'e-posta adresi',
    | 'password' => 'parola',
    |
    */

    'attributes' => [
        'name'             => 'İsim',
        'description'      => 'Açıklama',
        'status'           => 'Durum',
        'image'            => 'Resim',
        'sub_title'        => 'Altbaşlık',
        'category'         => 'Kategori',
        'developer'        => 'Geliştirici',
        'publisher'        => 'Dağıtıcı',
        'age_rating'       => 'Yaş Sınırı',
        'genre'            => 'Tür',
        'release_date'     => 'Çıkış tarihi',
        'website'          => 'Resmi İnternet Sitesi',
        'cpu_min'          => 'Minimum işlemci',
        'gpu_min'          => 'Minimum ekran kartı',
        'ram_min'          => 'Minimum RAM',
        'ram_min_unit'     => 'Minimum RAM birimi',
        'storage_min'      => 'Minimum depolama alanı',
        'storage_min_unit' => 'Minimum depolama alanı birimi',
        'os_min'           => 'Minimum işletim sistemi',
        'cpu_rec'          => 'Önerilen işlemci',
        'gpu_rec'          => 'Önerilen ekran kartı',
        'ram_rec'          => 'Önerilen RAM',
        'ram_rec_unit'     => 'Önerilen RAM birimi',
        'storage_rec'      => 'Önerilen depolama alanı',
        'storage_rec_unit' => 'Önerilen depolama alanı birimi',
        'os_rec'           => 'Önerilen işletim sistemi',
        'cover_image'      => 'Kapak resmi',
        'image1'           => 'Resim1',
        'video1'           => 'Video1',
        'password'         => 'Şifre',
        'about'            => 'Hakkımda',
        'user_name'        => 'Kullanıcı adı',
        'email'            => 'E-Posta',
        'current_password' => 'Mevcut şifre',
        'ban_reason'       => 'Yasak sebebi',
        'comment'          => 'Yorum',
        'edit_comment'     => 'Düzenlenen yorum',
        'reply_comment'    => 'Yorum cevabı',
        'body'             => 'Yorum içeriği',
        'ip'               => 'IP'
    ],

];
