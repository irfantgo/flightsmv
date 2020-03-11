<?php
class Tags extends \Heliumframework\Model
{

    public $tblmapped = 'a_c_t_map';

    public function __construct()
    {
        $this->tablename = 'tags';
        parent::__construct();
    }

    /**
     * Add new tag
     * @param string $dv_name
     * @param string $en_name
     * @return boolean
     */
    public function add( $dv_name, $en_name )
    {

        $tagsModel = new Tags();
        
        if( $tagsModel->insert([ 'name_dv' => $dv_name, 'name_en' => $en_name ]) ) {
            return true;
        }

        return false;
        
    }

    /**
     * Get tags assigned to an article
     * @param int $id
     * @return array
     */
    public function assigned( $id )
    {

        $this->conn->where('article_id', $id);
        $this->conn->where('m_type', 'tag');
        $records = $this->conn->get($this->tblmapped);
        $return = [];
        $c = 0;

        if( $this->conn->count > 0 ) {
            foreach( $records as $r ) {
                $return[$c] = $r['m_id'];
                $c++;
            }
        }

        return $return;

    }

    /**
     * Assign a tag to article
     * @param int $article_id
     * @param int $tag_id
     * @return boolean
     */
    public function assign( $article_id, $tag_id )
    {

        $input = [
            'article_id' => $article_id,
            'm_id' =>  $tag_id,
            'm_type' =>  'tag'
        ];

        $id = $this->conn->insert($this->tblmapped, $input);

        if( $id ) {
            return true;
        }
        
        return false;

    }

    /**
     * Unassign a category from article
     * @param int $article_id
     * @param int $cat_id
     * @return boolean
     */
    public function unassign( $article_id, $tag_id )
    {

        $this->conn->where('article_id', $article_id);
        $this->conn->where('m_id', $tag_id);
        $this->conn->where('m_type', 'tag');

        if( $this->conn->delete($this->tblmapped) ) {
            return true;
        }
        
        return false;

    }

}