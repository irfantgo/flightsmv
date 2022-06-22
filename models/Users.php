<?php
class Users extends \Heliumframework\Model
{

    protected $tbl_users_meta = 'user_meta';

    public function __construct()
    {
        parent::__construct();
        $this->tablename = 'users';
    }

    /**
     * Get a user by username
     * @param string $username
     * @return array
     */
    public function username( $username )
    {
        $this->conn->join('`groups` g', 'g.ID = users.group_id', 'LEFT');
        $this->conn->join('user_meta', 'user_meta.user_id = users.ID', 'LEFT');
        $this->conn->where('users.username', $username, '=');
        $user = $this->conn->getOne($this->tablename, null, 'users.*, users.ID uid, g.group_name, user_meta.*');

        log_message(print_r($this->getLastError()));
        
        if( !empty($user) ) {
            return $user;
        }
        
        return [];
    }

    /**
     * Get all the users with meta information
     * @return array
     */
    public function all_users()
    {
        $this->conn->join('groups', 'groups.ID = users.group_id', 'LEFT');
        $this->conn->join('user_meta', 'user_meta.user_id = users.ID', 'LEFT');
        $this->conn->orderBy('users.display_name', 'ASC');
        $users = $this->conn->get($this->tablename, null, 'users.*, users.ID uid, groups.*, user_meta.*');
        if( $this->conn->count > 0 ) {
            return $users;
        }
        return [];
    }

    /**
     * Get all active users
     * @return array
     */
    public function all_active_users()
    {
        $this->conn->join('groups', 'groups.ID = users.group_id', 'INNER');
        $this->conn->join('user_meta', 'user_meta.user_id = users.ID', 'LEFT');
        $this->conn->where('users.isActive', '1');
        $this->conn->orderBy('users.display_name', 'ASC');
        $users = $this->conn->get($this->tablename, null, 'users.*, users.ID user_id, groups.*');
        if( $this->conn->count > 0 ) {
            return $users;
        }
        return [];
    }


    /**
     * Create new user
     * @param string $dataset
     * @return boolean
     */
    public function create( $dataset )
    {

        $dd['username']         = $dataset['username'];
        $dd['display_name']     = $dataset['display_name'];
        $dd['email']            = $dataset['email'];
        $dd['password']         = $dataset['password'];
        $dd['salt']             = $dataset['salt'];
        $dd['first_loggedIn']   = $dataset['first_loggedIn'];
        $dd['last_loggedIn']    = $dataset['last_loggedIn'];
        $dd['group_id']         = $dataset['group_id'];
        $dd['isActive']         = 0; // By default new users are inactive, until verified
        $dd['isVerified']       = 0; // By default new users account has not been verified
        $dd['verify_code']      = $dataset['verify_code'];
        $dd['joined_dt']        = date('Y-m-d H:i:s');

        if( $this->insert( $dd ) ) {

            // Create user meta information
            $ndd = [
                'user_id'   => $this->last_record_id,
                'bg_image'  => $dataset['background'],
                'dv_name'   => $dataset['dv_name'],
                'dv_bio'    => $dataset['dv_bio'],
                'en_bio'    => $dataset['en_bio'],
                'social_media'    => $dataset['social_media']
            ];

            $this->conn->insert($this->tbl_users_meta, $ndd);

            log_message($this->conn->getLastError());

            return true;

        }

        return false;
        
    }

    /**
     * Update field
     * @param int $record_id
     * @param string $field
     * @param string $value
     * @return boolean
     */
    public function update_field( $record_id, $field, $value )
    {
        
        return $this->update( $record_id, [$field => $value] );

    }

    /**
     * Insert user meta information
     * @param int $userid
     * @param array $dataset
     */
    public function insert_user_meta( $dataset )
    {

        if( $this->conn->insert('user_meta', $dataset) ) {
            return true;
        }

        return false;

    }

    /**
     * Update user meta information
     * @param int $userid
     * @param array $dataset
     */
    public function update_user_meta( $userid, $dataset )
    {

        $this->conn->where('user_id', $userid);
        if( $this->conn->update('user_meta', $dataset) ) {
            return true;
        }

        return false;

    }

    /**
     * Get user meta information
     * @param int $userid
     */
    public function get_user_meta( $userid )
    {

        $this->conn->where('user_id', $userid);
        $r = $this->conn->getOne('user_meta');
        if( !empty($r) ) {
            return $r;
        }

        return [];

    }

    /**
     * Get user mapped departments
     * @param int $userid
     * @return array
     */
    public function get_mapped_departments( $userid )
    {

        $this->conn->join('departments d', 'd.ID = dm.dept_id', 'LEFT');
        $this->conn->where('dm.user_id', $userid);
        $records = $this->conn->get('department_map dm', null, 'd.*, dm.send_mail');

        if( !empty($records) ) {
            return $records;
        }

        return [];

    }

    /**
     * Add departments mapping
     * @param int $userid
     * @param array $departments
     * @return boolean
     */
    public function map_departments( $userid, $departments )
    {
        foreach( $departments as $dept ) {
            $send_mail = (isset($dept['send_mail']) ? 1 : 0);
            $dbInput = [
                'dept_id' => $dept['dept_id'],
                'user_id' => $userid,
                'send_mail' => $send_mail
            ];
            $this->conn->insert('department_map', $dbInput);
        }
    }

    /**
     * Update departments mapping
     * @param int $userid
     * @param array $departments
     * @return boolean
     */
    public function update_map_departments( $userid, $departments )
    {

        // Remove existing department mapping
        $this->conn->where('user_id', $userid);
        $this->conn->delete('department_map');

        // Insert new information
        if( !empty($departments) ) {

            foreach( $departments as $i => $d ) {
                
                if( isset($d['dept_id']) ) {

                    $send_mail = (isset($d['send_mail']) ? 1 : 0);
                    $dbInput = [
                        'dept_id' => $d['dept_id'], 
                        'user_id' => $userid,
                        'send_mail' => $send_mail
                    ];
                    $this->conn->insert('department_map', $dbInput);

                }
                
            }

        }
    }
    

}