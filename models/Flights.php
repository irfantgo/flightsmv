<?php
class Products extends \Heliumframework\Model
{

    public function __construct()
    {
        $this->tablename = 'products';  
        $this->imagesTable = 'product_images';  
        parent::__construct();

    }

    /**
     * Fetch all products
     * @return array
     */
    public function get_products()
    {
        
        return $this->_get_product_chunk($this->_get());

    }

    /**
     * Fetch all products
     * @return array
     */
    public function get_product( $product_id )
    {
        
        return $this->_get_product_chunk(
            $this->_get([
                'andWhere' => [
                    ['ID', $product_id, '=' ]
                ]
            ])
        );

    }

    /**
     * Get product chunk
     * @param array $product_array
     * @return array
     */
    private function _get_product_chunk( $products_records )
    {

        $products = [];

        // Check for products
        if( !empty($products_records) ) {

            // Loop all products
            for( $p=0; $p<count($products_records); $p++ ) {

                // Map product
                $products[$p] = $products_records[$p];

                // Map Product Categories
                $products[$p]['categories'] = $this->get_product_category($products_records[$p]['cat_id']);

                // Fetch product images
                $products[$p]['images'] = $this->get_product_images( $products_records[$p]['ID'] );

                // Create category slug
                if( !empty($products[$p]['categories']) ) : foreach( $products[$p]['categories'] as $cat ) :
                    $products[$p]['categories_slug'] .= $cat['slug'] . ' ';
                endforeach; endif;

            }

        }

        return $products;

    }

    /**
     * Fetch product categories
     * @param int $category_id
     * @return array
     */
    public function get_product_category( $category_id )
    {

        $categories = [];

        $categoriesModel = new Categories();
        $categories_records = $categoriesModel->_get([
            'andWhere' => [
                ['ID', $category_id, '=']
            ]
        ]);

        if( !empty($categories_records) ) {
            for( $i=0; $i<count($categories_records); $i++ ) {
                
                $categories[$i] = $categories_records[$i];

                // Create category slug
                $categories[$i]['slug'] = strtolower(str_replace(' ', '-', $categories_records[$i]['name_en']));

            }
        }

        return $categories;
        
    }

    /**
     * Get product images
     * @param int $product_id
     * @return array
     */
    public function get_product_images( $product_id )
    {

        $images = [];

        $this->conn->where('product_id', $product_id);
        $images_records = $this->conn->get($this->imagesTable);

        if( !empty($images_records) ) {

            for ( $i=0; $i<count($images_records); $i++ ) {
                
                $images[$i] = $images_records[$i];

                // Create images url
                $images[$i]['image_url'] = '/images/product-image/' . $images_records[$i]['ID'];

            }

        }

        return $images;

    }

    /**
     * Get a single image of the product
     * @param int $image_id
     * @return array
     */
    public function get_product_image( $image_id )
    {

        $this->conn->where('ID', $image_id);
        $images_records = $this->conn->getOne($this->imagesTable);

        if( !empty($images_records) ) {

            return $images_records;

        }

        return [];

    }
    

}