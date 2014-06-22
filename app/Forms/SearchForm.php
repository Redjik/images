<?php
/**
 * @author Ivan Matveev <Redjiks@gmail.com>.
 */

namespace app\Forms;


use Symfony\Component\HttpFoundation\Request;

class SearchForm
{
    protected $step;

    protected $includeTags;

    protected $excludeTags;

    public function __construct(Request $request)
    {
        $this->step = (int)$request->get('step');
        $this->includeTags = $request->get('include',[]);
        $this->excludeTags = $request->get('exclude',[]);
    }

    public function hasIncludeTag($id)
    {
        if ($this->includeTags === null){
            return false;
        }
        return array_search($id, $this->includeTags)!==false;
    }

    public function hasExcludeTag($id)
    {
        if ($this->excludeTags === null){
            return false;
        }
        return array_search($id, $this->excludeTags)!==false;
    }

    /**
     * @return int
     */
    public function getStep()
    {
        return (int)$this->step;
    }

    /**
     * @return mixed
     */
    public function getExcludeTags()
    {
        if (!is_array($this->excludeTags)){
            $this->includeTags = (array)$this->excludeTags;
        }
        return $this->excludeTags;
    }

    /**
     * @return mixed
     */
    public function getIncludeTags()
    {
        if (!is_array($this->includeTags)){
            $this->includeTags = (array)$this->includeTags;
        }
        return $this->includeTags;
    }



    public function isDefault()
    {
        return $this->step === null && $this->includeTags === null && $this->excludeTags === null;
    }


} 