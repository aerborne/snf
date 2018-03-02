<?php
class Validator
{
  protected $errorHandler;

  protected $items;

  protected $rules = ['required','minlength','maxlength','email','alnum','match'];

  public $messages = [
        'required'   => 'The :field  field is required',
        'minlength'  => 'The :field  field must be a minimum of  : satisifer length',
        'maxlength'  => 'The :field  field must be a maximum of  : satisfier length',
        'email'      => 'That is not a valid email address',
        'alnum'      => 'That :field field  must be alphanumeric',
         'match'      => 'The field :field must match the : satisifer field'


  ];

  public function __construct(ErrorHandler $errorHandler)
  {
     $this->errorHandler = $errorHandler;
  }

  public function check($items,$rules)
  {
     $this->items = $items;
    foreach ($items as $item => $value) {
         if(in_array($item,array_keys($rules)))
         {
           $this->validate([
              'field' => $item,
              'value' => $value,
              'rules' => $rules[$item]

           ]);
         }
      }
      return $this;
  }
public function fails()
{
  return $this->errorHandler->hasErrors();
}
  public function errors()
  {
    return $this->errorHandler;
  }

  protected function validate($item)
  {
    $field = $item['field'];

    foreach ($item['rules'] as $rule => $satisifer)
     {

           if(in_array($rule,$this->rules))
           {
               if(!call_user_func_array([$this,$rule],[$field,$item['value'],$satisifer]))
                {
                 $this->errorHandler->addError(
                   str_replace([':field','satisifer'], [$field,$satisifer],$this->messages[$rule]),
                   $field

                  );
                }

           }
       }
    }
    protected function required($field,$value,$satisifer)
    {
      return !empty(trim($value));
    }
    protected function minlength($field,$value,$satisifer)
    {
      return mb_strlen($value) >= $satisifer;
    }
    protected function maxlength($field,$value,$satisifer)
    {
      return mb_strlen($value) <= $satisifer;
    }
    protected function email($field,$value,$satisifer)
    {
      return filter_var($value,FILTER_VALIDATE_EMAIL);
    }
    protected function alnum($field,$value,$satisifer)
    {
      return ctype_alnum($value);
    }
    protected function match($field,$value,$satisifer)
    {

        return $value === $this->items[$satisifer];
    }



}

 ?>
