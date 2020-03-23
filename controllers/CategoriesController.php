<?php
/**
 * Categories Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Controller;
use Heliumframework\Validate;

class CategoriesController extends Controller
{

    public function index( $id = null )
    {

        // Fetch all the tags
        $categoriesModel = new Categories();
        $categories = $categoriesModel->_get();
        
        // Editable
        $edit_cat = ( $id ? $categoriesModel->find($id) : NULL );

        // Render View
        $this->view('cpanel.categories.show', ['edit_cat' => $edit_cat, 'categories' => $categories]);
        
    }

    public function store()
    {

        $formRequirements = [
            'name_en' => [
                'required' => true,
                'label' => 'English Name'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirements);

        if( $validation->passed() ) {

            $dbIbput = [
                'name_dv' => NULL,
                'name_en' => $this->formData['name_en']
            ];

            $categoriesModel = new Categories();
            
            if( $categoriesModel->insert($dbIbput) ) {
                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'New category created';
            }
            else {
                $this->formResponse['errors'][] = 'Unable to create new category';
                $this->formResponse['errors'][] = $categoriesModel->conn->getLastError();
            }

        }
        // Bind, all error fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }


        // Send Response
        $this->send_json_response();

    }

    /**
     * Update tag
     * @param int $id
     * @return object
     */
    public function patch($id)
    {

        $formRequirements = [
            'name_en' => [
                'required' => true,
                'label' => 'English Name'
            ]
        ];

        $validate = new Validate();
        $validation = $validate->check($this->formData, $formRequirements);

        if( $validation->passed() ) {

            $dbIbput = [
                'name_dv' => NULL,
                'name_en' => $this->formData['name_en']
            ];

            $categoriesModel = new Categories();
            
            if( $categoriesModel->update($id, $dbIbput) ) {
                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'Category updated';
            }
            else {
                $this->formResponse['errors'][] = 'Unable to update category';
            }

        }
        // Bind, all error fields
        else {
            $this->formResponse['error_fields'] = $validation->errors();
        }


        // Send Response
        $this->send_json_response();

    }

    public function destroy()
    {

    }

    /**
     * Get ajax call
     * @param string $action
     * @param int $id
     * @param int $cat_id
     * @param int $method
     * @return object
     */
    public function ajax( $action, $id, $cat_id = null, $method = null )
    {

        $model = new Categories();

        // Get Status
        if( $action == 'get' ) {
            
            $records = $model->_get([
                'orderBy' => [
                    ['ID', 'DESC']
                ]
            ]);
            $returnData = [];
            $c = 0;

            // Fetch articles assigned categories
            $mapped_items = $model->assigned($id);

            // Loop all the tags
            if( !empty($records) ) {
                foreach( $records as $t ) {
                    $returnData[$c] = [
                        'cat_id' => $t['ID'],
                        'cat_dv' => $t['name_dv'],
                        'cat_en' => $t['name_en'],
                        'checked' => ( isset($mapped_items) && in_array($t['ID'], $mapped_items) ? true : false)
                    ];
                    $c++;
                }

                // Output
                $rString = '';
                foreach($returnData as $item) {

                    $rString .= '<div class="form-group clearfix">';
                    $rString .= '<div class="icheck-danger d-inline">';
                    $rString .= '<input type="checkbox" class="check_to_update" data-url="/admin/categories/ajax/set/'.$id.'/'.$item['cat_id'].'" id="cat_'.$item['cat_id'].'" '.($item['checked'] ? ' checked ' : '').' >';
                    $rString .= '<label for="cat_'.$item['cat_id'].'"> ' . $item['cat_dv'];
                    $rString .= '</label>';
                    $rString .= '</div>';
                    $rString .= '</div>';

                }

                // Output string
                echo $rString;

            }

        }

        // Set Category
        if( $action == 'set' ) {

            if( $method == 'checked' ) {
                $model->assign($id, $cat_id);
            }

            if( $method == 'unchecked' ) {
                $model->unassign($id, $cat_id);
            }

        }

    }

}