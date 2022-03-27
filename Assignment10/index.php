<?php
//set default value
$message = '';

//get value from POST array
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action =  'start_app';
}

//process
switch ($action) {
    case 'start_app':

        // set default invoice date 1 month prior to current date
        $interval = new DateInterval('P1M');
        $default_date = new DateTime();
        $default_date->sub($interval);
        $invoice_date_s = $default_date->format('n/j/Y');

        // set default due date 2 months after current date
        $interval = new DateInterval('P2M');
        $default_date = new DateTime();
        $default_date->add($interval);
        $due_date_s = $default_date->format('n/j/Y');

        $message = 'Enter two dates and click on the Submit button.';
        break;
    case 'process_data':
        $invoice_date_s = filter_input(INPUT_POST, 'invoice_date');
        $due_date_s = filter_input(INPUT_POST, 'due_date');

        // make sure the user enters both dates
        if(empty($invoice_date_s) || empty($due_date_s)){
            $message = 'Enter both dates!';
            break;
        }
        // convert date strings to DateTime objects
        try{
        $invoice_date_d = new DateTime($invoice_date_s);
        $due_date_d = new DateTime($due_date_s);
        } catch(Exception $e) {
            $message = 'Both dates must be valid!';
            break;
        }
        // make sure the due date is after the invoice date
        if($due_date_d < $invoice_date_d){
            $message = 'Due date must be after invoice date!';
        }
        // format both dates
        
        $invoice_date_f = date('F j, Y', strtotime($invoice_date_s));
        $due_date_f = date('F j, Y', strtotime($due_date_s)); 
        
        // get the current date and time and format it
        $t = time();
        $current_date_f = date('F j, Y', $t);
        $current_time_f = date('g:i:s a', $t);
        
        // get the amount of time between the current date and the due date
        // and format the due date message

        $diff = date_diff($invoice_date_d, $due_date_d);
        if($due_date_d< $invoice_date_d){
            $due_date_message = $diff ->format('Invoice is %y years, %m months, and %d overdue');

        } else {
            $due_date_message = $diff ->format('Invoice due in %y years, %m months, and %d');
        }
        break;
}
include 'date_tester.php';
?>