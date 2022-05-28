<?php

namespace Support\General;

use DateTime;

class DateFormat
{


	// Time Left ( 2 parameters , $time, $date_type[time, datetime] )
	public function time_left($time, $date_type = 'time')
	{
		if ($date_type == 'time') {
			$seconds = $time - time();
		} else {
			$seconds =  strtotime($time) - time();
		}

		$output = '';

		$days = floor($seconds / 86400);
		$seconds %= 86400;

		$hours = floor($seconds / 3600);
		$seconds %= 3600;

		$minutes = floor($seconds / 60);
		$seconds %= 60;

		if ($seconds < 0) {
			$output = false;
			return $output;
		}

		if ($days > 0) {
			$output = $days . 'd ' . $hours . 'h';
		} else {
			$output = $hours . 'h ' . $minutes . 'm';
		}

		if ($hours == 0 && $days == 0) {
			$output = $minutes . 'm ' . $seconds . 's';
		}

		return $output;
	}

	public function datetime_elapsed($time, $date_type = 'date')
	{
		if ($date_type == 'date') {
			$etime = time() - strtotime($time);
		} else {
			$etime = time() - $time;
		}

		if ($etime < 1) {
			return '0 seconds';
		}

		$a = array(
			12 * 30 * 24 * 60 * 60  =>  'year',
			30 * 24 * 60 * 60       =>  'month',
			24 * 60 * 60            =>  'day',
			60 * 60                 =>  'hour',
			60                     	=>  'minute',
			1                       =>  'second'
		);

		foreach ($a as $secs => $str) {
			$d = $etime / $secs;
			if ($d >= 1) {
				$r = round($d);
				return $r . ' ' . $str . ($r > 1 ? 's ago' : ' ago');
			}
		}
	}

	public function time_diff($time, $date_type = 'date')
	{
		if ($date_type == 'date') {
			return time() - strtotime($time);
		}

		return time() - $time;
	}


	public function format($date, $format)
	{
		$date = new DateTime($date);
		return $date->format($format);
	}

	public function alter($modify, $date = null, $format = 'Y-m-d H:i')
	{
		if ($date === null) {
			$date = date('Y-m-d H:i');
		}

		$dateTime = new DateTime($date);

		return $dateTime->modify($modify)->format($format);
	}

	public function get_year($date)
	{
		$this->format($date, 'Y');
	}

	public function get_day($date)
	{
		$this->format($date, 'j');
	}

	public function get_day_name($date)
	{
		$this->format($date, 'l');
	}
}
