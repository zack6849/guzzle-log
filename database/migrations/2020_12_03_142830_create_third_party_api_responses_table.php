<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdPartyApiResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_api_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId("third_party_api_request_id")->references("id")->on("third_party_api_requests");
            $table->integer("status");
            $table->longText("body");
            $table->longText("headers");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('third_party_api_responses');
    }
}
