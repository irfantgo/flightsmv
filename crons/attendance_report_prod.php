<?php
    /**
     * !! PLEASE CHECK THIS FILE FOR LATEST CHANGES FROM attendance_report.php BEFORE DEPLOYING
     */

    /**
     * INITIALIZE PHP MAILER
     * ---------------------
     */
    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;
    
    /**
     * INITIALIZE DOMPDF
     * ---------------------
     */
    use Dompdf\Dompdf;
    use Svg\Document;

    /**
     * SET TIMEZONE
     * ---------------
     */
    date_default_timezone_set('Asia/Karachi');

    /**
     * CORE HELPERS
     * ---------------
     */
    include(dirname(__DIR__) . '/core/CoreHelpers.php');

    /**
     * MODELS
     * ---------------
     */
    require(dirname(__DIR__) . '/core/Model.php');

    /**
     * COMPOSER MODULES
     * ----------------
     * Load all composer modules
     */
    if( is_dir(dirname(__DIR__) . '/vendor') == false ) {
        // Die and Dump a message
        echo "Please install composer modules\n";
    }
    require(dirname(__DIR__) . '/vendor/autoload.php');

    /**
     * MODELS
     * ---------------
     * Load all the models
     */
    $models = scandir(dirname(__DIR__) . '/models');
    foreach( $models as $model ) {
        $ext = pathinfo($model)['extension'];
        if( $ext == 'php' ) {
            include_once(dirname(__DIR__) . '/models/' . $model);
        }
    }

    /**
     * Error Reporting
     * ---------------
     * Error showing or logging
     */
    if( _env('DEV_MODE') ){
        ini_set('display_errors', 1);
    }

    function telegram_notification( $message ){ return false; }

    /**
     * Send Telegram Notification
     * @param string $message
     */
    function telegram_notification_bck( $message )
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://10.2.2.34/notifier/index.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('message' => $message)));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        // Further processing ...
        if ($server_output == "OK") {
            return true;
        }
        return false;
    }

    // Fetch settings
    $settingsModel = new Settings();
    $settings = $settingsModel->get();

    // Check if script should run
    $__xx = explode(' ', $settings['run_date_time']);
    $run_dt = date('Y-m-') . $__xx[0] . ' ' . date('H:i');

    // Terminate script if its not run time
    if( $run_dt != date('Y-m-d H:i') ) {
        echo "Script terminated\n";
        exit;
    }

    // Initialize Log Model
    $logs = new Logs();

    // Log that get store script is running
    $logs->add('Attendance Report Executed', 'cron_job');

    // Fetch all the departments
    $departmentsModel = new Departments();
    $departments = $departmentsModel->_get([
        'andWhere' => [
            ['isActive', '1', '=']
        ]
    ]);

    // Check for departments and loop
    if( !empty($departments) ) {

        $first_date = '';

        // Loop every department
        foreach( $departments as $dept ) {

            $view_name = $dept['attendance_view'];
            $blank = '<em>NOT SET</em>';

            // Create new instance of the attendance model
            $att = new Attendance(_env('ATTENDANCE_DB_HOST'), _env('ATTENDANCE_DB_NAME'), _env('ATTENDANCE_DB_USER'), 'SR\=&<<9P3J\'tR"\'?FB*Kc{a@:RSuuq25#Ks--u5*8jH&');
        
            if( empty($att->errors()) ) {
        
                $att->get_view($view_name);
        
                $html_output = '';
                $dataset = $att->something_cleaner();
        
                if( ! empty($dataset) ) {
        
                    $total_weeks    = 5;
                    $nextStart      = 0;
                    $oldRow         = false;

                    // Create datasheet
                    $html_output .= '<table style="font-size: 7pt; font-family: arial;" width="50%" border="1" rules="all">';

                    $html_output .= '<tr>';
                    $html_output .= '<th>STAFF NAME</th>';
                    $html_output .= '<th>HOURS SCHEDULED</th>';
                    $html_output .= '<th>HOURS WORKED</th>';
                    $html_output .= '<th>HOURS OVERTIME</th>';
                    $html_output .= '</tr>';

                    foreach( $dataset as $person => $data ) {

                        $ot = 0;
                        $wt = 0;
                        $hs = 0;

                        // Calculation
                        foreach( $data as $info ) {
                            $hs = $hs + $info['TOTAL_SCHEDULED_HOUR'];
                            $ot = $ot + $info['TOTAL_OT_HOUR'];
                            $wt = $wt + $info['TOTAL_WORK_HOUR'];
                        }

                        $html_output .= '<tr>';
                        $html_output .= '<td>'.$person.'</td>';
                        $html_output .= '<td>'.$hs.'</td>';
                        $html_output .= '<td>'.$wt.'</td>';
                        $html_output .= '<td>'.$ot.'</td>';
                        $html_output .= '</tr>';
                    }
                    $html_output .= '</table><br>';
            
                    for( $w=1; $w<=$total_weeks; $w++ ) {
            
                        $html_output .= '<table style="font-size: 7pt;" width="100%" border="1" rules="all">';
            
                        // Date
                        $html_output .= '<tr>';
                        $html_output .= '<td width="20%"></td>';
                        foreach( $dataset as $emp_name => $timing ) {

                            // Set first date, this is for flagging the MONTH and YEAR for the report title
                            $first_date = $timing[0]['SCHDEULE_DATE'];

                            if( $oldRow == false ){
                                for( $i=$nextStart; $i<($nextStart + 7); $i++ ) {
                                    $html_output .= '<th colspan="2" width="10%">';
                                    $html_output .= ( !empty($timing[$i]) ? $timing[$i]['SCHDEULE_DATE'] : $blank);
                                    $html_output .= '</th>';
                                }
                                $oldRow = true;
                            }
                        }
                        $html_output .= '</tr>';
            
                        $oldRow = false;
            
                        // Day
                        $html_output .= '<tr>';
                        $html_output .= '<td width="20%"></td>';
                        foreach( $dataset as $emp_name => $timing ) {
                            if( $oldRow == false ){
                                for( $i=$nextStart; $i<($nextStart + 7); $i++ ) {
                                    $html_output .= '<th style="text-align: center;" colspan="2" width="10%">';
                                    $html_output .= ( !empty($timing[$i]) ? 'Day-'.($i + 1) : $blank);
                                    $html_output .= '</th>';
                                }
                                $oldRow = true;
                            }
                        }
                        $html_output .= '</tr>';
            
                        $oldRow = false;
            
                        // Lables
                        $html_output .= '<tr>';
                        $html_output .= '<td width="20%"></td>';
                        foreach( $dataset as $emp_name => $timing ) {
                            if( $oldRow == false ){
                                for( $i=$nextStart; $i<($nextStart + 7); $i++ ) {
                                    $html_output .= '<th style="text-align: center;" width="5%">Scheduled</th>';
                                    $html_output .= '<th style="text-align: center;" width="5%">Actual</th>';
                                }
                                $oldRow = true;
                            }
                        }
                        $html_output .= '</tr>';
            
                    
                        // All Data and Timing
                        foreach( $dataset as $emp_name => $timing ) {
            
                            $html_output .= '<tr>';
                            $html_output .= '<td width="20%">'.$emp_name.'</td>';
            
                            for( $i=$nextStart; $i<($nextStart + 7); $i++ ) {
                                $html_output .= '<td width="5%">';
                                $html_output .= ( !empty($timing[$i]['SCHEDULE_CLOCK']) ? $timing[$i]['SCHEDULE_CLOCK'] : $blank);
                                $html_output .= '</td>';
                                $html_output .= '<td width="5%">';
                                $html_output .= ( !empty($timing[$i]['ACTUAL_TIME']) ? $timing[$i]['ACTUAL_TIME'] : $blank);
                                $html_output .= '</td>';
                            }
            
                            $html_output .= '</tr>';
                        
                        }
                
                        $html_output .= '</table>';
                        $html_output .= '<br>';
            
                        $nextStart = $nextStart + 7;
                        $oldRow = false;
            
                    }

                    // Set file settings
                    $pdf_dir = dirname(__DIR__) . '/storage/reports/';
                    if(!is_dir($pdf_dir)) { mkdir($pdf_dir, 0775, true); }
                    $pdf_filename = 'Attendance_Report_'.str_replace(' ', '_', $dept['name']).'_'.date('Ymd').'.pdf';
                    $pdf_file = $pdf_dir . $pdf_filename;
                    
                    // Load PDF Template
                    $pdf_template = file_get_contents(__DIR__ . '/pdf_template.html');
                    $pdf_template = str_replace('[::DEPARTMENT_NAME::]', strtoupper($dept['name']), $pdf_template);
                    $pdf_template = str_replace('[::DATASET::]', $html_output, $pdf_template);
                    $pdf_template = str_replace('[::MONTH::]', strtoupper(date('F', strtotime($first_date))), $pdf_template);
                    $pdf_template = str_replace('[::YEAR::]', date('Y', strtotime($first_date)), $pdf_template);
        
                    // Generate PDF and save
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($pdf_template);
        
                    // (Optional) Setup the paper size and orientation
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->set_option('defaultFont', 'Courier');

                    $dompdf->render();
                    $pdf_output = $dompdf->output();
                    file_put_contents($pdf_file, $pdf_output);

                    // Make information in database
                    $documentsModel = new Documents();
                    $documentsModel->create([
                        'dept_id' => $dept['ID'],
                        'filename' => $pdf_filename,
                        'path' => $pdf_file
                    ]);
                    
                    $logs->add('PDF created for ' . $dept['name'], 'cron_job');

                    // Fetch department HODs
                    $users = $departmentsModel->get_department_hods( $dept['ID'] );

                    // Check for users
                    if( empty($users) ) {
                        $logs->add('No users found for ' . $dept['name'], 'cron_job');
                    }
                    // Else send emails
                    else {

                        // Compose
                        $subject = 'Attendance Report for ' . $dept['name'];

                        // Loop all the Users
                        foreach( $users as $person ) {

                            // Create a nice HTML template email
                            $htmlBody = '<p>Dear '.ucwords($person['display_name']).',</p>';
                            $htmlBody .= '<p>Please find the attached PDF file which contains the attendance report for '.$dept['name'].'</p>';
                            $htmlBody .= '<p>Best regards, <br> ICT Team</p>';

                            // Send Email
                            try {

                                // Initialize PHP Mailer
                                $mail = new PHPMailer(true);

                                //Server settings
                                $mail->SMTPDebug = 0;                                           // Enable verbose debug output
                                $mail->isSMTP();                                                // Set mailer to use SMTP
                                $mail->Host       = $settings['outgoing_server'];               // Specify main and backup SMTP servers
                                $mail->SMTPAuth   = true;                                       // Enable SMTP authentication
                                $mail->Username   = $settings['auth_username'];                 // SMTP username
                                $mail->Password   = $settings['auth_password'];                 // SMTP password
                                $mail->SMTPSecure = 'tls';
                                $mail->Port       = $settings['tls_port'];                      // TCP port to connect to

                                //Recipients
                                $mail->setFrom($settings['from_address'], $settings['from_name']);
                                $mail->addAddress($person['email'], $person['display_name']);     // Add a recipient

                                // Attachments
                                $mail->addAttachment($pdf_file);         // Add attachments

                                // Content
                                $mail->isHTML(true);                                  // Set email format to HTML
                                $mail->Subject = $subject;
                                $mail->Body    = $htmlBody;

                                $mail->SMTPOptions = [
                                    'ssl' => [
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                        'allow_self_signed' => true
                                        ]
                                    ];

                                $mail->send();

                                $msg = 'Email sent to ' . $person['email'] . "\n";
                                $logs->add($msg, 'cron_job'); echo "$msg\n";

                                // Send Telegram Notification
                                telegram_notification( 'Attendance Report : PDF Created and emailed to ' . $person['email'] );

                            } catch (Exception $e) {

                                $msg = 'Unable to sent email to ' . $person['email'] . "\n";
                                $logs->add($msg, 'cron_job'); echo "$msg\n";

                                $msg = 'Email Error: ' . $mail->ErrorInfo . "\n";
                                $logs->add($msg, 'cron_job'); echo "$msg\n";

                                // Send Telegram Notification
                                telegram_notification( 'Attendance Report : Unable to send report to ' . $person['email'] );

                            }

                        }


                    }
        
                }
                
        
            }
            else {
                $logs->add('An error occured when trying to connect to database', 'cron_job');
                $logs->add(json_encode($att->errors()), 'cron_job');
            }

        }

    }
    else {
        $logs->add('No departments found', 'cron_job');
    }
