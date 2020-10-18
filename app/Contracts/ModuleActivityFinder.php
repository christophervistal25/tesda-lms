<?php
namespace App\Contracts;

interface ModuleActivityFinder {
	public function setNext($next);
	public function setPrevious($previous);
	public function getNext();
	public function getPrevious();
	public function process(array $data = []);
	public function isPreviousEmpty() :bool;
	public function isNextEmpty() :bool;
	public function possibleNext(array $data = []);
	public function possiblePrevious(array $data = []);
	public function has($data) :bool;
}