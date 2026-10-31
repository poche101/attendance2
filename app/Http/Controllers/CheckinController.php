<?php
namespace App\Http\Controllers;
use App\Models\{Church,Member,Attendance};
use Illuminate\Http\Request; use Illuminate\Validation\Rule;
class CheckinController extends Controller {
 public function show(Church $church){ return view('checkin',compact('church')); }
 public function form(Church $church){ return view('register',['church'=>$church,'cfg'=>$church->config()]); }
 private function record(Church $church, Member $m, int $kids){
  Attendance::updateOrCreate(['member_id'=>$m->id,'service_date'=>Church::serviceDate()],['church_id'=>$church->id,'children'=>$kids]);
 }
 public function mark(Request $r, Church $church){
  $r->validate(['identifier'=>'required|string|max:120','children'=>'nullable|integer|min:0|max:30']);
  $id=trim($r->identifier);
  $q=$church->members(); // scoped to this church only
  $m=str_contains($id,'@') ? $q->where('email',strtolower($id))->first() : $q->where('phone_key',Member::key($id))->first();
  if(!$m) return redirect()->route('register',$church)->with('error','We couldn’t find you. Please create an account.');
  $this->record($church,$m,(int)$r->children);
  return back()->with('ok','Thank you, '.explode(' ',$m->full_name)[0].'! Your attendance is recorded.');
 }
 public function register(Request $r, Church $church){
  $cfg=$church->config(); $groups=$cfg['groups'];
  $data=$r->validate([
   'full_name'=>'required|string|max:120',
   'email'=>['required','email',Rule::unique('members')->where('church_id',$church->id)],
   'phone'=>['required','string','min:10','max:20',function($a,$v,$f)use($church){ if($church->members()->where('phone_key',Member::key($v))->exists()) $f('This phone is already registered.'); }],
   'group_name'=>$groups?['required',Rule::in(array_keys($groups))]:'required|string|max:100',
   'cell_name'=>'required|string|max:100']);
  if($groups && !in_array($data['cell_name'],$groups[$data['group_name']]??[])) return back()->withInput()->withErrors(['cell_name'=>'Invalid selection.']);
  $data['email']=strtolower($data['email']);
  $m=$church->members()->create($data);
  $this->record($church,$m,(int)$r->input('children',0));
  return redirect()->route('checkin',$church)->with('ok','Welcome, '.explode(' ',$m->full_name)[0].'! Account created and attendance marked.');
 }
}
