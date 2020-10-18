<?php
namespace App\Helpers;
use Auth;

class CertificateRepository
{
	public function isUserCanDownload() :bool
	{
		return Auth::user()->exam_attempt->where('status', 'passed')->count() >= 1;
	}
}
