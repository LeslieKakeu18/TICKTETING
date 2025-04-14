<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->enum('statut', ['Ouvert', 'En cours', 'Résolu', 'Fermé']);
            $table->enum('priorite', ['Faible', 'Moyenne', 'Élevée', 'Critique']);
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamp('date_mise_a_jour')->nullable();
            $table->foreignId('id_employe')->constrained('users'); // Référence à l'employé
            $table->foreignId('id_technicien')->nullable()->constrained('users'); // Référence au technicien
            $table->timestamps();
            $table->integer('temps_resolution')->nullable(); // Durée en minutes, par exemple
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
