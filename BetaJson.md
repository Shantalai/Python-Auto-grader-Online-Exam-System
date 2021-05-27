## JSON specifications for Beta ##  

### Add Question: ### 

>onload 

will send:

```
{'action': 'populate',
 'search': '',        // empty if nothing entered into search bar 
 'topicFilter': '',  // will be  'allTop'  if need questions with all topics 
 'difFilter': ''    // will be  'allDif'  if want questions of all difficulties 
 } 

```

need back:

*when check if `action == populate`*

```
{
  {qID':'', 'funcName':'', 'funcArgs':'', 'funcOper':''},
  {'qID':'', 'funcName':'', 'funcArgs':'', 'funcOper':''},
  {'qID':'', 'funcName':'', 'funcArgs':'', 'funcOper':''}
 //however many questions in Question Bank
}

```

>onsubmit

will send:

```
{
    'action': 'add',
    'funcName': '',
    'funcArgs': '',
    'funcOper': '',
    'funcTopic': '',
    'funcDiff':  '',
    'funcConst': '', // added constraint per each question
    'testcase_inputs': '',
    'testcase_outputs': ''
 }

```
need back:

*when check if `action == add`*

```
{
  qID':'', // where this id of the question that was just inserted into DB on action "add"

  'funcName':'', 
  'funcArgs':'', 
  'funcOper':''
}
```

### Create Exam: ###

>onload

will send:

```
{'action': 'populate',
 'search': '',        // empty if nothing entered into search bar 
 'topicFilter': '',  // will be  'allTop'  if need questions with all topics 
 'difFilter': ''    // will be  'allDif'  if want questions of all difficulties 
 } 

```

need back:

*when check if `action == populate`*

```
{
  {qID':'', 'funcName':'', 'funcArgs':'', 'funcOper':''},
  {'qID':'', 'funcName':'', 'funcArgs':'', 'funcOper':''},
  {'qID':'', 'funcName':'', 'funcArgs':'', 'funcOper':''}
 //however many questions in Question Bank
}

```

>onsubmit 

will send:

```
{
    'action':'newExam',
    'examName' : examName,
    'completed': 'no',
    'auto_graded':'no,
    'graded': 'no',
    'qSet' : [], // where is array of question ids, same as key from Question table for that question in DB
    'pSet' : [] // where is array of points assignd to that question when added to exam, index in qSet match pSet !
    
 }


```

need back:

*when check if `action == newExam`*

`{'examName:''}`

### Exam List Student/Instructor ###

>onload

will send:

`{'action': 'listExams'}`

need back:

*when check if `action == listExams`*

```

{ 'examName':'',
  'completed': 'yes/no',
  'graded': 'yes/no'
  }
  
  ```

### Take Exam: ###

>onload

will send:

```
 {
    'action':'loadExam',
    'examName':''
  }

```

need back:

*when check if `action == loadExam`*

```
 { 
    "examName":"",
     "questions":"{
        {qID:"", "funcName:"", "funcArgs":"", "funcOper":"", "qPoints":""},// qPoints points assigned to that specific quest.
        {qID:"", "funcName:"", "funcArgs":"", "funcOper":"", "qPoints":""},
        {qID:"", "funcName:"", "funcArgs":"", "funcOper":"", "qPoints":""}
        }"
    }

```

>onsubmit

will send:

```
{
    'action':'gradeThis,
    'examName':'',
    'completed':'yes',
    'answers':{
           {'qID':'', 'answerText':''},
           {'qID':'', "answerText':''},
       }
 }

```

need back:

*when check if `action == loadExam`*

`{'autoGrade':''} //where is initial grade by autograder before professor review ` 

### to remember name from examListInstructor ###

on click will send:

```

{ 
  'action':'saveName',
  'examName':''
  }

```

will nedd back:

`{'saved':'yes/no'}`



### autoGrade UPDATED AGAIN ###

on load sending:

```
{ 
     'action': 'pullExam',
     'examName':''
     
  }
  
  ```
  
need back

```
{       
        autoGrade: '',
        questions: {
                    {
                        qID:'',
                    funcName:'',
                    funcArgs:'', 
                    funcOper:'',
                    'funcConst':'',
                    testcase_inputs: '[]',
                    testcase_outputs:'[]',
                    testcase_flags: '[]', // array like [yes, no, yes, no] YES = FAIL
                    wrongTestCaseOutputs: '[]', // array of outputs 
                    qPoints:'',
                    qGrade:'',
                    answerText:'',
                    nameFlag:'',// yes - if faild
                    wrongFuncName:'',
                    semicolonFlag,'',// yes - if faild
                    constraintFlag,'', //yes - if faild
                    }
                }
        
    }
    
 ```

on submit sending:

```
{
      'action': 'teacherGrade',
      'examName':'',
      'graded':'yes',
      'comments':{
              {qID:'', comment:''}
              },
      'finalGrade':''
    }
    
```  

need back:

`{'status':'yes/no' } // indicating it went through and final grade was saved`

### finalGrade ###

on load sending:

```
{
        'action':'pullFinal',
        'examName':''
    }

```

need back:

```
 {   
        finalGrade: '',
        autoGrade: '',
        questions: {
                    {
                        qID:'',
                    funcName:'',
                    funcArgs:'', 
                    funcOper:'',
                    'funcConst':'',
                    testcase_inputs: '[]',
                    testcase_outputs:'[]',
                    testcase_flags: '[]', // array like [yes, no, yes, no] YES = FAIL
                    wrongTestCaseOutputs: '[]', // array of outputs 
                    qPoints:'',
                    qGrade:'', 
                    nameFlag:'',// yes - if faild
                    wrongFuncName:'',
                    comment: '',
                    semicolonFlag:'',// yes - if faild
                    constraintFlag:'', //yes - if faild
                    
                    'changeGrade':'', // ADDED the change number from when teacher changed grade
                    'changeType':'' // ADDED value saved after teacher changed grade, type of change will tell front in which                
                                     //    box to display change
                    }
                }
        
    }

```

### action gradeChange ###

will send

```
{ 
 'action': 'gradeChange', 
  'examName': '',  // name of exam to locate
  'qID':'', // name of question to locate
  'qGrade':'', // new value of qGrade to save for this question in this exam
  'autoGrade':'', // new value of autoGrade for this exam to save
  'changeGrade':'', // new field to add to the question and save this value (number teacher has inserted)
  'changeType':''  // new field to add to question and save value - for front to know which box to display change
  
  }
```

need back

```

{ 
  'qID':'',
  'qGrade':'',
  'autoGrade':''
  }
```


### Questions and Test cases ###


>Write a function named *DoubleIt()* that takes the following arguments *one integer* performs the following operations *multiply by 2* and returns the value.

*Input: 5*

*Output: 10*


*Input: 15*

*Output: 30*

>Write a function named *ModIt()* that takes the following arguments *one integer* performs the following operations *take mod 2 of that integer* and returns the value.

*Input: 6*

*Output: 0*


*Input: 5*

*Output:1*


on action
```
$dataForGrading = array("gradeAction" => "gradeAction",
                        "examName" => "examName"
              
);

```

need back: an array of json objects, each object representing everything about 1 question
```
[
      {qID:'', 
      funcName:"", 
      testcase_inputs:'', 
      testcase_outputs:'',
      qPoints:'',
      answer:''
      },
      {qID:'', 
      funcName:"fhj", 
      testcase_inputs:'', 
      testcase_outputs:'',
      qPoints:'',
      answer:''
      },
....
]


```




