<?php
namespace App\Http\Controllers;
use App\Models\{Church,Member}; use Illuminate\Http\Request; use Illuminate\Validation\{Rule,ValidationException};
class MemberController extends Controller {
 private function rules(Church $church,$ignore=null): array {
  $g=$church->config()['groups'];
  return ['full_name'=>'required|string|max:120',
   'email'=>['required','email',Rule::unique('members')->where('church_id',$church->id)->ignore($ignore)],
   'phone'=>['required','string','min:10','max:20',function($a,$v,$f)use($church,$ignore){ if($church->members()->where('phone_key',Member::key($v))->when($ignore,fn($q)=>$q->where('id','!=',$ignore))->exists()) $f('This phone is already registered.'); }],
   'group_name'=>$g?['required',Rule::in(array_keys($g))]:'required|string|max:100','cell_name'=>'required|string|max:100'];
 }
 private function clean(Request $r,Church $church): array {
  $d=$r->validate($this->rules($church,$r->route('id'))); $g=$church->config()['groups'];
  if($g && !in_array($d['cell_name'],$g[$d['group_name']]??[])) throw ValidationException::withMessages(['cell_name'=>'Invalid selection.']);
  $d['email']=strtolower($d['email']); return $d;
 }
 public function index(Request $r, Church $church){
  $q=trim((string)$r->query('q'));$group=$r->query('group');
  $sections=$church->sections();
  $section=$r->query('section'); if(!isset($sections[$section])) $section=null;
  $sectionGroups=$section?$sections[$section]['groups']:null;
  if($group && $sectionGroups && !in_array($group,$sectionGroups,true)) $group=null; // group belongs to the other tab
  $members=$church->members()->withCount('attendances')
   ->when($sectionGroups,fn($x)=>$x->whereIn('group_name',$sectionGroups))
   ->when($q,fn($x)=>$x->where(fn($w)=>$w->where('full_name','like',"%$q%")->orWhere('email','like',"%$q%")->orWhere('phone','like',"%$q%")->orWhere('cell_name','like',"%$q%")))
   ->when($group,fn($x)=>$x->where('group_name',$group))->orderBy('full_name')->simplePaginate(25)->withQueryString();
  $groups=$church->members()->when($sectionGroups,fn($x)=>$x->whereIn('group_name',$sectionGroups))->select('group_name')->distinct()->orderBy('group_name')->pluck('group_name');
  $counts=collect($sections)->map(fn($s)=>$church->members()->whereIn('group_name',$s['groups'])->count())->all();
  return view('admin.members',['church'=>$church,'members'=>$members,'groups'=>$groups,'q'=>$q,'group'=>$group,'total'=>$church->members()->count(),'sections'=>$sections,'section'=>$section,'counts'=>$counts]);
 }
 public function create(Church $church){ return view('admin.member-form',['church'=>$church,'cfg'=>$church->config(),'m'=>null]); }
 public function store(Request $r, Church $church){ $church->members()->create($this->clean($r,$church)); return redirect()->route('admin.members',$church)->with('ok','Member added.'); }
 public function edit(Church $church,$id){ return view('admin.member-form',['church'=>$church,'cfg'=>$church->config(),'m'=>$church->members()->findOrFail($id)]); }
 public function update(Request $r, Church $church,$id){ $m=$church->members()->findOrFail($id); $m->update($this->clean($r,$church)); return redirect()->route('admin.members',$church)->with('ok','Member updated.'); }
 public function destroy(Church $church,$id){ $church->members()->findOrFail($id)->delete(); return redirect()->route('admin.members',$church)->with('ok','Member removed.'); }
 public function export(Church $church){
  return response()->streamDownload(function()use($church){ $f=fopen('php://output','w'); fputcsv($f,['Name','Email','Phone','Group','Cell/Church','Registered']);
   $church->members()->orderBy('full_name')->chunk(500,fn($c)=>$c->each(fn($m)=>fputcsv($f,[$m->full_name,$m->email,$m->phone,$m->group_name,$m->cell_name,$m->created_at->toDateString()]))); fclose($f); },"{$church->slug}-members.csv");
 }
}
