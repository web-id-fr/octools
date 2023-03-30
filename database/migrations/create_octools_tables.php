<?php

declare(strict_types=1);

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
        Schema::create(
            'organizations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            }
        );

        Schema::table(
            (new (config('octools.models.user')))->getTable(), function (Blueprint $table) {
                $table->foreignId('organization_id')->after('id')->constrained()->cascadeOnDelete();
                $table->boolean('isAdmin')->default(false)->after('id');
            }
        );

        Schema::create(
            'workspaces', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
            }
        );

        Schema::create(
            'workspace_services', function (Blueprint $table) {
                $table->id();
                $table->foreignId('workspace_id')->constrained()->cascadeOnDelete();
                $table->string('service');
                $table->text('config');
            }
        );

        Schema::create(
            'members', function (Blueprint $table) {
                $table->id();
                $table->string('email');
                $table->string('firstname');
                $table->string('lastname');
                $table->date('birthdate')->nullable();
                $table->foreignId('workspace_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
            }
        );

        Schema::create(
            'member_services', function (Blueprint $table) {
                $table->id();
                $table->foreignId('member_id')->constrained()->cascadeOnDelete();
                $table->string('service');
                $table->text('config');
            }
        );

        Schema::create(
            'applications', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('token');
                $table->string('api_token');
                $table->foreignId('workspace_id')->constrained()->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
        Schema::dropIfExists('member_services');
        Schema::dropIfExists('members');
        Schema::dropIfExists('workspace_services');
        Schema::dropIfExists('workspaces');

        Schema::dropIfExists('organizations');
    }
};
