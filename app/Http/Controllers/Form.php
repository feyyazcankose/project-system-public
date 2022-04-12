<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\FormItem;
class Form extends Controller
{
    public $action;
    public $method;
    public $title;
    public $inputs=[];
    public $enctype=false;
    public $type,$name,$placeholder,$label,$required=true,$class="form-control",$value=null,$options=[],$min=null,$max=null,$maxLength=null;

    public function __construct($action,$title,$method, $enctype=false){
        $this->action = $action;
        $this->title = $title;
        $this->method = $method;
        $this->enctype = $enctype;
    }
    public function inputAdd(){
        array_push($this->inputs,[
            'type'=>$this->type,
            'name'=>$this->name,
            'placeholder'=>$this->placeholder,
            'label'=>$this->label,
            'class'=>$this->class,
            'value'=>$this->value,
            'required'=>$this->required,
            'options'=>$this->options,
            'min'=>$this->min,
            'max'=>$this->max,
            'maxlength'=>$this->maxLength
        ]);
        $this->delete();

    }

    public function option($value,$selected=false){   
        array_push($this->options,[
            'value'=>$value,
            'selected'=>$selected
        ]);
    }

    public function groupItem($value,$label,$id="",$selected=false){   
        array_push($this->options,[
            'value'=>$value,
            'id'=>rand().''.$id,
            'label'=>$label,
            'checked'=>$selected
        ]);
    }

    public function submitItem($value,$class){
        array_push($this->inputs,[
            'type'=>"submit",
            'class'=>$class,
            'value'=>$value
        ]);
    }
   
    public function clear(){
        $this->type=null;
        $this->name=null;
        $this->placeholder=null;
        $this->label=null;
        $this->class="form-control";
        $this->value=null;
        $this->required=true;
        $this->options=[];
        $this->min=null;
        $this->max=null;
        $this->maxLength=null;
    }

    public function delete() {
        
            $index=count($this->inputs)-1;
            foreach($this->inputs[$index] as $key=>$value)
            {
                if($value==null)
                    unset($this->inputs[$index][$key]);
            }
            
        $this->clear();
    }
}
