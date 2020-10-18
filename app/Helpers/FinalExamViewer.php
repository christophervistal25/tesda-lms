<?php
namespace App\Helpers;
use App\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use App\Activity;
use App\Exam;
use App\Module;
use App\Contracts\ModuleActivityFinder;

class FinalExamViewer implements ModuleActivityFinder
{
    private $next;
    private $previous;

     public function setNext($next)
    {
        $this->next = $next;
    }

    public function setPrevious($previous)
    {
      $this->previous = $previous;
    }

    public function getPrevious()
    {
      return $this->previous;
    }

    public function getNext()
    {
      return $this->next;
    }

    public function has($data) :bool
    {
      return !empty($data);
    }

    public function isPreviousEmpty() :bool
    {
      return is_null($this->previous);
    }

    public function isNextEmpty() :bool
    {
        return is_null($this->next);
    }

    public function possiblePrevious(array $data = [])
    {
        return $data['module']->where('is_overview', 1)
                    ->first()
                    ->files
                    ->last() ?? null;
    }

    public function possibleNext(array $data = []) 
    {
        return null;
    }


    public function process(array $data = [])
    {
        $module = Module::find($data['module_id']);
        $this->setPrevious( $module->activities->where('completion', '!=', 1)->last() );
        $this->setNext( $module->activities->where('completion', 1)->first() );

        if ($this->isPreviousEmpty()) {
            $this->setPrevious($this->possiblePrevious(['module' => $module]));
        }

        if ($this->isNextEmpty()) {
            $this->setNext($this->possibleNext(['module' => $module]));
        }
    }
}
