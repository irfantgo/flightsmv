<?php
class Comments extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'comments';  
        parent::__construct();

    }

    /**
     * Get all the comments
     * @return array
     */
    public function get_comments()
    {

        // Join article
        $this->conn->join('articles a', 'a.ID = c.article_id', 'INNER');

        // Order By decending
        $this->conn->orderBy('c.sent_dt', 'DESC');

        // Fetch records
        $records = $this->conn->get($this->tablename . ' c', null, 'c.*, a.title article_title, a.slug article_slug');

        if( !empty($records) ) {
            return $records;
        }

        return [];

    }

    /**
     * Get all the comments for the given article
     * @param int $article_id
     * @param boolean $approved
     * @return array
     */
    public function get_comments_for_article($article_id, $approved = true)
    {

        // Set article ID
        $this->conn->where('c.article_id', $article_id);

        // Join article
        $this->conn->join('articles a', 'a.ID = c.article_id', 'INNER');

        // Check for approved
        if( $approved ) {
            $this->conn->where('c.comment_status', 'approved');
        }

        // Order By decending
        $this->conn->orderBy('c.sent_dt', 'DESC');

        // Fetch records
        $records = $this->conn->get($this->tablename . ' c', null, 'c.*, a.title article_title, a.slug article_slug');

        if( !empty($records) ) {
            return $records;
        }

        return [];

    }

    /**
     * Add new comment
     * @param int $article_id
     * @param string $sender_name
     * @param string $comment
     * @return boolean
     */
    public function new_comment( int $article_id, string $sender_name, string $comment )
    {

        $dbInput = [
            'article_id' => $article_id,
            'sender_name' => $sender_name,
            'sender_comment' => $comment,
            'sent_dt' => date('Y-m-d H:i:s'),
            'comment_status' => 'moderate',
            'approved_by' => NULL
        ];

        $id = $this->conn->insert($this->tablename, $dbInput);

        if( $id ) {
            return true;
        }
        
        return false;

    }
    

}