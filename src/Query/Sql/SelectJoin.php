<?php 

namespace ClanCats\Hydrahon\Query\Sql;

/**
 * SQL query object
 **
 * @package         Hydrahon
 * @copyright       2015 Mario Döring
 */

use ClanCats\Hydrahon\Query\Expression;

class SelectJoin extends SelectBase
{
    /**
     * join on items
     *
     * @var array
     */
    protected $ons = array();

    /**
     * The query where statements
     *
     * @var array
     */
    protected $wheres = array();

    /**
     * Add an on condition to the join object
     * 
     * @param string                $localKey
     * @param string                $operator
     * @param string                $referenceKey
     * 
     * @return static
     */
    public function on($localKey, $operator, $referenceKey, $type = 'and')
    {
        if (empty($this->ons)) 
        {
            $type = 'on';
        }
        
        if (is_object($localKey) && ($localKey instanceof \Closure)) 
        {
            // create new query object
            $subquery = new SelectJoin;

            // run the closure callback on the sub query
            call_user_func_array($localKey, array( &$subquery ));
 
            $this->ons[] = array($type, $subquery); return $this;
        }        
        $this->ons[] = array($type, $localKey, $operator, $referenceKey); return $this;
    }

    /**
     * Add an or on condition to the join object
     * 
     * @param string                $localKey
     * @param string                $operator
     * @param string                $referenceKey
     * 
     * @return static
     */
    public function orOn($localKey, $operator=null, $referenceKey=null)
    {
        $this->on($localKey, $operator, $referenceKey, 'or'); return $this;
    }

     /**
     * Add an and on condition to the join object
     * 
     * @param string                $localKey
     * @param string                $operator
     * @param string                $referenceKey
     * 
     * @return static
     */
    public function andOn($localKey, $operator=null, $referenceKey=null)
    {
        $this->on($localKey, $operator, $referenceKey, 'and'); return $this;
    }
}
