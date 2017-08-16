<?php

class Sharpie{
    
    
    //getters
    public function __get($name){
        if(method_exists($this , 'get_'.$name)){
            return $this->{'get_'.$name}();
        } else if(property_exists($this, $name)){
            return $this->{$name};
        }
        
    }
    
    //setters
    public function __set($name, $value) {
        if(method_exists($this , 'set_'.$name)){
            $this->{'set_'.$name}($value);
        } else if(property_exists($this, $name)){
            $this->{$name} = $value;
        }
        
    }
      
    public function public_getters(){
        $methods = array();
        foreach(get_class_methods($this) as $method){
            if(strpos($method , 'get_') == 0 && strpos($method , 'get_')!== False){
                $methods[] = str_replace('get_' , '' , $method);
            }
        }
        
        return $methods;
    }
    
    public function public_setters(){
        $methods = array();
        foreach(get_class_methods($this) as $method){
            if(strpos($method , 'set_') == 0 && strpos($method , 'set_')!== False){
                $methods[] = str_replace('set_' , '' , $method);
            }
        }
        
        return $methods;
    }
    
    public function is_get_public($name){
        if(method_exists($this, 'get_'.$name)){
            return True;
        }
        
        return False;
    }
    
    public function is_set_public($name){
        if(method_exists($this, 'set_'.$name)){
            return True;
        }
        
        return False;
    }
}