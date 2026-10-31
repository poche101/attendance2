<?php
namespace App\Http\Controllers;
use App\Models\Church; use Carbon\Carbon; use Illuminate\Http\Request; use Illuminate\Support\Facades\{Auth,Http};
class AdminController extends Controller {
 public function loginForm(Church $church){ return view('login',compact('church')); }
 public function login(Request $r, Church $church){
  $c=$r->validate(['email'=>'required|email','password'=>'required']);
  // church_id in the credentials means one church's admin can never sign in on another church's slug.
  if(Auth::attempt($c+['church_id'=>$church->id],$r->boolean('remember'))){ $r->session()->regenerate(); return redirect()->route('admin',$church); }
  return back()->withErrors(['email'=>'Invalid credentials for this church.'])->onlyInput('email');
 }
 public function logout(Request $r, Church $church){ Auth::logout(); $r->session()->invalidate(); $r->session()->regenerateToken(); return redirect()->route('admin.login',$church); }

 private function date(Request $r): string { try{ return $r->query('date')?Carbon::parse($r->query('date'))->toDateString():Church::serviceDate(); }catch(\Throwable $e){ return Church::serviceDate(); } }
 private function stats(Church $church,string $date): array {
  $present=$church->attendances()->with('member')->where('service_date',$date)->latest()->get();
  $absent=$church->members()->whereNotIn('id',$present->pluck('member_id'))->orderBy('full_name')->get();
  $total=$church->members()->count(); $kids=$present->sum('children');
  $byGroup=$present->groupBy(fn($a)=>$a->member->group_name)->map->count()->sortDesc();
  $byCell=$present->groupBy(fn($a)=>$a->member->cell_name)->map->count()->sortDesc();
  $rate=$total?round($present->count()/$total*100):0;
  $dates=$church->attendances()->select('service_date')->distinct()->orderByDesc('service_date')->pluck('service_date')->map(fn($d)=>Carbon::parse($d)->toDateString());
  return compact('date','present','absent','total','kids','byGroup','byCell','rate','dates','church')+['saturday'=>Carbon::parse($date)->addDays(6),'current'=>$date===Church::serviceDate()];
 }
 public function dashboard(Church $church){ return view('admin.overview',$this->stats($church,Church::serviceDate())); }
 public function attendance(Request $r, Church $church){
  $s=$this->stats($church,$this->date($r));
  $sections=$church->sections();
  $section=$r->query('section'); if(!isset($sections[$section])) $section=null;
  $in=fn($m,$g)=>in_array($m->group_name,$g,true);
  // counts per tab (Ajah / Ajah-Mega) before filtering
  $counts=collect($sections)->map(fn($sec)=>[
   'present'=>$s['present']->filter(fn($a)=>$in($a->member,$sec['groups']))->count(),
   'absent'=>$s['absent']->filter(fn($m)=>$in($m,$sec['groups']))->count()])->all();
  if($section){ $g=$sections[$section]['groups'];
   $s['present']=$s['present']->filter(fn($a)=>$in($a->member,$g))->values();
   $s['absent']=$s['absent']->filter(fn($m)=>$in($m,$g))->values(); }
  return view('admin.attendance',$s+['tab'=>$r->query('tab')==='absent'?'absent':'present','sections'=>$sections,'section'=>$section,'counts'=>$counts]);
 }
 public function report(Request $r, Church $church){ return view('admin.report',$this->stats($church,$this->date($r))); }
 public function export(Request $r, Church $church, string $type){
  $s=$this->stats($church,$this->date($r));
  $rows=$type==='present'?$s['present']->map(fn($a)=>[$a->member,$a->children]):$s['absent']->map(fn($m)=>[$m,'']);
  $sections=$church->sections(); $section=$r->query('section'); if(!isset($sections[$section])) $section=null;
  if($section){ $g=$sections[$section]['groups']; $rows=$rows->filter(fn($row)=>in_array($row[0]->group_name,$g,true)); }
  return response()->streamDownload(function()use($rows){ $f=fopen('php://output','w'); fputcsv($f,['Name','Email','Phone','Group','Cell/Church','Children']);
   foreach($rows as [$m,$k]) fputcsv($f,[$m->full_name,$m->email,$m->phone,$m->group_name,$m->cell_name,$k]); fclose($f); },"{$church->slug}-{$type}".($section?"-$section":"")."-{$s['date']}.csv");
 }
 public function searchForm(Church $church){ return view('admin.search',compact('church')); }
 // Semantic search via OpenAI. Only THIS church's history is ever sent.
 public function search(Request $r, Church $church){
  $q=$r->validate(['q'=>'required|string|max:500'])['q'];
  $rows=$church->attendances()->with('member')->latest('service_date')->limit(3000)->get()
   ->map(fn($a)=>implode('|',[$a->service_date->toDateString(),$a->member->full_name,$a->member->group_name,$a->member->cell_name,$a->children]))->implode("\n");
  $all=$church->members()->get()->map(fn($m)=>implode('|',[$m->full_name,$m->group_name,$m->cell_name]))->implode("\n");
  $res=Http::withToken(config('services.openai.key'))->timeout(90)->post('https://api.openai.com/v1/chat/completions',[
   'model'=>config('services.openai.model'),
   'messages'=>[
    ['role'=>'system','content'=>"You are an attendance analyst for {$church->name}. Answer only from the data given. Be concise, use specific names and numbers, and say so if the data cannot answer the question."],
    ['role'=>'user','content'=>"Attendance records (Date|Name|Group|Cell|Children):\n$rows\n\nAll registered members (Name|Group|Cell):\n$all\n\nQuestion: $q"]]]);
  return redirect()->route('admin.search',$church)->with('answer',$res->json('choices.0.message.content') ?? 'Search is unavailable right now. Check the OpenAI key and model.')->with('q',$q);
 }
}
