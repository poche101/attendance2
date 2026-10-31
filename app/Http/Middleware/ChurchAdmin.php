<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request; use App\Models\Church;
class ChurchAdmin {
 public function handle(Request $r, Closure $next){
  $c=$r->route('church'); $church=$c instanceof Church ? $c : Church::where('slug',$c)->firstOrFail();
  if(!auth()->check()) return redirect()->route('admin.login',$church);
  // An admin may only ever enter their own church's slug.
  abort_unless(auth()->user()->church_id === $church->id, 403, 'This account does not belong to this church.');
  return $next($r);
 }
}
