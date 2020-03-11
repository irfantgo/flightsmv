<?php
/**
 * Tags Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */
use Heliumframework\Controller;
use Heliumframework\Validate;

class TagsController extends Controller
{

    public function index( $id = null )
    {

        // Fetch all the tags
        $tagsModel = new Tags();
        $tags = $tagsModel->_get();
        
        // Editable
        $edit_tag = ( $id ? $tagsModel->find($id) : NULL );

        // Render View
        $this->view('cpanel.tags.show', ['edit_tag' => $edit_tag, 'tags' => $tags]);
        
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

            $tagsModel = new Tags();
            
            if( $tagsModel->insert($dbIbput) ) {
                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'New tag created';
            }
            else {
                $this->formResponse['errors'][] = 'Unable to create new tag';
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

            $tagsModel = new Tags();
            
            if( $tagsModel->update($id, $dbIbput) ) {
                $this->formResponse['status'] = true;
                $this->formResponse['textMessage'] = 'Tag updated';
            }
            else {
                $this->formResponse['errors'][] = 'Unable to update tag';
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
     * @param int $article_id
     * @param int $tag_id
     * @param int $method
     * @return object
     */
    public function ajax( $action, $article_id, $tag_id = null, $method = null )
    {

        $model = new Tags();

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
            $mapped_items = $model->assigned($article_id);

            // Loop all the tags
            if( !empty($records) ) {
                foreach( $records as $t ) {
                    $returnData[$c] = [
                        'tag_id' => $t['ID'],
                        'tag_dv' => $t['name_dv'],
                        'tag_en' => $t['name_en'],
                        'checked' => ( isset($mapped_items) && in_array($t['ID'], $mapped_items) ? true : false)
                    ];
                    $c++;
                }

                // Output
                $rString = '<div style="height: 400px; overflow: scroll;">';
                foreach($returnData as $item) {

                    $rString .= '<div class="form-group clearfix">';
                    $rString .= '<div class="icheck-danger d-inline">';
                    $rString .= '<input type="checkbox" class="check_to_update" data-url="/admin/tags/ajax/set/'.$article_id.'/'.$item['tag_id'].'" id="tag_'.$item['tag_id'].'" '.($item['checked'] ? ' checked ' : '').' >';
                    $rString .= '<label for="tag_'.$item['tag_id'].'"> ' . $item['tag_dv'];
                    $rString .= '</label>';
                    $rString .= '</div>';
                    $rString .= '</div>';

                }
                $rString .= '</div>';

                $rString .= '<input type="text" class="form-control thaana-input" data-url="/admin/tags/ajax/add/'.$article_id.'/'.$item['tag_id'].'" id="new_tag_dv" name="new_tag_dv" placeholder="އައު ޓެގް" >';
                
                $rString .= '<script> $(document).ready(function(){ $(\'.thaana-input\').thaana(); }); </script>';

                // Output string
                echo $rString;

            }

        }

        // Set Category
        if( $action == 'set' ) {

            if( $method == 'checked' ) {
                $model->assign($article_id, $tag_id);
            }

            if( $method == 'unchecked' ) {
                $model->unassign($article_id, $tag_id);
            }

        }

        // Add New Tag
        if( $action == 'add' ) {

            if($model->add($_POST['dv_name'], NULL)) {

                $last_tag = $model->last_record_id;
                
                if( $last_tag ) {
                    $model->assign($article_id, $last_tag);
                }

            }

        }

    }

}