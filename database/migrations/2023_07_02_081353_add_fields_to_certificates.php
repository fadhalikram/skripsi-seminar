<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCertificates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('logo_image');
            $table->string('signature_image');
            $table->string('background_image')->nullable();
            $table->string('certificate_number');
            $table->text('word_desc');
            $table->text('word_speaker');
            $table->text('word_title');
            $table->text('word_organization');
            $table->dropColumn('file_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('logo_image');
            $table->dropColumn('signature_image');
            $table->dropColumn('background_image');
            $table->dropColumn('certificate_number');
            $table->dropColumn('word_desc');
            $table->dropColumn('word_speaker');
            $table->dropColumn('word_title');
            $table->dropColumn('word_organization');
            $table->string('file_path');
        });
    }
}
