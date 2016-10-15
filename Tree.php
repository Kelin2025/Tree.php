<?

  /* 
   * Tree.php
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
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return  mixed   returns tree item
     */
    public function get($address,$array=null){
      if($array == null) $array = $this->array;
      $this->parseaddress($address);
      $key = array_shift($address);
      return 
        !array_key_exists($key,$array) || $array[$key] == null
        ? null
        : (count($address) > 0
          ? $this->get($address,$array[$key])
          : $array[$key]
        );
    }

    /**
     * Set tree item
     * @param   address  address of tree item. It can be written:
     *                   as an array ['path','to','item']
     *                   or string 'path.to.item'
     * @param   val      value of tree item
     * @return  mixed    returns this
     * @see     if the tree already contains the element
     *          it WILL be replaced
     */
    public function set($address,$val){
      $arr = &$this->array;
      $this->parseaddress($address);
      foreach ($address as $key)
        $arr = &$arr[$key];
      $arr = $val;
      return $this;
    }

    /**
     * Set tree item
     * @param   address  address of tree item. It can be written:
     *                   as an array ['path','to','item']
     *                   or string 'path.to.item'
     * @param   val      value of tree item
     * @return  mixed    returns tree array
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
     * Remove tree item
     * @param   address  address of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return  array   returns updated tree
     */
    public function remove($address){
      $arr = &$this->array;
      $this->parseaddress($address);
      while(count($address) > 0){
        if(count($address) == 1)
          unset($arr[array_shift($address)]);
        else
          $arr = &$arr[array_shift($address)];
      }
      /*$key = array_shift($address);
      foreach($arr as $item => $val){
        if($item === $key){
          if(count($address) > 0){
            $arr[$item] = $this->remove($address,$arr[$item],false);
          }
          else {
            unset($arr[$item]);
            return $first ? $this->array = $arr : $arr;
          }
        }
      }
      return $this->array = $arr; */
    }

    /**
     * Check if tree item exists
     * @param   address  address of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return   bool   returns true if item exists and false if not.
     */
    public function has($address,$array=null){
      if($array == null) $array = $this->array;
      $this->parseaddress($address);
      $key = array_shift($address);
      return 
        !array_key_exists($key,$array) || $array[$key] == null
        ? false
        : (count($address) > 0
          ? $this->has($address,$array[$key])
          : true
        );
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
