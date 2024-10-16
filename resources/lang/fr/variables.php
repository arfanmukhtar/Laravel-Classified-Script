<?php

//General Variables

//Table Variables

$created_on = 'Created On';
$updated_on = 'Updated On';
$created_by = 'Created By';

// Import Variables
$siteTitle = 'Login to the Application';
try {
    if (function_exists('getApplciationSettings')) {
        $title = getApplciationSettings('title');
        $siteTitle = $title ? $title.' Email Login' : $siteTitle;
    }

} catch (\Exception $e) {

}

$csv_upload = 'Upload a CSV file';
$csv_select = 'Select a file from server';
$csv_source = 'File Source';

// Template Variables

$email_subject = 'Email Subject';
$email_body_html = 'HTML Body';
$email_text_html = 'Text Body';
$email_insert_variables = 'Insert Variables';
$email_preview_smtp = 'SMTP to Use for Preview';
$email_preview_email = 'Send Preview to Email';
$email_preview_bcc = 'BCC Preview to Email';

// Schedule Variables

$contact_lists = 'Contact Lists';
$sending_nodes = 'Sending Nodes';
$track_opens = 'Track Opens';
$track_clicks = 'Track Clicks';
$insert_unsub = 'Insert Unsubscribe Link';
$sender_info = 'Sender Info';
$sending_domain = 'Sending Domain';
$sending_domain_smtp = 'Fetch from SMTP Settings';
$sending_domain_list = 'Fetch from Contact List Settings';
$sending_domain_custom = 'Choose from Sending Domains';

// Buttons Variables

$save = 'Save';
$save_add = 'Save & Add New';
$save_and_keep_editing = 'Save & Keep Editing';
$save_exit = 'Save & Exit';
$cancel = 'Cancel';
$submit = 'Submit';
$reset = 'Reset';
$add_new = 'Add New';

// Dropdown Variables
$edit = 'Edit';
$delete = 'Delete';
