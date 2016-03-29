<?php
namespace Mamoreno\DataStore;

class KeyValueStore implements Interfaces\KeyValueStore {

    use Traits\Store;
    
    public function __construct(array $data = array()) {
        $this->values = $data;
        return $this;
    }

    /**
     * Returns the keys of the collection
     *
     * @return     <type> array
     */
    public function keys() {
        return array_keys($this->values);
    }

    /**
     * Sets a value on the given key. Existing keys get overriden.
     * Returns a new Store with that new State
     *
     * @param      <type>  $key    key to identify the value
     * @param      <type>  $value  value to be stored
     *
     * @return     self
     */
    public function set($key, $value) {
        $this->values[$key] = $value;
        return new self($this->values);
    }

    /**
     * returns the unique values of the collection, preserving keys
     *
     * @return     array
     */
    public function uniqueValuesKeepKeys() {
        return @array_unique($this->values);
    }

    /**
     * Returns a new Store with the result of applying the function
     * to every element, preserving the keys
     *
     * @param      \Closure  $f      function that receives an element of the collection
     *                               and returns the result of a transformation on it
     *
     * @return     self
     */
    public function mapKeepKeys(\Closure $f) {
        return new self($this->_keepKeys(array_map($f, $this->values)));
    }

    /**
     * Returns a new Store containing only the values that match the given predicate.
     * Preserving the keys
     *
     * @param      \Closure  $f      predicate that receives an item of the collection and
     *                               returns a boolean. True if the element fits the filter.
     *                               false otherwise
     *
     * @return     self
     */ 
    public function filterKeepKeys(\Closure $f) {
        return new self(array_filter($this->values, $f));
    }


    /**
     * Returns a new collection in reverse order from the initial one. 
     * Preserves the keys
     *
     * @return     self
     */
    public function reverseKeepKeys() {
        return new self(array_reverse($this->values, $preserveKeys=true));
    }


    /**
     * $a array resulting of an array_map operation
     */
    private function _keepKeys(array $a){
         $aux = array_map(null, $this->keys(), $a);
         //aux = 
         //  array(
         //    array(
         //       0 => key,
         //       1 => value
         //    ),
         //    array(
         //       0 => key,
         //       1 => value
         //    )
         // )
        return array_reduce($aux, function ($result, $item) {
            $result[$item[0]] = $item[1];
            return $result;
        }, array());
    }

}