<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{

    public function up()
    {
        Schema::create('address_countries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 2);
            $table->string('name');
            $table->string('slug');
            $table->string('code_phone', 5)->nullable();
            $table->string('lang')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('address_country_regions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('country_id')->constrained('address_countries')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('address_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('address_countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('country_region_id')->nullable()->constrained('address_country_regions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('code', 2);
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('address_state_meso_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained('address_states')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('address_state_micro_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained('address_states')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('state_meso_region_id')->nullable()->constrained('address_state_meso_regions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('address_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained('address_states')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('state_micro_region_id')->nullable()->constrained('address_state_micro_regions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('address_city_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('address_cities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name', 255);
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('address_neighborhoods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('address_cities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('zone_id')->nullable()->constrained('address_city_zones')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('address_streets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('address_cities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('neighborhood_id')->nullable()->constrained('address_neighborhoods')->onUpdate('cascade')->onDelete('cascade');
            $table->string('zip_code', 9)->nullable();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('street_id')->constrained('address_streets')->onUpdate('cascade')->onDelete('cascade');
            $table->morphs('addressable');
            $table->integer('number')->nullable();
            $table->json('complement')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('address_streets');

        Schema::dropIfExists('address_neighborhoods');

        Schema::dropIfExists('address_city_zones');
        Schema::dropIfExists('address_cities');

        Schema::dropIfExists('address_state_micro_regions');
        Schema::dropIfExists('address_state_meso_regions');
        Schema::dropIfExists('address_states');

        Schema::dropIfExists('address_country_regions');
        Schema::dropIfExists('address_countries');
    }
}
