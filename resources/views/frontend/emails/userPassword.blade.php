<style>
    .body {
        font-family: "Helvetica Neue", sans-serif;
    }

    h1 {
        color: #ff4500;
    }

    h3 {
        color: #ff8c00;
    }

    .login {
        text-decoration: none;
        color: darkred;
    }

    .login:hover {
        color: orangered;
    }

    p {
        padding: 4px;
    }
</style>
<div class="body">
    <h1>Üyelik Bilgileriniz</h1>
    <h3>WikiGame'e hoşgeldiniz. Sizi aramızda görmekten mutluluk duyuyoruz.</h3>
    <p>
        Google servisini kullanarak üye oldunuz. Giriş bilgileriniz aşağıda belirtilmiştir.<br>
        Şifrenizi değiştirmenizi şiddetle tavsiye ederiz.<br>
        Şifrenizi değiştirmek ve diğer bilgilerinizi güncellemek için <strong>profilim->profil bilgilerimi güncelle</strong> adımlarını takip edebilirsiniz.
    </p>
    <p>
        <strong>Şifreniz:</strong> {{ $password }}<br>
        Profil sayfanıza gitmek için <a class="login" href="{{ route('user-profile') }}">buraya</a> tıklayınız.<br>
    </p>
</div>