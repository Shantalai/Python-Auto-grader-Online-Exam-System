<?php

$action = $_POST["action"];
$funcName = $_POST["funcName"];
$funcArgs = $_POST["funcArgs"];
$funcOper = $_POST["funcOper"];
$funcTopic = $_POST["funcTopic"];
$funcDiff = $_POST["funcDiff"];
$funcConst = $_POST["funcConst"];
$testcase_inputs = $_POST["testcase_inputs"];
$testcase_outputs = $_POST["testcase_outputs"];
$examName = $_POST["examName"];
$completed = $_POST["completed"];
$auto_graded = $_POST["auto_graded"];
$graded = $_POST["graded"];
$qSet = $_POST["qSet"];
$pSet = $_POST["pSet"];
$answers = $_POST["answers"];
$comments = $_POST["comments"];
$finalGrade = $_POST["finalGrade"];
$qID = $_POST["qID"];
$qGrade = $_POST["qGrade"];
$autoGrade = $_POST["autoGrade"];
$changeGrade = $_POST["changeGrade"];
$changeType = $_POST["changeType"];
$search = $_POST["search"];
$topicFilter = $_POST["topicFilter"];
$difFilter = $_POST[ "difFilter"];

if($action == 'add'){
    $data = array("action" => $action,
                "funcName" => $funcName, 
                "funcArgs" => $funcArgs, 
                "funcOper" => $funcOper, 
                "funcTopic" => $funcTopic,
                "funcDiff" => $funcDiff,
                "funcConst" => $funcConst,
                "testcase_inputs" => $testcase_inputs,
                "testcase_outputs" => $testcase_outputs
                );
}
elseif($action == 'newExam'){
    $data = array("action" => $action,
                "examName" => $examName,
                "completed" => $completed,
                "auto_graded" => $auto_graded,
                "graded" => $graded,
                "qSet" => $qSet,
                "pSet" => $pSet
                );
}
elseif($action == 'loadExam'){
    $data = array("action" => $action,
                "examName" => $examName
                );
}


elseif($action == 'gradeThis'){
    $data = array( "action" => $action,
                "examName" => $examName,
                "completed" => $completed,
                "answers" => $answers,
                );
}

elseif($action == 'listExams'){
    $data = array("action" => $action
                );
}
elseif($action == 'pullExam'){
    $data = array("action" => $action,
                "examName" => $examName
                );
}
elseif($action == 'teacherGrade'){
    $data = array("action" => $action,
                "examName" => $examName,
                "graded" => $graded,
                "comments" => $comments,
                "finalGrade" => $finalGrade
                );
}
elseif($action == 'gradeChange'){
    $data = array("action" => $action,
                "examName" => $examName,
                "qID" => $qID,
                "qGrade" => $qGrade,
                "autoGrade" => $autoGrade,
                "changeGrade" => $changeGrade,
                "changeType" => $changeType
                );
}
elseif($action == 'pullFinal'){
    $data = array("action" => $action,
                "examName" => $examName
                );
}
elseif($action == 'delete'){
    $data = array("action" => $action
                );
}
elseif($action == 'populate'){
    $data = array("action" => $action,
                "search" => $search,
                "topicFilter" => $topicFilter,
                "difFilter" => $difFilter
                );
}

$dataToSend = http_build_query($data);
//start CURL and send values to middle
$curl = curl_init(); 
curl_setopt($curl, CURLOPT_URL, "https://web.njit.edu/~pkl8/back_logic.php");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $dataToSend);

//get and echo response back to front
$response = curl_exec($curl);
curl_close($curl);
echo $response;
?>
