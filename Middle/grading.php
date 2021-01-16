<?php
/*-----------getting this info from the back------------------------------------*/

$qID = $_POST["qID"];
$funcName = $_POST["funcName"];
$testcase_inputs = $_POST["testcase_inputs"];
$testcase_outputs = $_POST["testcase_outputs"];
$qPoints = $_POST["qPoints"];
$answers = $_POST["answers"];
$constraints = $_POST["constraints"];


// $qID = 1;
// $funcName = "operations";
// $testcase_inputs = "'+',3,5~'-',3,2~'*',5,6~'/',6,3";
// $testcase_outputs = "8~1~30~2.0";
// $qPoints = 25;
// $answers = "def operations(op, a, b):
//         if op == '+':
//             return a + b
//         elif op == '-':
//                 return a - b
//         elif op == '*':
//                 return a * b
//         elif op == '/':
//                 return a / b
//         else:
//                 return -1";
// $constraints = "";

/*------------calling function grader------------------------------------------ */
$questionGraded = grader($answers, $funcName, $testcase_inputs, $testcase_outputs, $qPoints, $qID, $constraints);
echo json_encode($questionGraded);

/*----------------------function that grades 1 question at a time------------------*/
function grader($answers, $funcName, $testcase_inputs, $testcase_outputs, $qPoints, $qID, $constraints){
$grade = $qPoints;
$nameFlag = "no";
$wrongFuncName = "";
$semicolonFlag = "no";
$constraintFlag = "no";
$testCaseFlag = [];
$studentTestCaseOutput = [];
$test = "Midterm";

/*---------------------- checking function name --------------------------------- */
$studentAns = ltrim($answers); //trimming white space from beginning
$getFuncName = preg_split("/\s+|\(|:/", $studentAns); //regex to get function name
$studentFuncName = $getFuncName[1];

if($studentFuncName != $funcName){
    $nameFlag = "yes";
    $wrongFuncName = $studentFuncName;
    $grade -= 5; //taking off 5 points
}

/* -------------------- checking for semicolons----------------------------------- */
if(preg_match("/\bdef\b|\bfor\b|\bif\b|\belse\b|\bwhile\b|\belif\b/", $studentAns)){
    $separator = "\r\n";
    $eachLine = strtok($studentAns, $separator);
    $newLine = "";
    while ($eachLine !== false) {
        if(preg_match("/\bdef\b|\bfor\b|\bif\b|\belse\b|\bwhile\b|\belif\b/", $eachLine)){
            //check if it ends with a colon
            if (preg_match('/:$/', $eachLine)) {
              $newLine .= $eachLine . $separator;
            }
            else{
              //add the colon at the end of the line
              $newLine .= $eachLine . ":" . $separator;
              $grade -= 2;
              $semicolonFlag = "yes"; 
            }
        }
        else {
            $newLine .= $eachLine . $separator;
        }
        $eachLine = strtok( $separator );
    }
    $studentAns = $newLine;
}
/*--------------------- checking constraints -------------------------------------*/
switch ($constraints) {
    case "for":
        if(preg_match("/\bfor\b/", $studentAns)){
            break;
        }
        else{
            $constraintFlag = "yes";
            $grade -= 3;
            break;    
        }
    case "while":
        if(preg_match("/\bwhile\b/", $studentAns)){
            break;
        }
        else{
            $constraintFlag = "yes";
            $grade -= 3;
            break;
        }
    case "print":
        if(preg_match("/\bprint\b/", $studentAns)){
            break;
        }
        else{
            $constraintFlag = "yes";
            $grade -= 3;
            break;    
        }
    default:
        $grade += 0; 
        
} 
/*------------running Student's answer on Python interpreter--------------------*/
//going through testcase_inputs and outputs
$newParams = $testcase_inputs; 
$temp = explode("~", $newParams);
$testcaseCount = count($temp);
$testcase_outputs = explode("~", $testcase_outputs);

if(preg_match("/\bprint\b/", $studentAns)){
    $studentAns = preg_replace("/\bprint\b/", "return", $studentAns);
}

for($i = 0; $i < $testcaseCount; $i++){
  $newParams = $temp[$i]; 
  $eachOutput = $testcase_outputs[$i];
  

  $pyFile = "$test.py"; //create .py file
  file_put_contents($pyFile, $studentAns. "\n" . "print($studentFuncName($newParams))");
  $runpython = exec("python $test.py");
  //"SyntaxError: invalid syntax" in python
  if ($runpython == ""){
      if ($studentFuncName == $funcName){
          $grade = 5; //petty 5 points for correct funcName
      }
      else{
          $grade = 0; // means python file did not run + funcName is wrong  
          }
      break;
    }
  else{
      if ($runpython != $eachOutput){
          $grade -= 4; //taking off 4 points
          array_push($testCaseFlag, "yes"); 
          array_push($studentTestCaseOutput, $runpython); 
        
      }
      else{
          $grade += 0; // leave it alone  
          array_push($testCaseFlag, "no");
          array_push($studentTestCaseOutput, $runpython); 
      }
  }
}

return array ("qID"=> $qID,
              "grade"=>$grade,
              "nameFlag"=>$nameFlag, 
              "wrongFuncName"=> $wrongFuncName,
              "constraintFlag"=>$constraintFlag,
              "semicolonFlag" =>$semicolonFlag,
              "testCaseFlag"=>implode("~",$testCaseFlag),
              "studentTestCaseOutput"=>implode("~",$studentTestCaseOutput));

$file = 'file.txt';
file_put_contents($file,print_r($array,true));
}
/*----------------------------end of the grade function----------------------------*/
/*-------------------------------------------------------------------------------- */

?>
