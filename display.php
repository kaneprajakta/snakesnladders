<?php
function dice_roll(){
    return rand(1,6);
}

function move($dice_inp,$winning_pos,$curr_pos){
    $final_pos = $curr_pos + $dice_inp;
    if($final_pos > $winning_pos){
        $final_pos =  $curr_pos;
    }
    return $final_pos;
}

function is_winning_pos($curr_pos,$winning_pos){
    if($curr_pos == $winning_pos){
        return true;
    }
    return false;
}

function get_coord_from_pos($pos,$grid_size){
       
    $row = ceil($pos / $grid_size) ;
    $y_cord = $row -1 ; // 6, 9 : y_cord : 1 , 2 

    $col = $pos % $grid_size; // 6, 9 : col = 0 
    if($y_cord == 0){
        if($col != 0 ){
            $x_cord = $col;
        }else{
            $x_cord = $grid_size - 1;    
        }
    }
    else{
        if($y_cord % 2 == 0){
            $x_cord = $grid_size - $col - 1;
            if($x_cord < 0){
                $x_cord = 0;
            }
        }else{
            if($col != 0 ){
                $x_cord = $grid_size - $col;
            }else{
                $x_cord = 0;
            } // 4 : 2,6:0 
        }
    }

    // row = y -cord , col = x-cord
    /*$row = ceil($pos / $grid_size) ; // 6 / 3 (1)
    if($row  != 0){
        $y_cord = $row -1 ;
    }else{
        $y_cord = $row;
    }

    $col = $pos % $grid_size;
    if($y_cord % 2 == 0){
        $x_cord = $col;
    }else{
        $x_cord = $grid_size - $col - 1;
        if($x_cord < 0){
            $x_cord = 0;
        }
    }*/

    return "(".$x_cord.','.$y_cord.")";
}


echo $grid_size = $_REQUEST['gridSize'];
$winning_pos = $grid_size * $grid_size;

$curr_pos[1] = 0;
$curr_pos[2] = 0;
$curr_pos[3] = 0;

$player = array();
$continue = 1;
$step = 0;
while($continue && $step <= 2){
for($i=1;$i<=3;$i++){
    $dice_inp = dice_roll();

    $player[$i]['drh'][] = $dice_inp;

    $curr_pos[$i] = move($dice_inp,$winning_pos,$curr_pos[$i]);
    $player[$i]['ph'][]  = $curr_pos[$i];
    $player[$i]['cph'][] = get_coord_from_pos($curr_pos[$i],$grid_size);
    if(is_winning_pos($curr_pos[$i],$winning_pos)){
        $player[$i]['ws'] = "WINNER";
        $continue =0;
        break;
    }else{
        $player[$i]['ws'] = "";
    }

}
$step ++;
}



echo "<pre>";print_r($player);
$output = "";
foreach($player as $key=>$val){
    $output .= "<tr><th>".$key."</th>";
    $output .= "<th>".implode(',',$player[$key]['drh'])."</th>";
    $output .= "<th>".implode(',',$player[$key]['ph'])."</th>";
    $output .= "<th>".implode(',',$player[$key]['cph'])."</th>";
    $output .= "<th>".$player[$key]['ws']."</th></tr>";
}


$output1 = "<table border='2' ><tr><th>PLAYER NO</th><th>DICE ROLL HISTORY</th><th>POSITION HISTORY</th>
<th>COORDINATES HISTORY</th><th>WINNER STATUS</th></tr>".$output."</table>";
echo $output1;

?>