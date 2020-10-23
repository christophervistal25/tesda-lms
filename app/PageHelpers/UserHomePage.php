<?php

	function hasStar($record)	{
		dd($record->course->count());
		if ($record->course->status->count() !== 0 && $record->course->status->first()->star == 1) {
			return '';
		} else {
			return 'd-none';
		}
	}
