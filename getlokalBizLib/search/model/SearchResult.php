<?php
class SearchResult
{
    /**
     * @var = array() of error messages
     */
    public $errors;
    /**
     * @var = total returned records. Use it for paging
     */
    public $totalReturned;
    /**
     * @var = array() of searched models
     */
    public $searchResultModels;
    /**
     * @var = service info for debugging and tracing
     */
    public $trace;
}
?>