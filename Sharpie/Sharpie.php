<?php

abstract class Sharpie implements JsonSerializable{
    
    
    //getters
    public function &__get($name){
        if(method_exists($this , 'get_'.$name)){
            return $this->{'get_'.$name}();
        } else if($this->is_public($name)){          
           return $this->{$name};
        } else {
            throw new Exception("Property ".$name." is not public and there are no getters defined");
        }
        
    }
    
    //setters
    public function __set($name, $value) {
        if(method_exists($this , 'set_'.$name)){
            $this->{'set_'.$name}($value);
        } else if($this->is_public($name)){
            $this->{$name} = $value;
        } else {
            throw new Exception("Property ".$name." is not public and there are no setters defined");
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
    
    
    //Serialization
    public function jsonSerialize() {
        $obj = new \stdClass();
        
        //iterates through public properties
        foreach(call_user_func('get_object_vars', $this) as $property){
            $obj->{$property} = $this->{$property};
        }
        
        foreach (get_class_methods($this) as $item){
                if(method_exists($this, $item)){
                    $method = $this->method_getter($item);
                  
                    if($method != null){   
                    
                        $obj->{str_replace("get_", '', $method)} = $this->{$method}();
                    }
                }
            
        }
        
        
        return $obj;
    }
    
    protected function is_public($tested_property){
        foreach(call_user_func('get_object_vars', $this) as $property){
            if($tested_property == $property){
                return TRUE;
            }
        }
        
        return FALSE;
    }


    protected function method_getter($method){
        if(strpos($method , 'get_') == 0 && strpos($method , 'get_')!== False){
            return $method;
            
        }
        
        return null;
    }
}