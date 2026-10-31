<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Member extends Model {
 protected $guarded=[];
 public static function key(string $p): string { return substr(preg_replace('/\D/','',$p),-10); }
 protected static function booted(): void { static::saving(fn($m)=>$m->phone_key=self::key($m->phone)); }
 public function attendances(){ return $this->hasMany(Attendance::class); }
}
