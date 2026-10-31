<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('churches', function(Blueprint $t){ $t->id(); $t->string('slug')->unique(); $t->string('name'); $t->timestamps(); });
  Schema::table('users', function(Blueprint $t){ $t->foreignId('church_id')->nullable()->constrained()->cascadeOnDelete(); });
  Schema::create('members', function(Blueprint $t){
   $t->id();$t->foreignId('church_id')->constrained()->cascadeOnDelete();
   $t->string('full_name');$t->string('email');$t->string('phone');$t->string('phone_key',10);
   $t->string('group_name');$t->string('cell_name');$t->timestamps();
   $t->unique(['church_id','email']);$t->unique(['church_id','phone_key']);
  });
  Schema::create('attendances', function(Blueprint $t){
   $t->id();$t->foreignId('church_id')->constrained()->cascadeOnDelete();
   $t->foreignId('member_id')->constrained()->cascadeOnDelete();
   $t->date('service_date');$t->unsignedSmallInteger('children')->default(0);$t->timestamps();
   $t->unique(['member_id','service_date']);$t->index(['church_id','service_date']);
  });
 }
};
