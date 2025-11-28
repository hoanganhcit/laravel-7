<?php

Route::redirect('/admin', '/login');

// Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('index');
    Route::post('orders/filter-date', 'DashboardController@filter_date')->name('orders.filter_date');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoriesController');

    // Posts
    Route::delete('posts/destroy', 'PostsController@massDestroy')->name('posts.massDestroy');
    Route::resource('posts', 'PostsController');

    // Post Comments
    Route::delete('comments/destroy', 'PostCommentController@massDestroy')->name('comments.massDestroy');
    Route::post('active', 'PostCommentController@active')->name('comments.active');
    Route::resource('comments', 'PostCommentController');

    // Product Category
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Tag
    Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'ProductTagController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::get('products/render-new-variation', 'ProductController@renderNewVariation')->name('products.renderNewVariation');
    Route::get('products/reviews', 'ProductController@reviews')->name('products.reviews');
    Route::delete('products/reviews/delete/{id}', 'ProductController@reviews_destroy')->name('products.reviews.destroy');
    Route::delete('products/reviews/destroy', 'ProductController@reviews_massDestroy')->name('products.reviews.massDestroy');
    Route::post('products/attribute-values/{product_attribute}', 'ProductController@getAttributeValues')->name('products.getAttributeValues');
    Route::resource('products', 'ProductController');
    Route::post('products/render-gallery-product', 'ProductController@renderGalleryProduct')->name('products.renderGalleryProduct');

    // Product Atributes
    Route::delete('product-attributes/destroy', 'ProductAttributesController@massDestroy')->name('product-attributes.massDestroy');
    Route::resource('product-attributes', 'ProductAttributesController');
    Route::get('product-attributes/{id}/values', 'ProductAttributesController@attributeValues')->name('product-attributes.options');
    Route::post('product-attributes/insert-value', 'ProductAttributesController@attributeValuesStore')->name('product-attributes.insert-value');
    Route::delete('product-attributes/delete-value/{id}', 'ProductAttributesController@attributeValuesDelete')->name('product-attributes.delete-value');

    // Brand
    Route::delete('brands/destroy', 'BrandController@massDestroy')->name('brands.massDestroy');
    Route::resource('brands', 'BrandController');

    // Orders
    Route::delete('orders/destroy', 'OrdersController@massDestroy')->name('orders.massDestroy');
    Route::resource('orders', 'OrdersController');

    // Orders
    Route::delete('customers/destroy', 'CustomersController@massDestroy')->name('customers.massDestroy');
    Route::resource('customers', 'CustomersController');

    // Tags
    Route::delete('tags/destroy', 'TagsController@massDestroy')->name('tags.massDestroy');
    Route::resource('tags', 'TagsController');

    Route::get('/file-manager',function() {
        return view('admin.partials.file-manager');
    })->name('file-manager');

    // Banners
    Route::delete('banners/destroy', 'BannersController@massDestroy')->name('banners.massDestroy');
    Route::resource('banners', 'BannersController');

    // CMS
    Route::get('/settings', 'CmsController@index')->name('settings.index');
    Route::post('/settings', 'CmsController@update')->name('settings.store');
    Route::post('/settings/homepage', 'CmsController@homepage')->name('settings.homepage');
    Route::get('/settings/sort-products', 'CmsController@sortProducts')->name('settings.sortProducts');

    // Testimonials
    Route::delete('testimonials/destroy', 'TestimonialsController@massDestroy')->name('testimonials.massDestroy');
    Route::resource('testimonials', 'TestimonialsController');

    // Subscribers
    Route::get('/subscribers', 'SubscribersController@index')->name('subscribers.index');
    Route::get('/contacts', 'SubscribersController@contacts')->name('subscribers.contacts');
    Route::post('/quick-promotion', 'SubscribersController@quick_promotion')->name('subscribers.quick_promotion');
    Route::post('/reply-contact', 'SubscribersController@reply_contact')->name('subscribers.reply_contact');
    Route::post('/view-contact', 'SubscribersController@view_contact')->name('subscribers.view_contact');
    Route::delete('delete-contact/{id}', 'SubscribersController@del_contact')->name('subscribers.del_contact');
    Route::post('/contacts/send-email', 'SubscribersController@sendEmail')->name('contacts.sendEmail');

    // Pages
    Route::delete('pages/destroy', 'PagesController@massDestroy')->name('pages.massDestroy');
    Route::resource('pages', 'PagesController'); 


});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});


Route::group(['prefix' => '/', 'as' => 'site.', 'namespace' => 'Site'], function () {
    // Home
    Route::get('/', 'HomeController@index')->name('index');
    
    // Shop
    Route::get('shop', 'ShopController@index')->name('shop.index');
    
    // Product Category
    Route::get('product-category/{id}', 'ProductCategoryController@show')->name('product-category.show');
    
    // Product Quick View
    Route::get('product/quick-view/{id}', 'ProductController@quickView')->name('product.quickView');
    
    // Cart
    Route::post('cart/add', 'CartController@add')->name('cart.add');
    Route::post('cart/update', 'CartController@update')->name('cart.update');
    Route::post('cart/remove', 'CartController@remove')->name('cart.remove');
    Route::get('cart/get', 'CartController@get')->name('cart.get');
    Route::post('cart/clear', 'CartController@clear')->name('cart.clear');
});



// Google Sign In
Route::get('login/{provider}/', 'Api\LoginSocialController@redirect')->name('login.redirect');
Route::get('login/{provider}/callback/', 'Api\LoginSocialController@Callback')->name('login.callback');

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return redirect()->back();
});

Route::get('/create-sitemap', function () {
    Artisan::call('sitemap:create');
    return redirect()->back();
});
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return redirect()->back();
});

Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return redirect()->back();
});

Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    return redirect()->back();
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes();

