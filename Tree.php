<?

  /* 
   * Class to work with trees
   * Author: Anton Kosykh
   * Nickname: Kelin
   * Github: https://github.com/kelin2025
   * Usage: just include this file to your 
   * Copyright (c) 2016 - Anton Kosykh
   */

  class Tree {

    /** 
     * Tree array
     */
    protected $array = [];

    /**
     * Class constructor
     * @param  tree  array contains tree 
     */
    public function __construct($tree=[]){
      $this->array = $tree;
    }

    /**
     * Returns a full tree
     * @return  array  full tree
     */
    public function getTree(){
      return $this->array;
    }

    /**
     * Get tree item
     * @param   address  address of tree item. It can be written:
     *                   as an array ['path','to','item']
     *                   or string 'path.to.item'
     * @return  mixed    returns tree item
     */
    public function get($address){
      $arr = &$this->array;
      $this->parseaddress($address);
      foreach ($address as $key){
        if(isset($arr[$key])) return null;
        $arr = &$arr[$key];
      }
      return $arr;
    }

    /**
     * Set tree item
     * @param   address  address of tree item. It can be written:
     *                   as an array ['path','to','item']
     *                   or string 'path.to.item'
     * @param   val      value of tree item
     * @return  this     returns this
     * @see     if the tree already contains the element
     *          it WILL be replaced
     */
    public function set($address,$val){
      $arr = &$this->array;
      $this->parseaddress($address);
      foreach ($address as $key){
        if(isset($arr[$key])) unset($arr[$key]);
        $arr = &$arr[$key];
      }
      $arr = $val;
      return $this;
    }

    /**
     * Set tree item
     * @param   address  address of tree item. It can be written:
     *                   as an array ['path','to','item']
     *                   or string 'path.to.item'
     * @param   val      value of tree item
     * @return  this     returns this
     * @see     if the tree already contains the element
     *          it WILL NOT be replaced.
     */
    public function add($address,$val){
      $arr = &$this->array;
      $this->parseaddress($address);
      foreach ($address as $key) {
        $arr = &$arr[$key];
        if(isset($arr) && !is_array($arr))
          $arr = [$arr];
      }
      $arr = $val;
      return $this;
    }

    /**
     * Set list of tree items 
     * @param   list     array contains arraays with arguments to set() method
     *                   e.g. [['path.to.item','value'],['test','another']]
     * @return  this     return this
     */
    public function setList($list){
      foreach($list as $item)
        call_user_func_array([$this,'set'],$item);
      return $this;
    }

    /**
     * Add list of tree items 
     * @param   list     array contains arraays with arguments to add() method
     *                   e.g. [['path.to.item','value'],['test','another']]
     * @return  this     return this
     */
    public function addList($list){
      foreach($list as $item)
        call_user_func_array([$this,'add'],$item);
      return $this;
    }

    /**
     * Remove tree item
     * @param   address   address of tree item. It can be written:
     *                    as an array ['path','to','item']
     *                    or string 'path.to.item'
     * @param   address2  you can use 2 or more addresses to remove.
     * @return  this      returns this
     */
    public function remove(){
      $args = func_get_args();
      if(count($args) > 1){
        foreach($args as $address)
          $this->remove($address);
        return $this;
      }
      $address = $args[0];
      $arr = &$this->array;
      $this->parseaddress($address);
      while(count($address) > 0){
        if(count($address) == 1)
          unset($arr[array_shift($address)]);
        else
          $arr = &$arr[array_shift($address)];
      }
      return $this;
    }

    /**
     * Check if tree item exists
     * @param   address  address of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return   bool   returns true if item exists and false if not.
     */
    public function has($address){
      $arr = &$this->array;
      $this->parseaddress($address);
      while(count($address) > 0){
        $key = array_shift($address);
        if(!isset($arr[$key])) return false;
        $arr = &$arr[$key];
      }
      return true;
    }

    /**
     * Helper function
     * Transforms string address (e.g 'path.to.item') to array (e.g ['path','to','item'])
     * @param  address  address of tree item
     * @return array   transformed address
     */
    protected function parseaddress(&$address){
      $address =
        is_string($address)
        ? explode('.',$address)
        : $address;
    }

  }
