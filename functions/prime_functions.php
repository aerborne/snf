<?php 

function collectionStructure($singleCollection,$arrayName,$operator_use,$extender,$EndSymbol,$modD){
     $lastValue  = sizeof($arrayName)-1;
     $ctr = 0; 
     foreach($arrayName as $x => $x_value){
         if($modD == "name"){
              $x = substr($x,0,5);
         }else if($modD == "category_name"){
               $x = substr($x,0,4);
         }else{
             
         }
          
          
          if($ctr == $lastValue){
             $singleCollection .= "".$x."".$operator_use.$x_value.$EndSymbol;
             
           }else{
              $singleCollection .= "".$x."".$operator_use.$x_value.$EndSymbol."".$extender;   
            
           }
            $ctr++;
     } 
    return  "$singleCollection";
}
function convertDateTime($variable_id){  
        $month               =     substr($variable_id,5,2);
        $day                 =     substr($variable_id,8,2);
        $year                =     substr($variable_id,0,4);
        $time                =     substr($variable_id,11,5);
        $endTime             =     substr($variable_id,20,3);
        $time_convention     =     substr($variable_id,11,2);
           $NameOfMonths = array ();
           $NameOfMonths["01"]  = "January";
           $NameOfMonths["02"]  = "Febuary";
           $NameOfMonths["03"]  = "March";
           $NameOfMonths["04"]  = "April";
           $NameOfMonths["05"]  = "May";
           $NameOfMonths["06"]  = "June";
           $NameOfMonths["07"]  = "July";
           $NameOfMonths["08"]  = "August";
           $NameOfMonths["09"]  = "September";
           $NameOfMonths["10"]  = "October";
           $NameOfMonths["11"]  = "November";
           $NameOfMonths["12"]  = "December";   
        foreach ($NameOfMonths  as $key => $value){
            // $arr[3] will be updated with each value from $arr...
           $monthName = $NameOfMonths[$key];
            if($month == $key){
                if($time_convention > 12){
                    $time_convention = $time_convention - 12;
                    $time_convention = $time_convention.substr($variable_id,13,3); 
                    echo  $monthName." ".$day.", ".$year." at ".$time_convention." ".$endTime."  PM";
                }else{
                    echo  $monthName." ".$day.", ".$year." at ".$time." ".$endTime."  AM";
                }
               
            }
        }
}
    
 


?> 