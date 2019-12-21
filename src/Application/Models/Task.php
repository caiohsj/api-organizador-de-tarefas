<?php
namespace App\Application\Models;
use Illuminate\Database\Eloquent\Model;

 class Task extends Model
 {
   protected $fillable = [
      'titulo', 
      'descricao', 
      'update_at', 
      'created_at'
   ];
}