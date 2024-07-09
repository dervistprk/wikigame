<h2>Wikigame</h2>
<h4>Game encyclopedia website made with laravel framework.</h4>
<p>Install composer dependencies by <code>composer install</code> command.</p>
<p>Rename <b>.env.example</b> file to <b>.env</b> file and configure your database settings.</p>
<p>Generate new app_key by <code>php artisan key:generate</code> command.</p>
<p>Create a new database named <code>laravel_wikigame</code>.</p>
<p>Create database tables and seed data inside it by <code>php artisan migrate:fresh --seed</code> command.</p>
<p>You can use <a href="https://github.com/barryvdh/laravel-ide-helper" target="_blank">IDE Helper</a> library if you want. It is uncluded in the library <code>composer.json</code> file.</p>
<p>Start your local development server by <code>php artisan serve</code> command. You will need a local server program for this.(Xampp, Wampp etc.)</p>
<p>If you are not running the app on your local, then add your IP address to <code>whitelist</code> table. <code>127.0.0.1</code> should be already added by seeding.</p>
<p>You need to set your mail setting in the <code>.env</code> file in order to test verification mail after registering to app.</p>
<p>You need to set your social credentials values in the <code>.env</code> file in order to use sign in with social media login options.(<i>You can examine <code>.env.example</code> in order to get clearer idea about it.</i>)</p>
<p>
    Go to <code>http://localhost:8000/admin/giris</code> and type <code>dervistprk@email.com</code> for email and <code>123456Aa</code> for the password.(You must add your ip address to whitelist table to reach admin panel.)<br>
    Afterwards you will be automatically redirected to admin panel dashboard.<br>
    You can also use the account you are logged in to for the administrator at the frontend of the project.
</p>
<p>
    To see the frontend of the website simply go to <code>http://localhost:8000/</code><br>
    Thank you...
</p>
