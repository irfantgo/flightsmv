<?php
/**
 * Groups Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
class GroupsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {  

        // Authenticate User
        $this->viewAuthenticate( 'MNG_GROUPS' );

        $groupsModel = new Groups();
        $groups = $groupsModel->_get();

        $oGroups = [];
        $count = 0;

        if( !empty($groups) ) {

            foreach( $groups as $group ) {
                $oGroups[$count]['ID'] = $group['ID'];
                $oGroups[$count]['group_name'] = $group['group_name'];
                $oGroups[$count]['group_roles'] = explode(':', $group['group_roles']);
                $count++;
            }

        }

        $this->view('cpanel.groups.show', ['groups' => $oGroups]);
        
    }

    public function create()
    {

        // Authenticate User
        $this->viewAuthenticate( 'MNG_GROUPS' ); 

        // Fetch all the roles
        $rolesModel = new Roles();
        $roles = $rolesModel->_get();

        $this->view('cpanel.groups.create', ['roles' => $roles]);
    }

    /**
     * Store New Role Information
     */
    public function store()
    {

        // Authenticate User
        $this->ajaxAuthentication( 'MNG_GROUPS' );

        $form_requirements = [
            'group_name' => [
                'required' => true,
                'unique' => 'groups',
                'label' => 'Group Name'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $form_requirements);

        // Check if validation passed
        if( $validation->passed() ) {

            $dbInput = [
                'group_name' => $this->formData['group_name'],
                'group_roles'=> ( empty($this->formData['roles']) ? NULL : implode(':', $this->formData['roles']) )
            ];

            $groupsModel = new Groups();
            if( $groupsModel->insert($dbInput) ) {
                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'New group created successfully';
            } else {
                $this->formResponse['errors'][] = 'Unable to create group at this time';
            }

        }
        // Else, bind error fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }

        $this->send_json_response();

    }

    /**
     * Show a form to update role 
     */
    public function update( $id = null )
    {
        
        $this->viewAuthenticate( 'MNG_GROUPS' );

        // Fetch the group
        $groupsModel = new Groups();
        $group = $groupsModel->find($id);

        // Check for group
        if( empty($group) ) {
            error_header(404);
        }

        $group['roles'] = ( $group['group_roles'] == NULL ? [] : explode(':', $group['group_roles']) );

        // Fetch all the roles
        $rolesModel = new Roles();
        $roles = $rolesModel->_get();

        $this->view('cpanel.groups.edit', ['roles' => $roles, 'group' => $group]);
    }

    /**
     * Update a given record
     */
    public function patch( $id )
    {

        // Authenticate User
        $this->ajaxAuthentication( 'MNG_GROUPS' );

        $form_requirements = [
            'group_name' => [
                'required' => true,
                'uniquebut' => [
                    'primary_key' => 'ID',
                    'primary_key_value' => $id,
                    'tablename' => 'groups'
                ],
                'label' => 'Group Name'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $form_requirements);

        // Check if validation passed
        if( $validation->passed() ) {

            $dbInput = [
                'group_name' => $this->formData['group_name'],
                'group_roles'=> ( empty($this->formData['roles']) ? NULL : implode(':', $this->formData['roles']) )
            ];

            $groupsModel = new Groups();
            if( $groupsModel->update($id, $dbInput) ) {
                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'Group updated successfully';
            } else {
                $this->formResponse['errors'][] = 'Unable to update group at this time';
            }

        }
        // Else, bind error fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }

        
        
        $this->send_json_response();

    }

    /**
     * Remove destroy
     */
    public function destroy($id)
    {

        // !! DONT HAVE A DETROY METHOD YET, NEED TO FIGURE OUT HOW TO HANDLE A GROUP DELETE

    }

}