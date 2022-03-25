<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_calling_details', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('calling_mobile');
            $table->enum('calling_mobile_exist', ['Yes', 'No'])->default('No');
            $table->longText('contact_list_name')->nullable();
            $table->longText('incoming_message');
            $table->enum('case_Type', ['ContactList', 'Emergency', 'Nick', 'QNA', 'NOTQN'])->default('NOTQN');
            $table->longText('alert_sent');
            $table->enum('trained', ['Yes', 'No'])->default('No');;
            $table->longText('kb_id');
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_calling_details');
    }
};
