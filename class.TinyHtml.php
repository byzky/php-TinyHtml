<?php


/**
 *
 */
class TinyHtml
{
  private $html;
  private $skips = [
    'code',
    'pre',
    'textarea',
    'script'
  ];

  private $tosEx = [];
  private $toeEx = [];
  public $savings = 0;
  public $orginalSize = 0;
  public $minSize = 0;

  function __construct(String $html,array $skips = [])
  {
    if($skips != []) $this->skips = $skips;

    foreach ($this->skips as $v) {
      $this->tosEx[] = "\<$v(.*?)\>";
      $this->toeEx[] = "\<\/$v\>";
    }
    $this->tosEx = '/'.join('|',$this->tosEx).'/';
    $this->toeEx = '/'.join('|',$this->toeEx).'/';

    $this->orginalSize = strlen($this->html);

    $this->html = explode("\n",$html);
    $this->removeComments();
    $this->buildHtml();
    $this->repairHtml();

    $this->minSize = strlen($this->html);
    $this->savings = (100 - ($new / $old) * 100);
  }

  public function __toString()
  {
    return $this->html;
  }

  private function removeComments()
  {
    $search = array(
      '/^\s+/s',            // ( + )<tag...
      '/\>[^\S ]+/s',       // strip whitespaces after tags, except space
      '/[^\S ]+\</s',       // strip whitespaces before tags, except space
      '/(\s)+/s',           // shorten multiple whitespace sequences
      '/<!--(.|\s)*?-->/',  // Remove HTML comments
      '/\>(\s)+\</'         // remove >( + )<
    );
    $replace = array(
      '',
      '>',
      '<',
      '\\1',
      '',
      '><'
    );

    foreach ($this->html as $line => $val) {
      $this->html[$line] = preg_replace($search, $replace, $val);
    }
  }

  private function buildHtml()
  {
    $buff = "";
    $skip = false;
    foreach ($this->html as $line => $val) {
      if(preg_match($this->tosEx, $this->html[$line]))
        $skip = true;

      $buff .= $this->html[$line];

      if($skip == true && preg_match($this->toeEx, $this->html[$line]))
        $skip = false;
      if($skip) $buff .= "\n";
    }
    $this->html = $buff;
  }

  public function repairHtml()
  {
    $search = array(
      '/([\'\"])(\w+)\=([\'\"])/s'
    );
    $replace = array(
      '$1 $2=$3'
    );
    $this->html = preg_replace($search, $replace, $this->html);
  }

}


?>
