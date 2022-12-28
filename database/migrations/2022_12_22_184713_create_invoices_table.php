<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId("section_id")->constrained()->cascadeOnDelete();
            $table->foreignId("product_id")->constrained()->cascadeOnDelete();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->string("invoice_number")->unique();
            $table->date("invoice_Date");
            $table->date("due_date");
            $table->decimal("amount_collection",8,2);
            $table->decimal("amount_commission",8,2);
            $table->decimal("discount",8,2);
            $table->decimal("rate_vat",8,2);
            $table->decimal("value_vat",8,2);
            $table->decimal("total",8,2);
            $table->text("note")->nullable();
            $table->integer("status")->default(1);
            $table->string("image")->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
};
