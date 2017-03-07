<?php
// quickLink
# writes out page links
function quickLink ($linkHref, $desc, $accessKey, $linkTitle) {
   $theLink = '<a href="'. $linkHref .'" title="'. $desc .'" accesskey="'. 
                   $accessKey .'">'. $linkTitle .'</a>';
   return $theLink;

} 
// google_like_pagination.php 
function pagination($number, $show, $showing, $firstlink, $baselink, $seperator, $total_records="") {

	
	
	$disp = floor($show / 2);
    if ( $showing <= $disp) :

        ///if ( ($disp - $showing) > 0 ):
        //$low  = ($disp - $showing);
        //else:
        $low = 1;
       // endif;
        $high = ($low + $show) - 1;

    elseif ( ($showing + $disp) > $number) :

        $high = $number;
        $low = ($number - $show) + 1;

    else:

        $low  = ($showing - $disp);
        $high = ($showing + $disp);

    endif;
    
    // next / prev / first / last
    if ( ($showing - 1) > 0 ) :
        if ( ($showing - 1) == 1 ):
        $prev  = quickLink ($firstlink, 'Previous', '', "&lt;&lt; Previous" );
        else:
        $prev  = quickLink ($baselink . $seperator . ($showing - 1), 
        'Previous', 'z', "&lt;&lt; Previous");
        endif;
    else:
        $prev  = '';
    endif; 

    $next  = ($showing + 1) <= $number ? 
    quickLink ($baselink . $seperator . ($showing + 1), 'Next', 'x', "Next &gt;&gt;") : '';    

    if ( $prev == '')
    	$first = '';    
    else
    	$first = quickLink ($firstlink, 'First Page', '', "First");    
    
    if ( $showing == $number ):
    $last = '';    
    else:
    $last = quickLink ($baselink . $seperator . $number, 'Last Page', '', "Last");
    endif;
    
    
    $navi = '<div id="paging">'."";
    // start the navi

        $navi .= $first . ' '. $prev ." ";
    
    // loop through the numbers

    foreach (range($low, $high) as $newnumber):

           if($newnumber < 0)
		   		continue;
		   $link = ( $newnumber == 1 ) ? $firstlink : 
                $baselink . $seperator . $newnumber;
           if ($newnumber > $number):
        $navi .= '';
        elseif ($newnumber == 0):
        $navi .= '';
        else:
        $navi .= ( $newnumber == $showing ) ? 
            ' <span style="background-color:#60C8F2;color:#FFF;padding:2px 5px"><b>'. $newnumber .'</b></span> '."" :
            ' '. quickLink ($link, 'Page '. $newnumber, '', $newnumber) ." "; 
        endif;                   
    endforeach;    
    
	$navi .= ' '. $next ." " . $last;
	
	if($total_records)
		//$navi .= " &nbsp; &nbsp; <span class='strong'>" . $total_records . " Records Found</span> &nbsp;";
            
    $navi .= '</div><br/>';
    
	return $navi;    

}
?>
