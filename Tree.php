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
     * @param   adress  adress of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return  mixed   returns tree item
     */
    public function get($adress){
      $this->parseAdress($adress);
      $key = array_shift($adress);
      return 
        !array_key_exists($key,$this->array)
        ? null
        : (count($adress) > 0
          ? $this->get($adress,$this->array[$key])
          : $this->array[$key]
        );
    }

    /**
     * Set tree item
     * @param   adress  adress of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return  mixed   returns tree array
     * @see     if the tree already contains the element
     *          it WILL be replaced
     */
    public function set($adress,$val,$arr=null){
      if($arr == null) $arr = $this->array;
      $this->parseAdress($adress);
      $key = array_shift($adress);
      if(!is_array($arr)){
        $arr = [];
      }
      $item = &$arr[$key];
      $item = 
        count($adress) > 0
        ? $this->set($adress,$val,$item)
        : $val;
      return $this->array = $arr;
    }

    /**
     * Set tree item
     * @param   adress  adress of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return  mixed   returns tree array
     * @see     if the tree already contains the element
     *          it WILL NOT be replaced.
     */
    public function add($adress,$val,$arr=null){
      if($arr == null) $arr = $this->array;
      $this->parseAdress($adress);
      $key = array_shift($adress);
      if(!empty($arr) && !is_array($arr)){
        $arr = [$arr];
      }
      $item = &$arr[$key];
      $item = 
        count($adress) > 0
        ? $this->add($adress,$val,$item)
        : (!empty($item) ? [$item,$val] : $val);
      return $this->array = $arr;
    }

    /**
     * Remove tree item
     * @param   adress  adress of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return  array   returns updated tree
     */
    public function remove($adress,$arr=null,$first=true){
      if($arr == null) $arr = $this->array;
      $this->parseAdress($adress);
      $key = array_shift($adress);
      foreach($arr as $item => $val){
        if($item === $key){
          if(count($adress) > 0){
            $arr[$item] = $this->remove($adress,$arr[$item],false);
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
     * @param   adress  adress of tree item. It can be written:
     *                  as an array ['path','to','item']
     *                  or string 'path.to.item'
     * @return   bool   returns true if item exists and false if not.
     */
    public function has($adress,$array=null){
      if($array == null) $array = $this->array;
      $this->parseAdress($adress);
      $key = array_shift($adress);
      return 
        !array_key_exists($key,$array)
        ? false
        : (count($adress) > 0
          ? $this->has($adress,$array[$key])
          : true
        );
    }

    /**
     * Helper function
     * Transforms string adress (e.g 'path.to.item') to array (e.g ['path','to','item'])
     * @param  adress  adress of tree item
     * @return array   transformed adress
     */
    protected function parseAdress(&$adress){
      $adress =
        is_string($adress)
        ? explode('.',$adress)
        : $adress;
    }

  }
