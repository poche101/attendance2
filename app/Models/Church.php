<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Church extends Model {
 protected $guarded=[];
 public function getRouteKeyName(): string { return 'slug'; }
 public function members(){ return $this->hasMany(Member::class); }
 public function attendances(){ return $this->hasMany(Attendance::class); }
 public function config(): array { return config('churches.'.$this->slug); }
 public static function serviceDate(): string { return now()->startOfWeek(\Carbon\Carbon::SUNDAY)->toDateString(); }
}
