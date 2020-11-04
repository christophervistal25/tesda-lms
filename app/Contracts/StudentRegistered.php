<?php
namespace App\Contracts;

interface StudentRegistered {
	public function from($start, $end, $periods);
}