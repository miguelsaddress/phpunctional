<?php
namespace Mamoreno\DataStore\Traits;

trait Store {
	
    public function values() {
        return $this->values;
    }

    /**
     *  returns the element at the given key. That key must exist
     *
     * @param      <type>  $key    key that identifies the item
     *
     * @return     <type>   mixed
     */
    public function get($key) {
        return $this->values[$key];
    }

    /**
     * returns the element at the given Key or a default value instead
     *
     * @param      <type>  $key    key that identifies the item
     * @param      <type>  $else   default value if the key does not exist
     *
     * @return     <type>  mixed
     */
    public function getOrElse($key, $else) {
        return isset($this->values[$key]) ? $this->values[$key] : $else;
    }

    /**
     * returns the unique values of the collection
     *
     * @return     array
     */
    public function uniqueValues() {
        return @array_unique(array_values($this->values));
    }

    /**
     * Returns a new Store with the result of applying the function
     * to every element
     *
     * @param      \Closure  $f      function that receives an element of the collection
     *                               and returns the result of a transformation on it
     *
     * @return     self
     */
    public function map(\Closure $f) {
        return new self(array_map($f, $this->values));
    }


    /**
     * Returns a new Store with the result of applying the function
     * to every element. The new collection will be flattened
     *
     * @param      \Closure  $f      function that receives an element of the collection
     *                               and returns the result of a transformation on it
     *
     * @return     self
     */
    public function flatMap(\Closure $f) {
        return $this->map($f)->flatten();
    }

    /**
     * Returns a new Store containing only the values that match the given predicate
     *
     * @param      \Closure  $f      predicate that receives an item of the collection and
     *                               returns a boolean. True if the element fits the filter.
     *                               false otherwise
     *
     * @return     self
     */ 
    public function filter(\Closure $f) {
        return new self(array_values(array_filter($this->values, $f)));
    }

    /**
     * Returns true if all the elements of the collection accomplish the given function
     *
     * @param      Function|\Closure  $f    predicate that receives an item of the collection and
     *                                      returns a boolean. True if the element fits the filter.
     *                                      false otherwise
     *
     * @return     boolean
     */
    public function forAll(\Closure $f) {
        $ret = $this->fold(true, 
            function($carry, $item) use ($f) {
                return $carry && $f($item); 
            }
        );
        return $ret;
    }

    /**
     * Returns true if some the elements of the collection accomplish the given function
     *
     * @param      Function|\Closure  $f    predicate that receives an item of the collection and
     *                                      returns a boolean. True if the element fits the filter.
     *                                      false otherwise
     *
     * @return     boolean
     */
    public function forSome(\Closure $f) {
        $ret = $this->fold(false, 
            function($carry, $item) use ($f) {
                return $carry || $f($item); 
            }
        );
        return $ret;
    }

    /**
     * Returns a new Store containing the flatten collection
     *
     * @return     self
     */
    public function flatten() {
        $output = array();
        $kvs = $this->values;
        array_walk_recursive($kvs, function ($current) use (&$output) {
            $output[] = $current;
        });
        return new self($output);
    }

    /**
     * returns a new collection in reverse order from the initial one
     *
     * @return     self
     */
    public function reverse() {
        return new self(array_reverse($this->values, $preserveKeys=false));
    }

    /**
     * Fold. Returns a value resulting of reducing the values of the Store
     * by applying the given function.
     *
     * @param      mixed    $zero   zero value
     * @param      \Closure  $f     function that takes a $carry and an $item
     */
    public function fold($zero, \Closure $f) {
        return array_reduce($this->values, $f, $zero);
    }
}

