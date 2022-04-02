<?php
//get tasklist array from POST
$task_list = filter_input(INPUT_POST, 'tasklist', 
        FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($task_list === NULL) {
    $task_list = array();
    
    $task_list[] = 'Write chapter';
    $task_list[] = 'Edit chapter';
    $task_list[] = 'Proofread chapter';
}

$action = filter_input(INPUT_POST, 'action');

$errors = array();

switch( $action ) {
    case 'Add Task':
        $new_task = filter_input(INPUT_POST, 'newtask');
        if (empty($new_task)) {
            $errors[] = 'Please enter task!';
        } else {
            array_push($task_list, $new_task);
        }
        break;

    case 'Delete Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be deleted!';
        } else {
            unset($task_list[$task_index]);
            $task_list = array_values($task_list);
        }
        break;

    case 'Modify Task':
        $task_index = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        if ($task_index === NULL || $task_index === FALSE) {
            $errors[] = 'The task cannot be Modified.';
        } else {
            $task_to_modify = $task_list[$task_index];
        }
        break;
    
    case 'Save Changes':
        $id = filter_input(INPUT_POST, 'modifiedtaskid', FILTER_VALIDATE_INT);
        $task = filter_input(INPUT_POST, 'modifiedtask');
        
        if($id === null || $id === FALSE)
        {
            $errors[] = 'The task cannot be saved!';
        }
        else if(empty($task) || $task === null)
        {
            $errors[] = 'Cannot save duplicate information!';
        }
        else
        {
            $task_list[$id] = $task;
        }
        
        break;
    
    case 'Cancel Changes':
        $task = '';
        break;
    
    case 'Promote Task':
        $id = filter_input(INPUT_POST, 'taskid', FILTER_VALIDATE_INT);
        
        if($id === null || $id === false)
        {
            $errors[] = 'The task does not exist!';
        }
        else if($task_list[$id] === $task_list[0])
        {
            $errors[] = 'Unable promote the first task!';
        }
        else
        {
            $i = $id;
            $i--;
            $temp = array();
            
            $temp[0] = $task_list[$i];
            $task_list[$i] = $task_list[$id];
            $task_list[$id] = $temp[0];
        }
        break;
        
    case 'Sort Tasks':
        sort($task_list, SORT_STRING);
        break;
}

include('task_list.php');
?>