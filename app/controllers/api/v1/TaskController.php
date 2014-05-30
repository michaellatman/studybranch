<?php
namespace StudyBranch\API\v1;
use Carbon\Carbon;

/**
 * Class TaskController
 * @package Controllers
 * @subpackage User
 */
class TaskController extends \Controller{
    public function options(){
        return \Response::json(array("message"=>"Okay"));
    }
    private function parse_to_date_and_string($parse) {
        $old = $parse;
        $parse = strtolower($parse);
        $parse = preg_replace('/tmr \b/', ' tomorrow ', $parse);
        $parse = preg_replace('/md \b/', ' monday ', $parse);
        $parse = preg_replace('/night\b/', ' 6 pm ', $parse);
        $parse = preg_replace('/tonight\b/', ' today 6 pm ', $parse);
        $parse = preg_replace('/morning \b/', ' 8 am ', $parse);


        //$parse = str_replace("2day","today",$parse);
        $exclude = array('i', 'at','get');
        $parse_array = explode(" ", $parse);
        $parse_withCaps = explode(" ", $old);
        for($i=0;$i<count($parse_array);$i++){
            $t = $parse_array[$i];
            //$assume_am = array(8,9,10,11);
            $assume_pm = array(12,1,2,3,4,5,6,7);
            if($i>0&&is_numeric($t)&&($parse_array[$i-1]=="at"||$parse_array[$i-1]=="by")&&(!isset($parse_array[$i+1])||($parse_array[$i+1]!="pm"&&$parse_array[$i+1]!="am"))){
                $int = intval($t);
                if(in_array($int,$assume_pm)){
                    $parse_array[$i] = $t."pm";
                }
                else
                    $parse_array[$i] = $t."am";
            }
        }
        $date = array();
        $data['text'] = array();
        $word_count = count($parse_array);
        for($i = 0; $i < $word_count; $i++) {
            if (strtotime($parse_array[$i]) > 0 && !in_array($parse_array[$i], $exclude)) {
                $date[] = $parse_array[$i];
            }
            else if ($i+1<count($parse_array)&&strtotime($parse_array[$i].' '.$parse_array[$i+1]) > 0 && !in_array($parse_array[$i], $exclude)) {
                $date[] = $parse_array[$i].' '.$parse_array[$i+1];
                $i++;
            }
            else {
                if($i<count($parse_withCaps)) $data['text'][] = $parse_withCaps[$i];
            }
        }
        $user = Auth::user();
        $d = new Carbon(implode(" ", $date),$user->timezone);
        if($d->hour)
        if($d->diffInSeconds(Carbon::now())<5){
            $d->addDay();
            $d->setTime(8,0,0);
        }
        else if($d->isPast()){
            $d->addDay();
        }
        if($d->hour == 0) $d->hour(8);
        //$data['humanDateQuery'] = implode(" ", $datePre);
        //$data['rawDateQuery'] = implode(" ", $date);
        $task = new Task();
        $d->setTimezone("UTC");
        $task->due_date = $d;
        $task->title = $old;
        $user->tasks()->save($task);
        $task->local_due_date = $d->setTimezone("America/New_York");
        $task->rawDateQuery = implode(" ", $date);
        return $task;
    }

    public function post_create_task(){


        return \Response::JSON($this->parse_to_date_and_string(\Input::get("time")));
    }
    public function get_list_task(){
        $tasks = Task::where("user_id","=",Auth::user()->user_id)->select(\DB::raw('task_id, title, user_id,due_date,completed, CONVERT_TZ(due_date,"UTC","'.Auth::user()->timezone.'") as local_due_date'))->get();
        return \Response::JSON($tasks);
    }
    public function get_task($id){
        $task = Task::where("user_id","=",Auth::user()->user_id)->where("task_id","=",$id)->select(\DB::raw('task_id, title, user_id,due_date,completed, CONVERT_TZ(due_date,"UTC","America/New_York") as local_due_date'))->first();
        if($task == null) return \Response::json(array('message'=>"No task found"),404);
        return \Response::JSON($task);
    }
    public function post_task_complete($id){
        $task = Task::where("user_id","=",Auth::user()->user_id)->where("task_id","=",$id)->select(\DB::raw('task_id, title, user_id,due_date,completed, CONVERT_TZ(due_date,"UTC","America/New_York") as local_due_date'))->first();
        if($task == null) return \Response::json(array('message'=>"No task found"),404);
        $task->completed = \Input::get("completed",1);
        $task->save();
        return \Response::JSON($task);
    }
    public function get_finished_tasks(){
        $tasks = Task::where("user_id","=",Auth::user()->user_id)->completed()->get();
        return \Response::JSON($tasks);
    }
    public function delete_finished_tasks(){
        $tasks = Task::where("user_id","=",Auth::user()->user_id)->completed()->delete();
        return \Response::JSON(array('message'=>"Deleted.", "number"=>$tasks));
    }
    public function delete_task($id){
        $task = Task::where("user_id","=",Auth::user()->user_id)->where("task_id","=",$id)->select(\DB::raw('task_id, title, user_id,due_date,completed, CONVERT_TZ(due_date,"UTC","America/New_York") as local_due_date'))->first();
        if($task == null) return \Response::json(array('message'=>"No task found"),404);
        $task->delete();
        return \Response::JSON(array('message'=>"Deleted."));
    }
}