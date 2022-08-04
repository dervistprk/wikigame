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

    .verify-link {
        text-decoration: none;
        color: #008000;
    }

    .verify-link:hover {
        color: #32cd32;
    }

    p {
        padding: 4px;
    }
</style>
<div class="body">
    <h1>Üyelik Onayı</h1>
    <h3>WikiGame'e hoşgeldiniz. Sizi aramızda görmekten mutluluk duyuyoruz.</h3>
    <p>
        WikiGame üyeliğinizi tamamlamak için lütfen alttaki linke tıklayınız.<br>
        <a class="verify-link" href="{{ route('user-verify', $token) }}">Üyeliğimi Tamamla</a>
    </p>
</div>