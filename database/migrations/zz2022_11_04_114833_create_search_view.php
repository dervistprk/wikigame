<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'CREATE VIEW search_view AS
                        SELECT g.id AS id,
                        g.name AS name,
                        g.slug AS slug,
                        g.status AS status,
                        g.cover_image AS cover_image,
                        d.name AS developer_name,
                        p.name AS publisher_name,
                        c.name AS category_name,
                        gd.release_date AS release_date
                        FROM ((((games g
                        left join developers d on(d.id = g.developer_id))
                        left join publishers p on(p.id = g.publisher_id))
                        left join categories c on(c.id = g.category_id))
                        left join game_details gd on(gd.id = g.game_details_id))'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW search_view');
    }
}
