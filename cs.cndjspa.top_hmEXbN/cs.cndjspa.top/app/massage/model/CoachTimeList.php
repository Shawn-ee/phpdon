<?php


namespace app\massage\model;


use app\BaseModel;

class CoachTimeList extends BaseModel
{
    protected $name = 'massage_service_coach_time_list';

    /**
     * 获取这个时段不能接单的技师id
     * @return array
     */
    public static function getCannotCoach($uniacid)
    {

        $tt = time();

        $coach_model = new Coach();

        $dis = [

            'uniacid' => $uniacid,

            'status'  => 2,

        ];

        $list = $coach_model->where($dis)->field('id,start_time,end_time')->select()->toArray();

        $arr = [];

        if(!empty($list)){

            foreach ($list as $value){

                $start_time = strtotime($value['start_time']);

                $end_time   = strtotime($value['end_time']);
                //跨日
                if($end_time <=$start_time){
                    //查看此时处于上一个周期还是这个周期
                    if($tt<$end_time){

                        $start_time -= 86400;

                    }else{
                        //当前周期
                        $end_time += 86400;
                    }

                }

                if($tt<$start_time||$tt>$end_time){

                    $arr[] = $value['id'];
                }

            }

        }

        $config_model = new Config();

        $config = $config_model->dataInfo(['uniacid'=>$uniacid]);

        $where = [
            ['time_str', '<', $tt+$config['time_unit']*60],
            ['time_str_end', '>=', $tt+$config['time_unit']*60],
            ['status', '=', 0],
            ['uniacid', '=', $uniacid],
            ['is_click', '=', 1]
        ];

        $rest = self::where($where)->column('coach_id');

        return array_merge($arr,$rest);
    }




    /**
     * @author chenniang
     * @DataTime: 2022-11-04 15:50
     * @功能说明:获取技师休息时长
     */
    public function getCoachRestTimeLong($caoch_id,$level_cycle,$type=1){

        $dis = [

            'coach_id' => $caoch_id,

            'status'   => 0,

            'is_click' => 1
        ];
        //每周
        if($level_cycle==1){

            $week = $type==1?'week':'last week';

            $price = $this->where($dis)->where('time_str','<',time())->whereTime('time_str',$week)->field('SUM(time_str_end-time_str) as time_long')->find();
            //每月
        }elseif ($level_cycle==2){

            $month = $type==1?'month':'last month';

            $price = $this->where($dis)->where('time_str','<',time())->whereTime('time_str',$month)->field('SUM(time_str_end-time_str) as time_long')->find();
            //每季度
        }elseif ($level_cycle==3){

            $quarter = $type==1 ? ceil((date('n'))/3) : ceil((date('n'))/3)-1;//获取当前季度

            $start_quarter = mktime(0, 0, 0,$quarter*3-2,1,date('Y'));

            $end_quarter   = mktime(0, 0, 0,$quarter*3+1,1,date('Y'));

            $price = $this->where($dis)->where('time_str','<',time())->where('time_str','between',"$start_quarter,$end_quarter")->field('SUM(time_str_end-time_str) as time_long')->find();
            //每年
        }elseif ($level_cycle==4){

            $year = $type==1?'year':'last year';

            $price = $this->where($dis)->where('time_str','<',time())->whereTime('time_str',$year)->field('SUM(time_str_end-time_str) as time_long')->find();

        }elseif ($level_cycle==5){

            $day = date('d',time());
            //本期
            if($type==1){
                //下半月
                if($day>15){

                    $start_time = strtotime(date ('Y-m-16', time()));

                    $end_time   = strtotime(date('Y-m-t', time()))+86399;

                }else{

                    $start_time = strtotime(date ('Y-m-01', time()));

                    $end_time   = strtotime(date('Y-m-16', time()))-1;
                }

            }else{
                //下半月
                if($day>15){

                    $start_time = strtotime(date ('Y-m-01', time()));

                    $end_time   = strtotime(date('Y-m-16', time()))-1;

                }else{

                    $start_time = strtotime(date ('Y-m-16', strtotime('-1 month')));

                    $end_time   = strtotime(date('Y-m-t', strtotime('-1 month')))+86399;

                }

            }

            $price = $this->where($dis)->where('time_str','<',time())->where('time_str','between',"$start_time,$end_time")->field('SUM(time_str_end-time_str) as time_long')->find();
        }else{
            //不限
            $price = $this->where($dis)->where('time_str','<',time())->field('SUM(time_str_end-time_str) as time_long')->find();

        }

        return !empty($price->time_long)?$price->time_long:0;

    }





   // public function
}