<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Church extends Model {
 protected $guarded=[];
 public function getRouteKeyName(): string { return 'slug'; }
 public function members(){ return $this->hasMany(Member::class); }
 public function attendances(){ return $this->hasMany(Attendance::class); }
 public function config(): array {
  $c=config('churches.'.$this->slug);
  // add each section's extra option ("Not in a Cell" / "Member") to the end of its groups' lists
  foreach(($c['sections']??[]) as $sec){ if(empty($sec['extra'])) continue;
   foreach($sec['groups'] as $g){ if(isset($c['groups'][$g]) && !in_array($sec['extra'],$c['groups'][$g],true)) $c['groups'][$g][]=$sec['extra']; } }
  return $c;
 }
 // Ajah / Ajah-Mega tabs (null for churches that have none)
 public function sections(): array { return $this->config()['sections'] ?? []; }
 public function sectionOf(?string $group): ?string { foreach($this->sections() as $k=>$s){ if(in_array($group,$s['groups'],true)) return $k; } return null; }
 public static function serviceDate(): string { return now()->startOfWeek(\Carbon\Carbon::SUNDAY)->toDateString(); }
}
