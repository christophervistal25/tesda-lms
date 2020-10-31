<?php
namespace App\Helpers;
use App\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use App\File;
use App\Post;
use App\Contracts\ModuleActivityFinder;

class OverviewViewer implements ModuleActivityFinder
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

    private function getFiles($course)
    {
        $overview = $course->modules->where('is_overview', 1)->first();
        return $overview->files ?? null;
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

    public function possibleNext(array $data = []) 
    {
      return $data['model']->modules
                    ->where('is_overview', 0)
                    ->first()
                    ->activities
                    ->where('activity_no', '1.1')
                    ->first() ?? null;
    }

    public function possiblePrevious(array $data = [])
    {
      return Post::find($data['id']) ?? null;
    }

     public function process(array $data = [])
    {
          $files = $this->getFiles($data['course']);
          if ($this->has($files)) {
              // Get all the array key for each file model.
              $key            = array_search($data['file_id'], array_column($files->toArray(), 'id'));

              // Get all the Id's of file model
              $ids            = array_column($files->toArray(), 'id');

              $this->setPrevious( File::find(@$ids[$key - 1]) );
              $this->setNext( File::find(@$ids[$key + 1]) );

              if ($this->isNextEmpty()) {
                  $this->setNext( $this->possibleNext(['model' => $data['course']]) );
              }

              if ($this->isPreviousEmpty()) {
                 $this->setPrevious( $this->possiblePrevious(['id' => $data['course']->id]) );
              }
        }

    }

}
