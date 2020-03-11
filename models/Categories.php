<?php
class Categories extends \Heliumframework\Model
{

    public $tblmapped = 'a_c_t_map';

    public function __construct()
    {
        $this->tablename = 'categories';
        parent::__construct();
    }

    /**
     * Get categories assigned to an article
     * @param int $id
     * @return array
     */
    public function assigned( $id )
    {

        $this->conn->where('article_id', $id);
        $this->conn->where('m_type', 'cat');
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
     * Assign a category from article
     * @param int $article_id
     * @param int $cat_id
     * @return boolean
     */
    public function assign( $article_id, $cat_id )
    {

        $input = [
            'article_id' => $article_id,
            'm_id' =>  $cat_id,
            'm_type' =>  'cat'
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
    public function unassign( $article_id, $cat_id )
    {

        $this->conn->where('article_id', $article_id);
        $this->conn->where('m_id', $cat_id);
        $this->conn->where('m_type', 'cat');

        if( $this->conn->delete($this->tblmapped) ) {
            return true;
        }
        
        return false;

    }

}