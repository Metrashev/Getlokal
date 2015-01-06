<?php

// http://docs.doctrine-project.org/projects/doctrine1/en/latest/en/manual/utilities.html#working-with-pager
class mySfDoctrinePager extends sfDoctrinePager implements Serializable
{
    public function setNbRes($count)
    {
        $this->setNbResults($count);
    }

    /**
    * @see sfPager / sfDoctrinePager
    */
    public function init()
    {
        $this->resetIterator();

        $query = $this->getQuery();
        $query
          ->offset(0)
          ->limit(0);

        if (0 == $this->getPage() || 0 == $this->getMaxPerPage() || 0 == $this->getNbResults())
        {
            $this->setLastPage(0);
        }
        else
        {
            $offset = ($this->getPage() - 1) * $this->getMaxPerPage();

            $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));

            $query
              ->offset($offset)
              ->limit($this->getMaxPerPage());
        }
    }
}