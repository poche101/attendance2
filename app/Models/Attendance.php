<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Attendance extends Model {
 protected $guarded=[];
 protected $casts=['service_date'=>'date'];
 public function member(){ return $this->belongsTo(Member::class); }
}
