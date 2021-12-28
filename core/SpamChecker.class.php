<?php

require_once('VowCon.php');

class SpamChecker {
  function SpamChecker($VowCon=NULL) {
    if(is_null($VowCon))
      $VowCon = new VowConAnalyzer();
    $this->VowCon = $VowCon;
    $this->ignored_param_names = array();
  }
  function LoadText($text) {
    $this->VowCon->LoadText($text);
  }
  function GetTextStatus() {
    return $this->VowCon->GetTextStatus();
  }
  function Accepted() {
    foreach($_REQUEST as $name => $value) {
      if(is_numeric($value)) continue;   # ignore numbers
      if(!trim($value)) continue;        # ...and blanks
      if(in_array($name,$this->ignored_param_names)) continue;
      $this->VowCon->AppendText($value);
    }
    return $this->VowCon->TextIsValid();
  }
  function GetParamStatus($ParameterName) {
    # Possible return values:
    # "Undefined", "Numeric", "Empty", "Valid", "Invalid: <msg>"
    if(isset($_REQUEST[$ParameterName])) {
      $value = $_REQUEST[$ParameterName];
      if(is_numeric($value)) return 'Numeric';
      if(!trim($value)) return 'Empty';
      $this->LoadText($value);
      return $this->VowCon->GetTextStatus();
    }
    return 'Undefined';
  }
  function GetParamScore($ParameterName) {
    if(isset($_REQUEST[$ParameterName])) {
      $value = $_REQUEST[$ParameterName];
      if(is_numeric($value)) return 0;
      if(!trim($value)) return 0;
      $this->LoadText($value);
      $this->VowCon->CalcTextStats();
      return $this->VowCon->TextStats->MaxScore;
    }
    return false;
  }
  function ParamIsValid($ParameterName) {
    if(isset($_REQUEST[$ParameterName])) {
      $value = $_REQUEST[$ParameterName];
      if(is_numeric($value)) return true;
      if(!trim($value)) return true;
      $this->LoadText($value);
      return $this->VowCon->TextIsValid();
    }
    return false;
  }
  function Ignore($ParameterName) {
    $this->ignored_param_names[] = $ParameterName;
  }
}

?>
