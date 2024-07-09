<h1>Wikigame</h1>
<h2>Game encyclopedia website made with laravel framework.</h2>
<h3>You can install the project with any of the installation methods below.</h3>
<h2>Setting up locally</h2>
<p>Open a terminal window in the application folder where the project files are located.</p>
<p>Install composer dependencies by <code>composer install</code> command.</p>
<p>Copy <b>.env.example</b> file and rename it to <b>.env</b> and configure your database settings.</p>
<p>Generate new app_key by <code>php artisan key:generate</code> command.</p>
<p>Create a new database named <code>laravel_wikigame</code>.</p>
<p>Create database tables and seed data inside it by <code>php artisan migrate:fresh --seed</code> command.</p>
<p>Start your local development server by <code>php artisan serve</code> command. You will need a local server program for this.(Xampp, Wampp etc.)</p>
<p>If you are not running the app on your local, then add your IP address to <code>whitelist</code> table. <code>127.0.0.1</code> should be already added by seeding.</p>
<p>You need to set your mail setting in the <code>.env</code> file in order to test verification mail after registering to app.</p>
<p>You need to set your social credentials values in the <code>.env</code> file in order to use sign in with social media login options.(<i>You can examine <code>.env.example</code> in order to get clearer idea about it.</i>)</p>
<p>
    Go to <code><a href="http://localhost:8000/admin/giris">localhost:8000/admin/giris</a></code> and type <code>dervistprk@email.com</code> for email and <code>123456Aa</code> for the password.(You must add your ip address to whitelist table to reach admin panel.)<br>
    Afterwards you will be automatically redirected to admin panel dashboard.<br>
    You can also use the account you are logged in to for the administrator at the frontend of the project.
</p>
<p>
    To see the frontend of the website simply go to <code><a href="http://localhost:8000/" target="_blank">localhost:8000</a></code><br>
</p>


<h2>Setting up with Docker</h2>
<h3>You can also run the project with Docker Desktop instead of locally</h3>
<p>Make sure you have docker desktop installed in your locale. For Docker Desktop installation: <code><a href="https://www.docker.com/products/docker-desktop/" target="_blank">Docker Desktop</a></code></p>
<p>Copy <b>.env.example</b> file and rename it to <b>.env</b> and configure your database settings.</p>
<p>Run the <code>docker-compose up -d --build</code> command in the project root directory in a terminal screen.</p>
<p>Then connect to the container you created with the <code>docker-compose exec php sh</code> command.</p>
<p>Then, go to the directory where the project files are in the container with the <code>cd /var/www/html</code> command.</p>
<p>Then install the composer dependencies in the container with the <code>composer install</code> command.</p>
<p>Generate new app_key by <code>php artisan key:generate</code> command.</p>
<p>Connect to the mysql container with <code>docker-compose exec mysql sh</code> command.</p>
<p>Run the <code>mysql -uroot -proot</code> command to login mysql database system.</p>
<p>After logging into the database system, create the database to be used for the project by running the <code>create database laravel_wikigame;</code> command.</p>
<p>Finally, connect to the PHP container again and run the <code>php artisan migrate:fresh --seed</code> command to create the tables in our database and add data to the tables.</p>
<p>You need to set your mail setting in the <code>.env</code> file in order to test verification mail after registering to app.</p>
<p>You need to set your social credentials values in the <code>.env</code> file in order to use sign in with social media login options.(<i>You can examine <code>.env.example</code> in order to get clearer idea about it.</i>)</p>
<p>You can now access the application via browser at <code><a href="http://localhost:8080">localhost:8080</a></code>.</p>
<p>You can now access the phpMyAdmin via browser at <code><a href="http://localhost:8090">localhost:8090</a></code>. Username: <code>root</code> Password: <code>root</code></p>
<p>
    Go to <code><a href="http://localhost:8080/admin/giris">localhost:8080/admin/giris</a></code> and type <code>dervistprk@email.com</code> for email and <code>123456Aa</code> for the password.(You must add your ip address to whitelist table to reach admin panel.)<br>
    Afterwards you will be automatically redirected to admin panel dashboard.<br>
    You can also use the account you are logged in to for the administrator at the frontend of the project.
</p>
<p>Thank you...</p>