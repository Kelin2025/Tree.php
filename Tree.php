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
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return  mixed   returns tree item
     */
    public function get($address){
      $this->parseaddress($address);
      $key = array_shift($address);
      return 
        !array_key_exists($key,$this->array)
        ? null
        : (count($address) > 0
          ? $this->get($address,$this->array[$key])
          : $this->array[$key]
        );
    }

    /**
     * Set tree item
     * @param   address  address of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return  mixed   returns tree array
     * @see     if the tree already contains the element
     *          it WILL be replaced
     */
    public function set($address,$val,$arr=null){
      if($arr == null) $arr = $this->array;
      $this->parseaddress($address);
      $key = array_shift($address);
      if(!is_array($arr)){
        $arr = [];
      }
      $item = &$arr[$key];
      $item = 
        count($address) > 0
        ? $this->set($address,$val,$item)
        : $val;
      return $this->array = $arr;
    }

    /**
     * Set tree item
     * @param   address  address of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return  mixed   returns tree array
     * @see     if the tree already contains the element
     *          it WILL NOT be replaced.
     */
    public function add($address,$val,$arr=null){
      if($arr == null) $arr = $this->array;
      $this->parseaddress($address);
      $key = array_shift($address);
      if(!empty($arr) && !is_array($arr)){
        $arr = [$arr];
      }
      $item = &$arr[$key];
      $item = 
        count($address) > 0
        ? $this->add($address,$val,$item)
        : (!empty($item) ? [$item,$val] : $val);
      return $this->array = $arr;
    }

    /**
     * Remove tree item
     * @param   address  address of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return  array   returns updated tree
     */
    public function remove($address,$arr=null,$first=true){
      if($arr == null) $arr = $this->array;
      $this->parseaddress($address);
      $key = array_shift($address);
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
      return $this->array = $arr;
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
        !array_key_exists($key,$array)
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
