<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReorderTitleColumnInComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Usar uma instrução SQL para alterar a posição da coluna
        DB::statement('ALTER TABLE complaints MODIFY title VARCHAR(255) AFTER complaint_type_id;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Voltar a posição do title para o final (ou onde estava anteriormente)
        DB::statement('ALTER TABLE complaints MODIFY title VARCHAR(255) AFTER description;');
    }
}
