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
    public function up(): void
    {
        DB::table('categories')->insert([
            ['category_name' => 'Наука'],
            ['category_name' => 'История'],
            ['category_name' => 'География'],
            ['category_name' => 'Кино и сериалы'],
            ['category_name' => 'Музыка'],
            ['category_name' => 'Литература'],
            ['category_name' => 'Спорт'],
            ['category_name' => 'Искусство'],
            ['category_name' => 'Еда и кулинария'],
            ['category_name' => 'Видеоигры'],
            ['category_name' => 'Другое']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')->delete();
    }
};
