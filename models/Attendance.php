<?php 
class Attendance 
{

    protected $results;
    protected $conn;
    protected $errors = [];

    /**
     * Database Connection
     * @param string $host
     * @param string $database
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function __construct( $host, $database, $username, $password )
    {

        $this->conn = sqlsrv_connect( $host, 
            [
                'Database' => $database,
                'UID' => $username,
                'PWD' => $password
            ]
        );

        // Check if connection was set
        if( !$this->conn ) {
            $this->errors[] = sqlsrv_errors();
        }
        
    }

    /**
     * Make a SQL Query
     * @param string $statement
     * @return boolean
     */
    public function make_query( $statement )
    {
        $this->results = sqlsrv_query( $this->conn, $statement);
    }

    /**
     * Get results
     */
    public function get_results()
    {
        return sqlsrv_fetch_array($this->results, SQLSRV_FETCH_ASSOC);
    }

    /**
     * Function returns data from an array
     * @return array
     */
    public function get_view($view_name)
    {
        $this->make_query("SELECT * FROM $view_name ORDER BY SCHEDULE_DATE ASC, EMPLOYEE_NAME ASC");
        // $this->make_query("SELECT * FROM $view_name where EMPLOYEE_NAME = 'MOHAMED SHADIH SHAHID' ORDER BY SCHEDULE_DATE ASC, EMPLOYEE_NAME ASC");
    }
    
    /**
     * Get all the errors
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * This is something cleaner
     * @return array
     */
    public function something_cleaner()
    {
        $dataset = [];
        $total_weeks = 5;

        while($row = sqlsrv_fetch_array($this->results, SQLSRV_FETCH_ASSOC)) {
    
            $emp_name               = $row['EMPLOYEE_NAME'];
            $schedule_type          = $row['SCHEDULE_TYPE'];
            $schedule_date          = $row['SCHEDULE_DATE']->format('Y-m-d');
            $schedule_type_desc     = $row['SCHEDULE_TYPE_DESCRIPTION'];
            $actual_date            = (!empty($row['ACTUAL_DATE']) ? $row['ACTUAL_DATE']->format('Y-m-d') : '');
            $actual_cin             = (!empty($row['CLOCK_IN1']) ? $row['CLOCK_IN1']->format('Y-m-d H:i') : '');
            $actual_cout            = '';

            $total_work_hour        = $row['TOTAL_WORK_HOUR'];
            $total_ot_hour          = $row['TOTAL_OT_HOUR'];
            $total_schedule_hour    = $row['TOTAL_SCHEDULED'];
            
    
            $last_clockout_colname  = '';
    
            // Lookup for last clock out
            for( $i = 1; $i<=$total_weeks; $i++ ) {
                if( !empty($row['CLOCK_OUT'.$i]) ) {
                    $last_clockout_colname  = 'CLOCK_OUT'.$i;
                    $actual_cout            = $row['CLOCK_OUT'.$i]->format('Y-m-d H:i');
                }
            }

            $special_days = ['ANUL' => 'Annual Leave', 'OFFD' => 'Off Day', 'SICK' => 'Sick Leave'];

            $display_label = '';

            if( array_key_exists($schedule_type, $special_days) && empty($actual_cin) ) {
                $display_label = $special_days[$schedule_type];
            } else {
                $display_label = date("H:i", strtotime($actual_cin)) . '-' . date("H:i", strtotime($actual_cout));
            }

            $dataset[$emp_name][] = [
                "SCHEDULE_TYPE"         => $schedule_type, 
                "SCHDEULE_DATE"         => $schedule_date,
                "CLOCK_IN"              => date("H:i", strtotime($actual_cin)),
                "CLOCK_OUT"             => date("H:i", strtotime($actual_cout)),
                "TOTAL_WORK_HOUR"       => $total_work_hour,
                "TOTAL_OT_HOUR"         => $total_ot_hour,
                "TOTAL_SCHEDULED_HOUR"  => $total_schedule_hour,
                "SCH_DISPLAY_LABEL"     => (empty($schedule_type_desc) ? 'NOT SET' : $schedule_type_desc),
                "ACT_DISPLAY_LABEL"     => $display_label
            ];
    
            // Mark special day
            // if( array_key_exists($schedule_type, $special_days) ) {
    
                
    
            // }
            // // All Other Days
            // else {
    
            //     $dataset[$emp_name][] = [
            //         "SCHEDULE_TYPE"         => $schedule_type, 
            //         "SCHDEULE_DATE"         => $schedule_date,
            //         "SCHEDULE_TYPE_DESC"    => $schedule_type_desc,
            //         "CLOCK_TIMES"           => date("H:i", strtotime($actual_cin)) . ' - ' . date("H:i", strtotime($actual_cout)),
            //         "TOTAL_WORK_HOUR"       => $total_work_hour,
            //         "TOTAL_OT_HOUR"         => $total_ot_hour,
            //         "TOTAL_SCHEDULED_HOUR"  => $total_schedule_hour,
            //         "ACT_DISPLAY_LABEL"     => ""
            //     ];
    
            // }
    
        }

        return $dataset;
        
    }

}