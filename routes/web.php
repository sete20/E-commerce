<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.index');
});
//auth & user
Auth::routes(['verify' => true]);
Route::get('/product/details/{id}/{product_name}', 'ProductController@productView');
Route::get('add/to/cart/{id}', 'CartController@addToCart');
Route::post('/cart/product/add/{id}', 'ProductController@addToCart');
Route::get('check', 'CartController@check');

Route::post('insert/into/cart/', 'CartController@insertCart')->name('insert.into.cart');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/password/change', 'HomeController@changePassword')->name('password.change');
Route::post('/password/update', 'HomeController@updatePassword')->name('password.update');
Route::get('/user/logout', 'HomeController@Logout')->name('user.logout');
// For Show Sub category with ajax
Route::get('get/subcategory/{category_id}', 'Admin\ProductController@GetSubcat');
Route::get('user/checkout/', 'CartController@checkout')->name('user.checkout');
Route::post('user/apply/coupon/', 'CartController@Coupon')->name('apply.coupon');
/// Blog Post Route

Route::get('blog/post/', 'BlogController@blog')->name('blog.post');

Route::get('language/english', 'BlogController@English')->name('language.english');
Route::get('language/arabic', 'BlogController@Arabic')->name('language.arabic');
Route::get('blog/single/{id}', 'BlogController@BlogSingle');
//admin=======
Route::get('admin/home', 'AdminController@index');
Route::get('admin', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('admin', 'Admin\LoginController@login');
// Password Reset Routes...
Route::get('admin/password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin-password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/reset/password/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/update/reset', 'Admin\ResetPasswordController@reset')->name('admin.reset.update');
Route::get('/admin/Change/Password', 'AdminController@ChangePassword')->name('admin.password.change');
Route::post('/admin/password/update', 'AdminController@Update_pass')->name('admin.password.update');
Route::get('admin/logout', 'AdminController@logout')->name('admin.logout');
/// Admin Section
// categories
Route::get('admin/categories', 'Admin\Category\CategoryController@category')->name('categories');
Route::post('admin/store/category', 'Admin\Category\CategoryController@storeCategory')->name('store.category');
Route::get('delete/category/{id}', 'Admin\Category\CategoryController@DeleteCategory');
Route::get('edit/category/{id}', 'Admin\Category\CategoryController@editCategory');
Route::post('update/category/{id}', 'Admin\Category\CategoryController@updateCategory');

/// Brand
Route::get('admin/brands', 'Admin\Category\BrandController@brand')->name('brands');
Route::post('admin/store/brand', 'Admin\Category\BrandController@storeBrand')->name('store.brand');
Route::get('delete/brand/{id}', 'Admin\Category\BrandController@deleteBrand');
Route::get('edit/brand/{id}', 'Admin\Category\BrandController@editBrand');
Route::post('update/brand/{id}', 'Admin\Category\BrandController@updateBrand');
// Sub Categories
Route::get('admin/subcategory', 'Admin\Category\SubCategoryController@subcategory')->name('sub.categories');
Route::post('admin/store/subcategory', 'Admin\Category\SubCategoryController@storeSubcategory')->name('store.subcategory');
Route::get('edit/subcategory/{id}', 'Admin\Category\SubCategoryController@editSubcategory');
Route::post('update/subcategory/{id}', 'Admin\Category\SubCategoryController@updateSubcategory');
Route::get('delete/subcategory/{id}', 'Admin\Category\SubCategoryController@deleteSubcategory');

// Coupons All
Route::get('admin/sub/coupon', 'Admin\Category\CouponController@Coupon')->name('admin.coupon');
Route::post('admin/store/coupon', 'Admin\Category\CouponController@StoreCoupon')->name('store.coupon');
Route::get('delete/coupon/{id}', 'Admin\Category\CouponController@DeleteCoupon');
Route::get('edit/coupon/{id}', 'Admin\Category\CouponController@EditCoupon');
Route::post('update/coupon/{id}', 'Admin\Category\CouponController@UpdateCoupon');
Route::get('coupon/remove/', 'CartController@CouponRemove')->name('coupon.remove');

// Newslater

Route::get('admin/newsletter', 'Admin\Category\CouponController@Newslater')->name('admin.newsletter');
Route::get('delete/sub/{id}', 'Admin\Category\CouponController@DeleteSub');
// Frontend All Routes
Route::post('store/newsletter', 'frontendController@newsletters')->name('store.newsletter');

// Product All Route
Route::get('admin/product/all', 'Admin\ProductController@index')->name('all.product');
Route::get('admin/product/add', 'Admin\ProductController@create')->name('add.product');
Route::post('admin/store/product', 'Admin\ProductController@store')->name('store.product');

Route::get('inactive/product/{id}', 'Admin\ProductController@inactive');
Route::get('active/product/{id}', 'Admin\ProductController@active');
Route::get('delete/product/{id}', 'Admin\ProductController@DeleteProduct')->name('product.delete');

Route::get('view/product/{id}', 'Admin\ProductController@ViewProduct');
Route::get('edit/product/{id}', 'Admin\ProductController@EditProduct');

Route::post('update/product/withoutphoto/{id}', 'Admin\ProductController@UpdateProductWithoutPhoto');

Route::post('update/product/photo/{id}', 'Admin\ProductController@UpdateProductPhoto');

// Blog Admin All
Route::get('blog/category/list', 'Admin\PostController@BlogCatList')->name('add.blog.categorylist');
Route::post('admin/store/blog', 'Admin\PostController@BlogCatStore')->name('store.blog.category');
Route::get('delete/blogcategory/{id}', 'Admin\PostController@DeleteBlogCat');
Route::get('edit/blogcategory/{id}', 'Admin\PostController@EditBlogCat');
Route::post('update/blog/category/{id}', 'Admin\PostController@UpdateBlogCat');

Route::get('admin/add/post', 'Admin\PostController@Create')->name('add.blogpost');
Route::get('admin/all/post', 'Admin\PostController@index')->name('all.blogpost');

Route::post('admin/store/post', 'Admin\PostController@store')->name('store.post');

Route::get('delete/post/{id}', 'Admin\PostController@DeletePost');
Route::get('edit/post/{id}', 'Admin\PostController@EditPost');

Route::post('update/post/{id}', 'Admin\PostController@UpdatePost');
Route::get('/cart/product/view/{id}', 'CartController@viewProduct');
Route::get('product/cart', 'CartController@ShowCart')->name('show.cart');
Route::get('remove/cart/{rowId}', 'CartController@removeItem');
Route::post('update/cart/item/', 'CartController@updateItem')->name('update.cartitem');
// Product details Page
Route::get('products/{id}', 'ProductController@ProductsView');
Route::get('all/categories/{id}', 'ProductController@allCategories');
Route::get('/product/details/{id}/{product_name}', 'ProductController@productView')->name('details.page');
Route::get('add/wishlist/{id}', 'WishlistController@add_to_wish_list');
// Route::get('delete/wishlist/{id}', 'WishlistController@delete_wish_list');
Route::get('user/wishlist/', 'CartController@wishlist')->name('user.wishlist');
// Pyment Step
Route::get('payment/page', 'CartController@PaymentPage')->name('payment.step');
Route::post('user/payment/process/', 'PaymentController@Payment')->name('payment.process');
Route::post('buyByStripe', 'PaymentController@buyByStripe')->name('stripe.charge');
//order routes
Route::get('admin/pading/order', 'Admin\OrderController@NewOrder')->name('admin.newOrder');
Route::get('admin/view/order/{id}', 'Admin\OrderController@ViewOrder');

Route::get('admin/payment/accept/{id}', 'Admin\OrderController@PaymentAccept');
Route::get('admin/payment/cancel/{id}', 'Admin\OrderController@PaymentCancel');

Route::get('admin/accept/payment', 'Admin\OrderController@AcceptPayment')->name('admin.accept.payment');

Route::get('admin/cancel/order', 'Admin\OrderController@CancelOrder')->name('admin.cancel.order');

Route::get('admin/process/payment', 'Admin\OrderController@ProcessPayment')->name('admin.process.payment');
Route::get('admin/success/payment', 'Admin\OrderController@SuccessPayment')->name('admin.success.payment');

Route::get('admin/delevery/process/{id}', 'Admin\OrderController@DeleveryProcess');
Route::get('admin/delevery/done/{id}', 'Admin\OrderController@DeleveryDone');

/// SEO Setting Route
Route::get('admin/seo', 'Admin\OrderController@seo')->name('admin.seo');
Route::post('admin/seo/update', 'Admin\OrderController@UpdateSeo')->name('update.seo');
