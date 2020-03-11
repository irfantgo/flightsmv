<?php
/**
 * Products Controller
 * @author Ahmed Shan (@thaanu16)
 * 
 */

use Heliumframework\Auth;
use Heliumframework\Controller;
use Heliumframework\Validate;
use Heliumframework\Session;
class ProductsController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Auth::userLogged();
    }

    public function index( $id = null )
    {

        $productsModel = new Products();
        $products = $productsModel->get_products();

        // Render View
        $this->view('cpanel.products.show', ['products' => $products]);

    }

    /**
     * Create new product
     */
    public function create()
    {

        // Render View
        $this->view('cpanel.products.create');

    }

    /**
     * Store product information
     */
    public function store()
    {

    }

    /**
     * Update product information
     * @param int $product_id
     */
    public function update( $product_id )
    {

        // Fetch products
        $productModel   = new Products();
        $product        = $productModel->get_product($product_id);

        // Fetch categories
        $categoriesModel = new Categories();
        $categories = $categoriesModel->_get();

        // Render View
        $this->view('cpanel.products.edit', ['product' => $product[0], 'categories' => $categories]);

    }


}