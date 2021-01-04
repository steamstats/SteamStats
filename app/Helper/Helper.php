<?php 
namespace App\Helper;

use DateTime;

class Helper
{
	public static function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

	public static function calculateAverageStars($starArray)
	{
		$average = ($starArray['5']*5 + $starArray['4']*4 + $starArray['3']*3 + $starArray['2']*2 + $starArray['1']*1) / ($starArray['5'] + $starArray['4'] + $starArray['3'] + $starArray['2'] + $starArray['1']);
		$average = floor($average * 2) / 2;
		return $average;
	}

	public static function calculateStarsPercentage($starArray)
	{
		// SELECT * FROM `reviews` WHERE `appid` = 20 ORDER BY `reviews`.`stars` ASC
		$total = $starArray['5'] + $starArray['4'] + $starArray['3'] + $starArray['2'] + $starArray['1'];
		$starPercentage['1'] = ($starArray['1'] / $total) * 100 . '%';
		$starPercentage['2'] = ($starArray['2'] / $total) * 100 . '%';
		$starPercentage['3'] = ($starArray['3'] / $total) * 100 . '%';
		$starPercentage['4'] = ($starArray['4'] / $total) * 100 . '%';
		$starPercentage['5'] = ($starArray['5'] / $total) * 100 . '%';
		return $starPercentage;
	}
}


 ?>