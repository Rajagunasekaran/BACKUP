<?php
/**
 * JSON extension class.
 *
 *
 * @package    Extension
 * @author     Emanuele Ricci
 * @copyright  (c) 2010 Emanuele Ricci
 * @license    http://www.designfuture.it
 */
class CArJSON {
	
	private $owner;
	private $relations;
	private $relations_allowed;
	private $attributes;
	private $jsonString;
        private $isarray = false;
	private $modelArray;
        private $iskeyBasedArray = false;
        private $keyFieldname = 'id';
	/*
	 * array ( 
	 * 		'root'=> array of attributes,
	 * 		'relation_name' => array of attributes,
	 * )
	 * 
	 * if a relation_name is not setted or defined we will take all attributes
	 * 
	 */
	
	public function toJSON( $model, $relations, 
                $attributesAllowed=array(), 
                $isarray = false, $iskeyBasedArray = false,
                $keyFieldname = 'id'
        )
        {
		$this->owner = $model;
		$this->relations_allowed = $relations;
		$this->attributes = $attributesAllowed;                
		$this->jsonString = '';
                $this->isarray = $isarray;
                $this->modelArray = array();
                $this->iskeyBasedArray = $iskeyBasedArray;
                $this->keyFieldname = $keyFieldname;
		if ( !is_array($this->owner) ) {
			$this->owner = array();
			$this->owner[] = $model;
		}
		return $this->getJSON();
	}
	
	private function getJSON() {
                $tmpKey = $this->keyFieldname;
                $this->modelArray = array();
		foreach ( $this->owner as $o ) {
			$result = $this->getJSONModel( $o );
			if ( !$result ) return false; 
                        if($this->isarray)
                        {
                            if($this->iskeyBasedArray)
                            {
                                $this->modelArray[$o->$tmpKey] = $result;
                            }
                            else
                            {
                                $this->modelArray[] = $result;
                            }
                        }
			else $this->jsonString .= $result . ',';
		}
                if($this->isarray)
                {
                    return $this->modelArray;
                }
                else
                {
                    $this->jsonString = substr($this->jsonString, 0, -1);
                    $this->jsonString = '['.$this->jsonString.']';
                    return $this->jsonString;
                }
	}
	
	private function getJSONModel( $obj ) {
            $tmpKey = $this->keyFieldname;
		if (is_subclass_of($obj,'CActiveRecord')){                        
			$attributes = $obj->getAttributes( empty($this->attributes['root'])?null:$this->attributes['root'] );
			$this->relations = $this->getRelated( $obj );
                        foreach($this->relations as $relname => $relation)//gsm
                        {
                            $tmparray = array();
                            $tmpsubarrayname = array();
                            $tmpsubarrayname[$relname] = array();
                            foreach($relation as $single)
                            {
                                if(  is_array( $single ))
                                {
                                    $tmparray1 = array();
                                    if(!empty($single[0]))
                                    {
                                        $tmparray1 = $single[0]->getAttributes( 
                                                    empty($this->attributes[$relname])?null:$this->attributes[$relname]
                                                    );
                                        foreach($single as $key => $objs)
                                        {
                                            if($key !== 0)
                                            {
                                                $tmparray1[$key] = array();
                                                if(!empty($objs))
                                                {
                                                    foreach($objs as $obj)
                                                    {
                                                        if($this->iskeyBasedArray)
                                                        {
                                                            $tmparray1[$key][$obj->$tmpKey] =  $obj->getAttributes( 
                                                            empty($this->attributes[$key])?null:$this->attributes[$key]
                                                            );
                                                        }
                                                        else
                                                        {
                                                            $tmparray1[$key][] =  $obj->getAttributes( 
                                                            empty($this->attributes[$key])?null:$this->attributes[$key]
                                                            );
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }                                    
                                    if($this->iskeyBasedArray)
                                    {
                                        if(!empty($single[0]))
                                        {
                                            $tmparray[$single[0]->$tmpKey] = $tmparray1;
                                        }
                                        else
                                        {
                                            $tmparray[] = $tmparray1;
                                        }
                                    }
                                    else
                                    {
                                        $tmparray[] = $tmparray1;
                                    }
                                }
                                else
                                {
                                    if($this->iskeyBasedArray)
                                    {
                                        $tmparray[$single->$tmpKey] = $single->getAttributes( 
                                            empty($this->attributes[$relname])?null:$this->attributes[$relname]
                                            );
                                    }
                                    else
                                    {
                                        $tmparray[] = $single->getAttributes( 
                                            empty($this->attributes[$relname])?null:$this->attributes[$relname]
                                            );
                                    }
                                    if(strtolower($relname) === 'statusmaster')
                                    {
                                        $attributes['status'] = $single->display;
                                    }
                                }
                            }
                            $attributes[$relname] = $tmparray;                            
                        }
                        //$jsonDataSource = array('attributes'=>$attributes,'relations'=>$this->relations);
			$jsonDataSource = $attributes;//gsm
			return ($this->isarray?$jsonDataSource:CJSON::encode($jsonDataSource));
		}
		return false;
	}
	
	private function getRelated( $m )
	{	
		$related = array();
		$obj = null;
		$md=$m->getMetaData();
                
		foreach($md->relations as $name=>$relation){
                        $relfound = false;
                        $subrelationsary = array();
                        foreach ($this->relations_allowed as $wantedrelation)
                        {
                            if(  !is_array( $wantedrelation ) )
                            {
                                if ( $name === $wantedrelation )
                                {
                                    $relfound = true;
                                    break;  
                                }
                            }
                            else
                            {
                                if ( array_key_exists($name, $wantedrelation) )
                                {
                                    $subrelationsary = $wantedrelation[$name];
                                    $relfound = true;
                                    break;
                                }
                            }
                        }
			if($relfound)
                        {
                            $obj = $m->getRelated($name);
                            $tmpObjs = $obj instanceof CActiveRecord ? array($obj) : $obj;
                            if(empty($subrelationsary))
                            {                               
                                $related[$name] = $tmpObjs;
                                //gsm $attrToTake = empty($this->attributes[$name]) ? NULL : $this->attributes[$name];
                                // gsm $related[$name] = $obj instanceof CActiveRecord ? $obj->getAttributes($attrToTake) : $obj;
                            }
                            else
                            {
                                
                                if(count($tmpObjs) === 0)
                                {
//                                    $tmpary[] = array();
//                                    foreach($subrelationsary as $subrelation)
//                                    {                                        
//                                        $tmpary[$subrelation] = array();
//                                    }
                                    $tmpary = array();
                                    $related[$name] = $tmpary;
                                }else
                                {
                                    foreach($tmpObjs as $tmpObj)
                                    {
                                        $tmpary = array();
                                        $tmpary[] = $tmpObj;
                                        foreach($subrelationsary as $subrelation)
                                        {
                                            $subrelobj = $tmpObj->getRelated($subrelation);
                                            $subrelobj = $subrelobj instanceof CActiveRecord ? array($subrelobj) : $subrelobj;
                                            $tmpary[$subrelation] = $subrelobj;
                                        }
                                        $related[$name][] = $tmpary;
                                    }
                                }                                
                            }
                        }
		}
	    return $related;
	}
}