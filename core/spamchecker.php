<?php
require_once('SpamChecker.class.php');

/* demo class, only for showing result, not to be used in prod */

class MyAnalyzer extends VowConAnalyzer {
  function HTMLReport() {
    if(!isset($this->TextStats))
      $this->CalcTextStats();
    if(!$this->TextStats)
      return '';  # No data to show, evaluates as "false"
    $Cols = array('Word'=>'word','Groups'=>'groupCount','Max'=>'groupMaxSize',
                  'Sum'=>'groupSum','SumSq'=>'groupSumSq',
                  'Distinct'=>'distinct','Score'=>'scoreStr');
    $trBG = '<tr style="background-color:'; # Note that < and " are both open
    $tdR = '<td style="text-align:right">';
    $res = '<table border="1"'.
           ' style="border-collapse:collapse;border:solid 1px black;">';
    $res.= $trBG.'#99f"><th>'.
          implode('</th><th>',array_keys($Cols)).
                  '</th></tr>';
    foreach($this->words as $word) {
      if(is_numeric($word)) continue;
      if(!trim($word)) continue;
      $w = $this->Stats($word);
      $w->scoreStr = sprintf('%.2f',$w->score);
      $res.= $trBG.
             ($w->score > $this->MaxWordScore ? '#f66':
             ($w->score > $this->BadWordLimit ? '#f96' :
             ($w->score > $this->MaxAvgScore  ? '#ff9' : ''))).';">';
      foreach($Cols as $name=>$prop)
        $res.= (($name=='Word') ? '<td>' : $tdR).$w->$prop.'</td>';
      $res.= '</tr>';
    }
    $dash = $tdR.'-</td>';
    $res.= $trBG.'#99f"><td>Max Score</td>'.$dash.$dash.$dash.$dash.$dash.
           $tdR.sprintf('%.2f',$this->TextStats->MaxScore).'</td></tr>';
    $res.= $trBG.'#99f"><td>Avg Score</td>'.$dash.$dash.$dash.$dash.$dash.
           $tdR.sprintf('%.2f',$this->TextStats->AvgScore).'</td></tr>';
    $res.= $trBG.'#99f"><td>Bad word %</td>'.$dash.$dash.$dash.$dash.$dash.
         $tdR.'<span style="color:'.
           ($this->TextStats->BadPercent > $this->MaxBadPercent ? 'red' : 'green').'">'.
           sprintf('%d',$this->TextStats->BadPercent).'%</span></td></tr>';
    $res.= $trBG.'white">'.
         '<th>Legend</th>'.
         '<td colspan="6">'.
         '<table style="font-size:70%;font-family:Verdana,sans-serif;"><tr>'.
           '<td style="background-color:#f66">&nbsp;&nbsp;&nbsp;</td>'.
           '<td>Above max word score ('.sprintf('%.2f',$this->MaxWordScore).')</td></tr>'.
           '<td style="background-color:#f96">&nbsp;&nbsp;&nbsp;</td>'.
           '<td>Above bad word limit ('.sprintf('%.2f',$this->BadWordLimit).')</td></tr>'.
           '<td style="background-color:#ff9">&nbsp;&nbsp;&nbsp;</td>'.
           '<td>Above max average score ('.sprintf('%.2f',$this->MaxAvgScore).')</td></tr>'.
           '</table>'.
         '</td>'.
         '</tr>';
    $res.= '</table>';
  return $res;
  }
}

if(count($_REQUEST)) {
  $SpamChk = new SpamChecker(new MyAnalyzer());
  $SpamChk->Ignore('sessionkey'); # example, see SpamChecker_test_1.php
  if(!$SpamChk->Accepted())
    # !! Report displayed for demo/debugging purpouses
    #    In a real app, log & redirect to either:
    # a) error page                       (user friendly but also spammer friendly)
    # b) same page as successfull submit  (stealthy, but possibly misleading for users)
    # c) reload page, displaying error    (perhaps too spammer friendly?)
    # d) site homepage                    (might be the best alternative in some cases)
    return;
}

?>
