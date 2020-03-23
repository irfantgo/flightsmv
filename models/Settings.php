<?php
class Settings extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'settings';
        parent::__construct();
    }

    /**
     * Get all the settings
     * @return array
     */
    public function all()
    {
        $settings = $this->conn->get($this->tablename);
        return $settings;
    }

    /**
     * Set Settings
     * @param string $category
     * @param string $field
     * @param string $value
     * @return boolean
     */
    public function set($category, $field, $value)
    {

        $this->conn->where('field', $field);
        $this->conn->where('category', $category);
        if( $this->conn->update($this->tablename, ['value' => $value]) ) {
            return true;
        }
        return false;

    }

    /**
     * Get requested Settings
     * @return array
     */
    public function get()
    {

        $s = $this->conn->get($this->tablename);
        $settings = [];

        foreach( $s as $f ) {
            $settings[$f['field']] = $f['value'];
        }

        return $settings;

    }

}
