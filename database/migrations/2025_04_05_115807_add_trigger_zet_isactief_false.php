<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER zet_isactief_false
        BEFORE UPDATE ON advertenties
        FOR EACH ROW
        BEGIN
            IF NEW.created_at < NOW() - INTERVAL 30 DAY THEN
                SET NEW.is_actief = false;
            END IF;
        END
    ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS zet_isactief_false');
    }

};
