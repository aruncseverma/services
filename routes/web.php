<?php

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

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Config cleared</h1>';
});

Route::get('/storage-link', function() {
    $exitCode = Artisan::call('storage:link');
    //dd($exitCode);
    return '<h1>Storage link updated.</h1>';
});


// admin routes
Route::group(['prefix' => '/admin', 'namespace' => 'Admin'], function ($route) {;;;;;;;;;;;;;;;;;;;;;;;;;
    // auth
    $route->group(['prefix' => '/auth', 'namespace' => 'Auth'], function ($route) {
        $route->get('/login', ['uses' => 'LoginController@index', 'as' => 'admin.auth.login_form']);
        $route->post('/login', ['uses' => 'LoginController@handle', 'as' => 'admin.auth.login']);
        $route->get('/logout', ['uses' => 'LogoutController@handle', 'as' => 'admin.auth.logout']);
        $route->get('/profile', ['uses' => 'ProfileController@index', 'as' => 'admin.auth.profile_form']);
        $route->post('/profile', ['uses' => 'ProfileController@handle', 'as' => 'admin.auth.profile']);
        $route->get('/forgot-password', ['uses' => 'ForgotPasswordController@view', 'as' => 'admin.auth.forgot_password']);
        $route->post('/send-reset', ['uses' => 'ForgotPasswordController@send', 'as' => 'admin.auth.forgot_password.send']);
        $route->get('/reset-password', ['uses' => 'ResetPasswordController@view', 'as' => 'admin.auth.reset_password.form']);
        $route->post('/reset-password', ['uses' => 'ResetPasswordController@handle', 'as' => 'admin.auth.reset_password']);
    });
    // end auth

    // dashboard
    $route->group(['prefix' => '/', 'namespace' => 'Dashboard'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@handle', 'as' => 'admin.dashboard']);
        $route->get('/dashboard', ['uses' => 'IndexController@handle']);
    });
    // end dashboard

    // administrators
    $route->group(['prefix' => '/administrators', 'namespace' => 'Administrators'], function ($route) {
        $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.administrator.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.administrator.update']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.administrator.save']);
        $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.administrators.manage']);
        $route->post('/delete', ['uses' => 'DeleteController@handle', 'as' => 'admin.administrator.delete']);
        $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.administrator.update_status']);
        $route->post('/act-as', ['uses' => 'ActAsController@handle', 'as' => 'admin.administrator.act_as']);
    });
    // end

    // escorts
    $route->group(['prefix' => '/escorts', 'namespace' => 'Escorts'], function ($route) {
        $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.escort.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.escort.update']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.escort.save']);
        $route->get('/manage', ['uses' => 'ManageController@all', 'as' => 'admin.escorts.manage']);
        $route->get('/pending/manage', ['uses' => 'ManageController@pending', 'as' => 'admin.escorts.manage_pending']);
        $route->post('/delete', ['uses' => 'DeleteController@handle', 'as' => 'admin.escort.delete']);
        $route->get('/approval', ['uses' => 'UpdateApprovalController@handle', 'as' => 'admin.escort.update_approval']);
        $route->get('/email-verification-status', ['uses' => 'UpdateEmailVerificationStatusController@handle', 'as' => 'admin.escort.update_email_verification']);
        $route->post('/account-block', ['uses' => 'UpdateBlockedStatusController@handle', 'as' => 'admin.escort.account_block']);
        $route->get('/view-info', ['uses' => 'ViewInformationController@handle', 'as' => 'admin.escort.view_info']);
        $route->post('/act-as', ['uses' => 'ActAsController@handle', 'as' => 'admin.escort.act_as']);
        $route->get('/accounts-deleted', ['uses' => 'ManageDeleteRequestController@index', 'as' => 'admin.escorts.accounts_deleted']);
        $route->get('/restore-account', ['uses' => 'RecoverAccountDeletedController@handle', 'as' => 'admin.escorts.restore_account']);
    });
    // end

    // agency
    $route->group(['prefix' => '/agency', 'namespace' => 'Agency'], function ($route) {
        $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.agency.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.agency.update']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.agency.save']);
        $route->get('/manage', ['uses' => 'ManageController@all', 'as' => 'admin.agency.manage']);
        $route->get('/pending/manage', ['uses' => 'ManageController@pending', 'as' => 'admin.agency.manage_pending']);
        $route->post('/delete', ['uses' => 'DeleteController@handle', 'as' => 'admin.agency.delete']);
        $route->get('/approval', ['uses' => 'UpdateApprovalController@handle', 'as' => 'admin.agency.update_approval']);
        $route->get('/email-verification-status', ['uses' => 'UpdateEmailVerificationStatusController@handle', 'as' => 'admin.agency.update_email_verification']);
        $route->post('/account-block', ['uses' => 'UpdateBlockedStatusController@handle', 'as' => 'admin.agency.account_block']);
        $route->post('/act-as', ['uses' => 'ActAsController@handle', 'as' => 'admin.agency.act_as']);
    });
    // end agency

    // notes
    $route->group(['prefix' => '/notes', 'namespace' => 'Notes'], function ($route) {
        $route->get('/view', ['uses' => 'ViewController@index', 'as' => 'admin.notes.view']);
        $route->post('/add', ['uses' => 'CreateController@handle', 'as' => 'admin.note.add']);
    });
    // end notes

    // Finance
    $route->group(['prefix' => '/finance', 'namespace' => 'Finance'], function ($route) {
      $route->get('/transactions', ['uses' => 'TransactionsController@index', 'as' => 'admin.finance.transactions']);
      $route->get('/billers', ['uses' => 'BillersController@index', 'as' => 'admin.finance.billers']);
      $route->post('/billers', ['uses' => 'BillersController@save', 'as' => 'admin.finance.savebillers']);
      $route->get('/editbiller', ['uses' => 'BillersController@edit', 'as' => 'admin.finance.editbiller']);
      $route->get('/newbiller', ['uses' => 'BillersController@new', 'as' => 'admin.finance.newbiller']);
      $route->get('/packages', ['uses' => 'PackagesController@index', 'as' => 'admin.finance.packages']);
      $route->post('/packages', ['uses' => 'PackagesController@save', 'as' => 'admin.finance.savepackage']);
      $route->get('/editpackage', ['uses' => 'PackagesController@edit', 'as' => 'admin.finance.editpackage']);
      $route->get('/newpackage', ['uses' => 'PackagesController@new', 'as' => 'admin.finance.newpackage']);

      // Membership Plans
      $route->get('/plans', ['uses' => 'MembershipController@index', 'as' => 'admin.finance.plans']);
      $route->get('/plans/new', ['uses' => 'MembershipController@new', 'as' => 'admin.finance.newplan']);
      $route->post('/plans/create', ['uses' => 'MembershipController@save', 'as' => 'admin.finance.saveplans']);
      $route->get('/plans/edit', ['uses' => 'MembershipController@edit', 'as' => 'admin.finance.editplan']);
      $route->post('/plans/revoke', ['uses' => 'RevokeController@handle', 'as' => 'admin.finance.vip.revoke']);

      // Purchases
      $route->get('/plans/purchases', ['uses' => 'VipTransactionController@index', 'as' => 'admin.finance.vip.transaction']);
      $route->get('/plans/update/{id}', ['uses' => 'VipTransactionController@updateStatus', 'as' => 'admin.finance.vip.update']);
      $route->post('/plans/payment', ['uses' => 'MarkAsPaidController@handle', 'as' => 'admin.finance.vip.paid']);
    });

    // settings
    $route->group(['prefix' => '/settings', 'namespace' => 'Settings'], function ($route) {
        $route->get('/site', ['uses' => 'SiteSettingsController@index', 'as' => 'admin.settings.site']);
        $route->get('/mail', ['uses' => 'MailSettingsController@index', 'as' => 'admin.settings.mail']);
        $route->get('/image', ['uses' => 'ImageSettingsController@index', 'as' => 'admin.settings.image']);
        $route->get('/video', ['uses' => 'VideoSettingsController@index', 'as' => 'admin.settings.video']);
        $route->post('/video/watermark', ['uses' => 'VideoSettingsController@uploadFile', 'as' => 'admin.settings.watermark']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.settings.save']);
    });
    // end settings

    // languages
    $route->group(['prefix' => '/languages', 'namespace' => 'Languages'], function ($route) {
        $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.language.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.language.update']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.language.save']);
        $route->get('/manage', ['uses' => 'ManageController@all', 'as' => 'admin.languages.manage']);
        $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.language.update_status']);
    });
    // end languages

    // attributes
    $route->group(['prefix' => '/attributes', 'namespace' => 'Attributes'], function ($route) {
        $route->group(['prefix' => '/physical', 'namespace' => 'Physical'], function ($route) {
            $route->get('/{name?}/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.attribute.physical.create']);
            $route->get('/{name?}/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.attribute.physical.update']);
            $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.attribute.physical.save']);
            $route->get('/{name?}/manage', ['uses' => 'ManageController@all', 'as' => 'admin.attributes.physical.manage']);
            $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.attribute.physical.update_status']);
        });
        $route->group(['prefix' => '/languages', 'namespace' => 'Languages'], function ($route) {
            $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.attribute.languages.create']);
            $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.attribute.languages.update']);
            $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.attribute.languages.save']);
            $route->get('/manage', ['uses' => 'ManageController@all', 'as' => 'admin.attributes.languages.manage']);
            $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.attribute.languages.update_status']);
        });
    });
    // end attributes

    // locations
    $route->group(['prefix' => '/locations', 'namespace' => 'Locations'], function ($route) {
        $route->get('/manage', ['uses' => 'ManageController@all', 'as' => 'admin.locations.manage']);
        $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.location.update_status']);
    });
    // end locations

    // permissions
    $route->group(['prefix' => '/permissions', 'namespace' => 'Permissions'], function ($route) {
        $route->get('/manage', ['uses' => 'ManageController@index', 'as' => 'admin.permissions.manage']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.permissions.save']);
    });
    // end permissions

    // rate durations
    $route->group(['prefix' => '/rate-durations', 'namespace' => 'RateDurations'], function ($route) {
        $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.rate_duration.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.rate_duration.update']);
        $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.rate_durations.manage']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.rate_duration.save']);
        $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.rate_duration.update_status']);
    });
    // end rate durations

    // services
    $route->group(['prefix' => '/services', 'namespace' => 'Services'], function ($route) {
        // categories
        $route->group(['prefix' => 'categories', 'namespace' => 'Categories'], function ($route) {
            $route->get('/create', ['uses' => 'RenderFormController@view', 'as' => 'admin.services.categories.create']);
            $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.services.categories.update']);
            $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.services.categories.save']);
            $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.services.categories.manage']);
            $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.services.categories.update_status']);
        });
        // end categories

        // services
        $route->get('/create', ['uses' => 'RenderFormController@view', 'as' => 'admin.service.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.service.update']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.service.save']);
        $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.services.manage']);
        $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.service.update_status']);
        // end services
    });
    // end services

    // profile validation
    $route->group(['prefix' => '/profile-validation', 'namespace' => 'ProfileValidation'], function ($route) {
        $route->get('/manage', ['uses' => 'ManageController@index', 'as' => 'admin.profile_validation.manage']);
        $route->get('/view-data/{model}', ['uses' => 'ViewDataController@index', 'as' => 'admin.profile_validation.view']);
        $route->post('/delete/{model}', ['uses' => 'DeleteController@handle', 'as' => 'admin.profile_validation.delete']);
        $route->post('/approve/{model}', ['uses' => 'ApproveController@handle', 'as' => 'admin.profile_validation.approve']);
        $route->post('/deny/{model}', ['uses' => 'DenyController@handle', 'as' => 'admin.profile_validation.deny']);
    });
    // end profile validation

    // members
    $route->group(['prefix' => '/members', 'namespace' => 'Members'], function ($route) {
        $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.member.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.member.update']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.member.save']);
        $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.members.manage']);
        $route->post('/delete', ['uses' => 'DeleteController@handle', 'as' => 'admin.member.delete']);
        $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.member.update_status']);
        $route->post('/act-as', ['uses' => 'ActAsController@handle', 'as' => 'admin.member.act_as']);
    });
    // end members

    // posts
    $route->group(['prefix' => '/posts', 'namespace' => 'Posts'], function ($route) {
        $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.post.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.post.update']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.post.save']);
        $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.posts.manage']);
        $route->post('/delete', ['uses' => 'DeleteController@handle', 'as' => 'admin.post.delete']);
        $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.post.update_status']);
        $route->get('/get-description', ['uses' => 'GetDescriptionController@view', 'as' => 'admin.post.get_description']);
        $route->post('/multiple-delete', ['uses' => 'MultipleDeleteController@handle', 'as' => 'admin.posts.m_delete']);
        $route->get('/clone', ['uses' => 'CloneController@handle', 'as' => 'admin.post.clone']);
        $route->post('/multiple-clone', ['uses' => 'MultipleCloneController@handle', 'as' => 'admin.posts.m_clone']);
        $route->post('/multiple-update-status', ['uses' => 'MultipleUpdateStatusController@handle', 'as' => 'admin.posts.m_update_status']);

        // categories
        $route->group(['prefix' => 'categories', 'namespace' => 'Categories'], function ($route) {
            $route->get('/create', ['uses' => 'RenderFormController@view', 'as' => 'admin.posts.categories.create']);
            $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.posts.categories.update']);
            $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.posts.categories.save']);
            $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.posts.categories.manage']);
            $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.posts.categories.update_status']);
            $route->post('/delete', ['uses' => 'DeleteController@handle', 'as' => 'admin.posts.categories.delete']);
            $route->get('/get-categories', ['uses' => 'GetCategoriesController@handle', 'as' => 'admin.posts.categories.get_categories']);
            $route->get('/get-category', ['uses' => 'GetCategoryController@handle', 'as' => 'admin.posts.categories.get_category']);
            $route->get('/preview', ['uses' => 'PreviewController@handle', 'as' => 'admin.posts.categories.preview']);
            $route->get('/get-description', ['uses' => 'GetDescriptionController@view', 'as' => 'admin.posts.categories.get_description']);
            $route->post('/quick-add', ['uses' => 'QuickAddController@handle', 'as' => 'admin.posts.categories.quick_add']);
            $route->post('/multiple-delete', ['uses' => 'MultipleDeleteController@handle', 'as' => 'admin.posts.categories.m_delete']);
            $route->post('/multiple-update-status', ['uses' => 'MultipleUpdateStatusController@handle', 'as' => 'admin.posts.categories.m_update_status']);
        });
        // end categories

        // tags
        $route->group(['prefix' => 'tags', 'namespace' => 'Tags'], function ($route) {
            $route->get('/create', ['uses' => 'RenderFormController@view', 'as' => 'admin.posts.tags.create']);
            $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.posts.tags.update']);
            $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.posts.tags.save']);
            $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.posts.tags.manage']);
            $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.posts.tags.update_status']);
            $route->post('/delete', ['uses' => 'DeleteController@handle', 'as' => 'admin.posts.tags.delete']);
            $route->get('/preview', ['uses' => 'PreviewController@handle', 'as' => 'admin.posts.tags.preview']);
            $route->get('/get-description', ['uses' => 'GetDescriptionController@view', 'as' => 'admin.posts.tags.get_description']);
            $route->post('/quick-add', ['uses' => 'QuickAddController@handle', 'as' => 'admin.posts.tags.quick_add']);
            $route->post('/multiple-delete', ['uses' => 'MultipleDeleteController@handle', 'as' => 'admin.posts.tags.m_delete']);
            $route->post('/multiple-update-status', ['uses' => 'MultipleUpdateStatusController@handle', 'as' => 'admin.posts.tags.m_update_status']);
        });
        // end tags

        // comments
        $route->group(['prefix' => 'comments', 'namespace' => 'Comments'], function ($route) {
            //$route->get('/create', ['uses' => 'RenderFormController@view', 'as' => 'admin.posts.tags.create']);
            //$route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.posts.tags.update']);
            //$route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.posts.tags.save']);
            $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.posts.comments.manage']);
            $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.posts.comments.update_status']);
            $route->post('/delete', ['uses' => 'DeleteController@handle', 'as' => 'admin.posts.comments.delete']);
            $route->post('/multiple-delete', ['uses' => 'MultipleDeleteController@handle', 'as' => 'admin.posts.comments.m_delete']);
            //$route->get('/preview', ['uses' => 'PreviewController@handle', 'as' => 'admin.posts.tags.preview']);
            //$route->get('/get-description', ['uses' => 'GetDescriptionController@view', 'as' => 'admin.posts.tags.get_description']);
        });
        // end comments

        // photos
        $route->post('/upload-photo', ['uses' => 'UploadPhotoController@handle', 'as' => 'admin.post.upload_photo']);
        $route->post('/delete-photo', ['uses' => 'DeletePhotoController@handle', 'as' => 'admin.post.delete_photo']);
        // end photos
    });
    // end posts

    // pages
    $route->group(['prefix' => '/pages', 'namespace' => 'Pages'], function ($route) {
        $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.page.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.page.update']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.page.save']);
        $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.pages.manage']);
        $route->post('/delete', ['uses' => 'DeleteController@handle', 'as' => 'admin.page.delete']);
        $route->get('/update-status', ['uses' => 'UpdateStatusController@handle', 'as' => 'admin.page.update_status']);
        $route->get('/get-description', ['uses' => 'GetDescriptionController@view', 'as' => 'admin.page.get_description']);
        // photos
        $route->post('/upload-photo', ['uses' => 'UploadPhotoController@handle', 'as' => 'admin.page.upload_photo']);
        $route->post('/delete-photo', ['uses' => 'DeletePhotoController@handle', 'as' => 'admin.page.delete_photo']);
        // end photos

        // select parent page
        $route->get('/get-pages', ['uses' => 'GetPagesController@handle', 'as' => 'admin.page.get_pages']);
        $route->get('/get-page', ['uses' => 'GetPageController@handle', 'as' => 'admin.page.get_page']);

        $route->post('/multiple-delete', ['uses' => 'MultipleDeleteController@handle', 'as' => 'admin.pages.m_delete']);
        $route->get('/clone', ['uses' => 'CloneController@handle', 'as' => 'admin.page.clone']);
        $route->post('/multiple-clone', ['uses' => 'MultipleCloneController@handle', 'as' => 'admin.pages.m_clone']);
        $route->post('/multiple-update-status', ['uses' => 'MultipleUpdateStatusController@handle', 'as' => 'admin.pages.m_update_status']);
    });
    // end pages

    // translations
    $route->group(['prefix' => '/translations', 'namespace' => 'Translations'], function ($route) {
        $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'admin.translation.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'admin.translation.update']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'admin.translation.save']);
        $route->get('/manage', ['uses' => 'ManageController@view', 'as' => 'admin.translations.manage']);
        $route->post('/delete', ['uses' => 'DeleteController@handle', 'as' => 'admin.translation.delete']);
        $route->post('/multiple-update', ['uses' => 'MultipleUpdateController@handle', 'as' => 'admin.translations.m_update']);
        $route->get('/get-groups', ['uses' => 'GetGroupsController@view', 'as' => 'admin.translations.get_groups']);
        $route->post('/multiple-delete', ['uses' => 'MultipleDeleteController@handle', 'as' => 'admin.translations.m_delete']);
        $route->get('/multiple-new', ['uses' => 'RenderBulkFormController@view', 'as' => 'admin.translation.m_create']);
        $route->post('/multiple-save', ['uses' => 'SaveBulkController@handle', 'as' => 'admin.translation.m_save']);
        $route->any('/transfer-data/{mode}', ['uses' => 'TransferDataController@handle', 'as' => 'admin.translation.transfer_data']);
    });
    // end translations

    // scripts
    $route->group(['prefix' => '/scripts', 'namespace' => 'Scripts'], function ($route) {
        $route->get('/generate-escorts', ['uses' => 'GenerateEscortsController@handle', 'as' => 'admin.script.generate_escorts']);
    });
    // end scripts
});
// end admin routes

// locations routes
Route::group(['prefix' => '/locations', 'namespace' => 'Common\Locations'], function ($route) {
    $route->get('/countries', ['uses' => 'FetchCountriesController@handle', 'as' => 'common.locations.countries']);
    $route->get('/states', ['uses' => 'FetchStatesController@handle', 'as' => 'common.locations.states']);
    $route->get('/cities', ['uses' => 'FetchCitiesController@handle', 'as' => 'common.locations.cities']);
});
// end locations

// escort admin routes
Route::group(['prefix' => '/escort-admin', 'namespace' => 'EscortAdmin', 'middleware' => 'switch.locale'], function ($route) {
    // auth
    $route->group(['prefix' => '/auth', 'namespace' => 'Auth'], function ($route) {
        $route->get('/login', ['uses' => 'LoginController@index', 'as' => 'escort_admin.auth.login_form']);
        $route->post('/login', ['uses' => 'LoginController@handle', 'as' => 'escort_admin.auth.login']);
        $route->get('/logout', ['uses' => 'LogoutController@handle', 'as' => 'escort_admin.auth.logout']);
        $route->get('/forgot-password', ['uses' => 'ForgotPasswordController@view', 'as' => 'escort_admin.auth.forgot_password']);
        $route->post('/send-reset', ['uses' => 'ForgotPasswordController@send', 'as' => 'escort_admin.auth.forgot_password.send']);
        $route->get('/reset-password', ['uses' => 'ResetPasswordController@view', 'as' => 'escort_admin.auth.reset_password.form']);
        $route->post('/reset-password', ['uses' => 'ResetPasswordController@handle', 'as' => 'escort_admin.auth.reset_password']);
    });
    // end auth

    // dashboard
    $route->group(['prefix' => '/', 'namespace' => 'Dashboard'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@handle', 'as' => 'escort_admin.dashboard']);
        $route->get('/dashboard', ['uses' => 'IndexController@handle']);
    });
    // end dashboard

    // account settings
    $route->group(['prefix' => '/account-settings', 'namespace' => 'AccountSettings'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@index', 'as' => 'escort_admin.account_settings']);
        $route->post('/change-email', ['uses' => 'UpdateEmailController@handle', 'as' => 'escort_admin.account_settings.update_email']);
        $route->get('/change-email/{token}', ['uses' => 'VerifyUpdateEmailController@index', 'as' => 'escort_admin.account_settings.change_email']);
        $route->post('/change-password', ['uses' => 'UpdatePasswordController@handle', 'as' => 'escort_admin.account_settings.change_password']);
        $route->post('/change-newsletter-subscription-setting', ['uses' => 'UpdateNewsletterSubscriptionController@handle', 'as' => 'escort_admin.account_settings.change_newsletter_subscription']);
        $route->post('/account-delete', ['uses' => 'DeleteAccountController@handle', 'as' => 'escort_admin.account_settings.account_deletion']);
        $route->post('/change-ban-countries', ['uses' => 'UpdateBanCountriesController@handle', 'as' => 'escort_admin.account_settings.ban_countries']);
        $route->post('/switch-account', ['uses' => 'SwitchAccountController@handle', 'as' => 'escort_admin.account_settings.switch_account']);
        $route->get('/accept-independent/{_token}', ['uses' => 'AcceptIndependentController@handle', 'as' => 'escort_admin.account_settings.accept_independent']);
    });
    // end account settings

    // photos
    $route->group(['prefix' => '/photos', 'namespace' => 'Photos'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@index', 'as' => 'escort_admin.photos']);
        $route->post('/upload', ['uses' => 'UploadController@handle', 'as' => 'escort_admin.photos.upload']);
        $route->post('/remove', ['uses' => 'DeletePhotoController@handle', 'as' => 'escort_admin.photos.remove']);
        $route->post('/rename', ['uses' => 'UpdatePhotoController@handle', 'as' => 'escort_admin.photos.rename']);
        $route->get('/primary/{id}', ['uses' => 'UpdatePhotoController@changePrimary', 'as' => 'escort_admin.photos.primary']);
        $route->get('/folder', ['uses' => 'FolderController@getAllPrivateFolders', 'as' => 'escort_admin.photos.folder']);
        $route->get('/folder/{id}', ['uses' => 'FolderController@getFolderInfo', 'as' => 'escort_admin.photos.folder.view']);
        $route->post('/folder/create', ['uses' => 'CreateFolderController@handle', 'as' => 'escort_admin.photos.folder.create']);
        $route->post('/folder/rename', ['uses' => 'UpdateFolderController@handle', 'as' => 'escort_admin.photos.folder.rename']);
        $route->get('/folder/delete/{folder_id}', ['uses' => 'DeleteFolderController@handle', 'as' => 'escort_admin.photos.folder.delete']);
    });
    // end photos

    // escort profile
    $route->group(['prefix' => '/profile', 'namespace' => 'Profile'], function ($route) {
        $route->get('/', ['uses' => 'RenderFormController@view', 'as' => 'escort_admin.profile']);
        $route->post('/save-basic-information', ['uses' => 'UpdateBasicInformationController@handle', 'as' => 'escort_admin.profile.basic_information']);
        $route->post('/save-about-me', ['uses' => 'UpdateAboutMeController@handle', 'as' => 'escort_admin.profile.about_me']);
        $route->post('/save-main-location', ['uses' => 'UpdateMainLocationController@handle', 'as' => 'escort_admin.profile.main_location']);
        $route->post('/save-additional-location', ['uses' => 'AddAdditionalLocationController@handle', 'as' => 'escort_admin.profile.additional_location']);
        $route->get('/delete-location', ['uses' => 'DeleteLocationController@handle', 'as' => 'escort_admin.profile.delete_location']);
        $route->post('/save-physical-information', ['uses' => 'UpdatePhysicalInformationController@handle', 'as' => 'escort_admin.profile.physical_information']);
        $route->post('/save-contact-information', ['uses' => 'UpdateContactInformationController@handle', 'as' => 'escort_admin.profile.contact_information']);
        $route->post('/save-language-proficiency', ['uses' => 'AddLanguageProficiencyController@handle', 'as' => 'escort_admin.profile.language_proficiency.add']);
        $route->get('/delete-language-proficiency', ['uses' => 'DeleteLanguageProficiencyController@handle', 'as' => 'escort_admin.profile.language_proficiency.delete']);
        $route->post('/save-geo-location', ['uses' => 'UpdateGeoLocationController@handle', 'as' => 'escort_admin.profile.geo_location']);
    });
    // end escort profile

    // rates-services
    $route->group(['prefix' => 'rates-services', 'namespace' => 'Services'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@view', 'as' => 'escort_admin.rates_services']);
        $route->post('/update-schedules', ['uses' => 'UpdateSchedulesController@handle', 'as' => 'escort_admin.rates_services.update_schedules']);
        $route->post('/update-rates', ['uses' => 'UpdateRatesController@handle', 'as' => 'escort_admin.rates_services.update_rates']);
        $route->post('/update-services/{category}', ['uses' => 'UpdateServicesController@handle', 'as' => 'escort_admin.services.update_services']);
        $route->get('/get-rates', ['uses' => 'GetRatesController@handle', 'as' => 'escort_admin.rates_services.get_rates']);
    });
    // end rates-services

    // tour plan
    $route->group(['prefix' => '/tour-plans', 'namespace' => 'TourPlans'], function ($route) {
        $route->get('/', ['uses' => 'RenderFormController@view', 'as' => 'escort_admin.tour_plans']);
        $route->post('/add', ['uses' => 'AddController@handle', 'as' => 'escort_admin.tour_plans.add']);
        $route->post('/update', ['uses' => 'UpdateController@handle', 'as' => 'escort_admin.tour_plans.update']);
        $route->get('/delete', ['uses' => 'DeleteController@handle', 'as' => 'escort_admin.tour_plans.delete']);
    });
    // end tour plan

    // profile validation
    $route->group(['prefix' => 'profile-validation', 'namespace' => 'ProfileValidation'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@view', 'as' => 'escort_admin.profile_validation']);
        $route->post('/silver-validation', ['uses' => 'SilverProfileValidationController@handle', 'as' => 'escort_admin.profile_validation.silver']);
        $route->post('/gold-validation', ['uses' => 'GoldProfileValidationController@handle', 'as' => 'escort_admin.profile_validation.gold']);
    });
    // end profile validation

    // reviews
    $route->group(['prefix' => '/reviews', 'namespace' => 'Reviews'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@handle', 'as' => 'escort_admin.reviews']);
        $route->post('/reply', ['uses' => 'ReplyController@handle', 'as' => 'escort_admin.reviews.reply']);
        $route->post('/seen-reply', ['uses' => 'SeenReviewReplyController@handle', 'as' => 'escort_admin.review.seen_reply']);
    });
    // end reviews

    // bookings
    $route->group(['prefix' => '/bookings', 'namespace' => 'Bookings'], function ($route) {
        $route->get('/', ['uses' => 'ManageController@index', 'as' => 'escort_admin.bookings']);
    });
    // end bookings

    // emails
    $route->group(['prefix' => '/emails', 'namespace' => 'Emails'], function ($route) {
        $route->get('/', ['uses' => 'ManageController@index', 'as' => 'escort_admin.emails.manage']);
        $route->get('/read/{id}', ['uses' => 'ReadEmailController@handle', 'as' => 'escort_admin.emails.view']);
        $route->get('/compose', ['uses' => 'RenderFormController@view', 'as' => 'escort_admin.emails.compose']);
        $route->post('/send', ['uses' => 'SendEmailController@handle', 'as' => 'escort_admin.emails.send']);
        $route->get('/star/{id}', ['uses' => 'StarEmailController@handle', 'as' => 'escort_admin.emails.star']);
        $route->post('/delete', ['uses' => 'DeleteEmailController@handle', 'as' => 'escort_admin.emails.delete']);
        $route->get('/check-email', ['uses' => 'CheckEmailController@handle', 'as' => 'escort_admin.emails.check_email']);
    });
    // end emails

    // followers
    $route->group(['prefix' => '/followers', 'namespace' => 'Followers'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@handle', 'as' => 'escort_admin.followers']);
        $route->get('/ban', ['uses' => 'BanController@handle', 'as' => 'escort_admin.followers.ban']);
        $route->post('/multiple-ban', ['uses' => 'MultipleBanController@handle', 'as' => 'escort_admin.followers.multiple_ban']);
        $route->get('/rate-customer', ['uses' => 'RateCustomerController@handle', 'as' => 'escort_admin.followers.rate_customer']);
    });
    // end followers

    // videos
    $route->group(['prefix' => '/videos', 'namespace' => 'Videos'], function ($route) {
        // $route->get('/', ['uses' => 'ManageController@view', 'as' => 'escort_admin.videos']);
        $route->get('/', ['uses' => 'GridController@view', 'as' => 'escort_admin.videos']);
        $route->post('/update-position', ['uses' => 'UpdateVideoPositionController@handle', 'as' => 'escort_admin.videos.position']);
        $route->post('/public/upload', ['uses' => 'UploadPublicVideoController@handle', 'as' => 'escort_admin.videos.upload_public_video']);
        $route->post('/public/new/upload', ['uses' => 'UploadNewPublicVideoController@handle', 'as' => 'escort_admin.videos.upload_new_public_video']);
        $route->post('/public/delete', ['uses' => 'DeletePublicVideoController@handle', 'as' => 'escort_admin.videos.delete_public_video']);
        $route->post('/private/create-folder', ['uses' => 'CreateFolderController@handle', 'as' =>  'escort_admin.videos.private_create_folder']);
        $route->post('/private/switch-folder', ['uses' => 'SwitchFolderController@handle', 'as' =>  'escort_admin.videos.private_switch_folder']);
        $route->post('/private/rename-folder', ['uses' => 'RenameFolderController@handle', 'as' =>  'escort_admin.videos.private_rename_folder']);
        $route->post('/private/delete-folder', ['uses' => 'DeleteFolderController@handle', 'as' =>  'escort_admin.videos.private_delete_folder']);
        $route->post('/private/new/upload', ['uses' => 'UploadNewPrivateVideoController@handle', 'as' => 'escort_admin.videos.upload_new_private_video']);
        $route->post('/private/upload', ['uses' => 'UploadPrivateVideoController@handle', 'as' => 'escort_admin.videos.upload_private_video']);
        $route->post('/private/delete', ['uses' => 'DeletePrivateVideoController@handle', 'as' => 'escort_admin.videos.delete_private_video']);
    });

    // end videos

    // Buy credits
    $route->group(['prefix' => '/buycredits', 'namespace' => 'BuyCredits'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@view', 'as' => 'escort_admin.buycredits']);
        $route->get('/packages', ['uses' => 'IndexController@getPackages', 'as' => 'escort_admin.packages']);
        $route->get('/paynow', ['uses' => 'IndexController@getPayPage', 'as' => 'escort_admin.paypage']);
        $route->get('/confirm', ['uses' => 'IndexController@getConfirmPage', 'as' => 'escort_admin.confirmpage']);
    });
    // End Buy credits

    // VIP Subscriptions
    $route->group(['prefix' => '/vip', 'namespace' => 'Membership'], function($route) {
        $route->get('/', ['uses' => 'PurchaseController@index', 'as' => 'escort_admin.vip.home']);
        $route->post('/purchase', ['uses' => 'PurchaseController@purchase', 'as' => 'escort_admin.vip.purchase']);
    });

    // notifications
    $route->group(['prefix' => '/notification', 'namespace' => 'Notifications'], function ($route) {
        $route->post('/read', ['uses' => 'MarkAsReadController@handle', 'as' => 'escort_admin.notification.read']);
    });
});
// end escort admin routes

// Storage router
Route::get('/storage/{file_name}', 'PrivateFileController')->where(['file_name' => '.*']);
Route::get('/videos', ['uses' => 'Common\Videos\RenderVideoController@index', 'as' => 'common.video']);
Route::get('/photos/{photo}/{path}', ['uses' => 'Common\Photos\RenderPhotoController@render', 'as' => 'common.photo'])
    ->where(['path' => '.*']);
Route::get('/post-photos/{photo}/{path}', ['uses' => 'Common\Photos\RenderPostPhotoController@render', 'as' => 'common.post_photo'])
    ->where(['path' => '.*']);

// agency admin routes
Route::group(['prefix' => '/agency-admin', 'namespace' => 'AgencyAdmin', 'middleware' => 'switch.locale'], function ($route) {
    // auth
    $route->group(['prefix' => '/auth', 'namespace' => 'Auth'], function ($route) {
        $route->get('/login', ['uses' => 'LoginController@index', 'as' => 'agency_admin.auth.login_form']);
        $route->post('/login', ['uses' => 'LoginController@handle', 'as' => 'agency_admin.auth.login']);
        $route->get('/logout', ['uses' => 'LogoutController@handle', 'as' => 'agency_admin.auth.logout']);
        $route->get('/forgot-password', ['uses' => 'ForgotPasswordController@view', 'as' => 'agency_admin.auth.forgot_password']);
        $route->post('/send-reset', ['uses' => 'ForgotPasswordController@send', 'as' => 'agency_admin.auth.forgot_password.send']);
        $route->get('/reset-password', ['uses' => 'ResetPasswordController@view', 'as' => 'agency_admin.auth.reset_password.form']);
        $route->post('/reset-password', ['uses' => 'ResetPasswordController@handle', 'as' => 'agency_admin.auth.reset_password']);
    });
    // end auth

    // dashboard
    $route->group(['prefix' => '/', 'namespace' => 'Dashboard'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@handle', 'as' => 'agency_admin.dashboard']);
        $route->get('/dashboard', ['uses' => 'IndexController@handle']);
    });
    // end dashboard

    // profile
    $route->group(['prefix' => '/profile', 'namespace' => 'Profile'], function ($route) {
        $route->get('/', ['uses' => 'RenderFormController@view', 'as' => 'agency_admin.profile']);
        $route->post('/update-basic-info', ['uses' => 'UpdateBasicInformationController@handle', 'as' => 'agency_admin.profile.update_basic_info']);
        $route->post('/update-about', ['uses' => 'UpdateAboutController@handle', 'as' => 'agency_admin.profile.update_about']);
        $route->post('/update-contact-information', ['uses' => 'UpdateContactInformationController@handle', 'as' => 'agency_admin.profile.update_contact_information']);
        $route->post('/upload-profile-photo', ['uses' => 'UploadProfilePhotoController@handle', 'as' => 'agency_admin.profile.upload_profile_photo']);
        $route->post('/delete-profile-photo', ['uses' => 'DeleteProfilePhotoController@handle', 'as' => 'agency_admin.profile.delete_profile_photo']);
    });
    // end profile

    // escorts
    $route->group(['prefix' => '/escorts', 'namespace' => 'Escorts'], function ($route) {
        $route->get('/accept-invitation/{_token}', ['uses' => 'AcceptEscortApplicationController@handle', 'as' => 'agency_admin.escorts.accept_invitation']);
        $route->get('/', ['uses' => 'ManageController@index', 'as' => 'agency_admin.escorts']);
        $route->get('/new', ['uses' => 'RenderFormController@view', 'as' => 'agency_admin.escort.create']);
        $route->get('/update', ['uses' => 'RenderFormController@view', 'as' => 'agency_admin.escort.update']);
        $route->post('/save', ['uses' => 'SaveController@handle', 'as' => 'agency_admin.escort.save']);
        $route->post('/remove-escort/{escort}', ['uses' => 'RemoveEscortController@handle', 'as' => 'agency_admin.escort.remove']);
    });
    // end escorts

    // reviews
    $route->group(['prefix' => '/reviews', 'namespace' => 'Reviews'], function ($route) {
        $route->get('/', ['uses' => 'ManageController@index', 'as' => 'agency_admin.reviews']);
        $route->post('/reply/{review}', ['uses' => 'ReplyController@handle', 'as' => 'agency_admin.review.reply']);
        $route->post('/seen-reply', ['uses' => 'SeenReviewReplyController@handle', 'as' => 'agency_admin.review.seen_reply']);
    });
    // end reviews

    // account settings
    $route->group(['prefix' => '/account-settings', 'namespace' => 'AccountSettings'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@index', 'as' => 'agency_admin.account_settings']);
        $route->post('/change-email', ['uses' => 'UpdateEmailController@handle', 'as' => 'agency_admin.account_settings.update_email']);
        $route->get('/change-email/{token}', ['uses' => 'VerifyUpdateEmailController@index', 'as' => 'agency_admin.account_settings.change_email']);
        $route->post('/change-password', ['uses' => 'UpdatePasswordController@handle', 'as' => 'agency_admin.account_settings.change_password']);
        $route->post('/change-newsletter-subscription-setting', ['uses' => 'UpdateNewsletterSubscriptionController@handle', 'as' => 'agency_admin.account_settings.change_newsletter_subscription']);
        $route->post('/account-delete', ['uses' => 'DeleteAccountController@handle', 'as' => 'agency_admin.account_settings.account_deletion']);
        $route->post('/change-ban-countries', ['uses' => 'UpdateBanCountriesController@handle', 'as' => 'agency_admin.account_settings.ban_countries']);
        $route->post('/switch-account', ['uses' => 'SwitchAccountController@handle', 'as' => 'agency_admin.account_settings.switch_account']);
        $route->get('/accept-independent/{_token}', ['uses' => 'AcceptIndependentController@handle', 'as' => 'agency_admin.account_settings.accept_independent']);
    });
    // end account settings

    // emails
    $route->group(['prefix' => '/emails', 'namespace' => 'Emails'], function ($route) {
        $route->get('/', ['uses' => 'ManageController@index', 'as' => 'agency_admin.emails.manage']);
        $route->get('/read/{email}', ['uses' => 'ReadEmailController@handle', 'as' => 'agency_admin.emails.view']);
        $route->get('/compose', ['uses' => 'RenderFormController@view', 'as' => 'agency_admin.emails.compose']);
        $route->post('/send', ['uses' => 'SendEmailController@handle', 'as' => 'agency_admin.emails.send']);
        $route->get('/star/{email}', ['uses' => 'StarEmailController@handle', 'as' => 'agency_admin.emails.star']);
        $route->post('/delete', ['uses' => 'DeleteEmailController@handle', 'as' => 'agency_admin.emails.delete']);
        $route->get('/check-email', ['uses' => 'CheckEmailController@handle', 'as' => 'agency_admin.emails.check_email']);
    });
    // end emails

    // followers
    $route->group(['prefix' => '/followers', 'namespace' => 'Followers'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@handle', 'as' => 'agency_admin.followers']);
        $route->post('/delete/{follower}', ['uses' => 'DeleteFollowerController@handle', 'as' => 'agency_admin.follower.delete']);
        $route->get('/rate/{follower}', ['uses' => 'RateFollowerController@handle', 'as' => 'agency_admin.follower.rate']);
    });
    // end followers

    // Buy credits
    $route->group(['prefix' => '/buycredits', 'namespace' => 'BuyCredits'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@view', 'as' => 'agency_admin.buycredits']);
        $route->get('/packages', ['uses' => 'IndexController@getPackages', 'as' => 'agency_admin.packages']);
        $route->get('/paynow', ['uses' => 'IndexController@getPayPage', 'as' => 'agency_admin.paypage']);
        $route->get('/confirm', ['uses' => 'IndexController@getConfirmPage', 'as' => 'agency_admin.confirmpage']);
    });
    // End Buy credits
});
// end agency admin routes

Route::group(['prefix' => '/', 'namespace' => 'Index', 'middleware' => 'switch.locale'], function ($route) {

    // homepage
    $route->group(['prefix' => '/', 'namespace' => 'Home'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@view', 'as' => 'index.home']);

        // ajax locations' routes
        $route->get('/escorts', ['uses' => 'EscortController@findEscort', 'as' => 'index.escort.list']);
        $route->get('/escorts/country/{countryId}', ['uses' => 'EscortController@findEscort', 'as' => 'index.escort.filter.country']);
        $route->get('/escorts/state/{stateId}', ['uses' => 'EscortController@findEscort', 'as' => 'index.escort.filter.state']);
        $route->get('/escorts/state/{cityId}', ['uses' => 'EscortController@findEscort', 'as' => 'index.escort.filter.city']);
    });
    // end homepage

    // profile
    $route->group(['prefix' => 'profile', 'namespace' => 'Profile'], function ($route) {
        $route->post('/add-review', ['uses' => 'AddReviewController@handle', 'as' => 'index.profile.add_review'])->middleware('handle.ajax');
        $route->post('/add-favorite', ['uses' => 'AddFavoriteController@handle', 'as' => 'index.profile.add_favorite']);
        $route->post('/add-booking', ['uses' => 'AddBookingController@handle', 'as' => 'index.profile.add_booking'])->middleware('handle.ajax');
        $route->post('/add-report', ['uses' => 'AddReportController@handle', 'as' => 'index.profile.add_report']);
        $route->get('/{username}', ['uses' => 'RenderProfileController@view', 'as' => 'index.profile']);
    });

    //Route::get('ajax-pagination', 'Profile\RenderProfileController@ajaxPagination')->name('ajax.pagination');

    Route::get('/ajax-pagination', ['uses' => 'Profile\RenderProfileController@ajaxPagination', 'as' => 'ajax.pagination']);

    // end profile

    // $route->group(['prefix' => '/auth', 'namespace' => 'Auth'], function ($route) {
    //     $route->post('/login', ['uses' => 'LoginController@handle', 'as' => 'index.auth.login']);
    //     $route->get('/logout', ['uses' => 'LogoutController@handle', 'as' => 'index.auth.logout']);
    // });

    // auth
    $route->group(['prefix' => '/auth', 'namespace' => 'Auth'], function ($route) {
        $route->get('/login', ['uses' => 'LoginController@index', 'as' => 'index.auth.login_form']);
        $route->post('/login', ['uses' => 'LoginController@handle', 'as' => 'index.auth.login']);
        $route->get('/logout', ['uses' => 'LogoutController@handle', 'as' => 'index.auth.logout']);
        $route->get('/profile', ['uses' => 'ProfileController@index', 'as' => 'index.auth.profile_form']);
        $route->post('/profile', ['uses' => 'ProfileController@handle', 'as' => 'index.auth.profile']);
        $route->get('/forgot-password', ['uses' => 'ForgotPasswordController@view', 'as' => 'index.auth.forgot_password']);
        $route->post('/send-reset', ['uses' => 'ForgotPasswordController@send', 'as' => 'index.auth.forgot_password.send']);
        $route->get('/reset-password', ['uses' => 'ResetPasswordController@view', 'as' => 'index.auth.reset_password.form']);
        $route->post('/reset-password', ['uses' => 'ResetPasswordController@handle', 'as' => 'index.auth.reset_password']);
    });
    // end auth

    // newsletter subscription
    $route->group(['prefix' => 'newsletter', 'namespace' => 'Subscription'], function ($route) {
        $route->post('/subscribe', ['uses' => 'NewsletterController@handle', 'as' => 'index.newsletter.subscribe']);
    });
});

// member admin routes
Route::group(['prefix' => '/member-admin', 'namespace' => 'MemberAdmin', 'middleware' => 'switch.locale'], function ($route) {
    // auth
    $route->group(['prefix' => '/auth', 'namespace' => 'Auth'], function ($route) {
        $route->get('/login', ['uses' => 'LoginController@index', 'as' => 'member_admin.auth.login_form']);
        $route->post('/login', ['uses' => 'LoginController@handle', 'as' => 'member_admin.auth.login']);
        $route->get('/logout', ['uses' => 'LogoutController@handle', 'as' => 'member_admin.auth.logout']);
        $route->get('/forgot-password', ['uses' => 'ForgotPasswordController@view', 'as' => 'member_admin.auth.forgot_password']);
        $route->post('/send-reset', ['uses' => 'ForgotPasswordController@send', 'as' => 'member_admin.auth.forgot_password.send']);
        $route->get('/reset-password', ['uses' => 'ResetPasswordController@view', 'as' => 'member_admin.auth.reset_password.form']);
        $route->post('/reset-password', ['uses' => 'ResetPasswordController@handle', 'as' => 'member_admin.auth.reset_password']);
    });
    // end auth

    // profile
    $route->group(['prefix' => '/profile', 'namespace' => 'Profile'], function ($route) {
        $route->get('/', ['uses' => 'RenderFormController@view', 'as' => 'member_admin.profile']);
        $route->post('/update-basic-info', ['uses' => 'UpdateBasicInformationController@handle', 'as' => 'member_admin.profile.update_basic_info']);
        $route->post('/update-about', ['uses' => 'UpdateAboutController@handle', 'as' => 'member_admin.profile.update_about']);
        $route->post('/update-contact-information', ['uses' => 'UpdateContactInformationController@handle', 'as' => 'member_admin.profile.update_contact_information']);
        $route->post('/upload-profile-photo', ['uses' => 'UploadProfilePhotoController@handle', 'as' => 'member_admin.profile.upload_profile_photo']);
        $route->post('/delete-profile-photo', ['uses' => 'DeleteProfilePhotoController@handle', 'as' => 'member_admin.profile.delete_profile_photo']);
    });
    // end profile

    // favorite escorts
    $route->group(['prefix' => '/myescorts', 'namespace' => 'FavoriteEscort'], function ($route) {
        $route->get('/', ['uses' => 'ManageController@index', 'as' => 'member_admin.favorite_escorts.manage']);
        $route->get('/remove-favorite', ['uses' => 'RemoveFavoriteController@handle', 'as' => 'member_admin.favorite_escorts.remove_favorite']);
    });
    // end favorite escorts

    // favorite agencies
    $route->group(['prefix' => '/myagencies', 'namespace' => 'FavoriteAgency'], function ($route) {
        $route->get('/', ['uses' => 'ManageController@index', 'as' => 'member_admin.favorite_agencies.manage']);
        $route->get('/follow', ['uses' => 'FollowController@handle', 'as' => 'member_admin.favorite_agencies.follow']);
        $route->get('/unfollow', ['uses' => 'UnfollowController@handle', 'as' => 'member_admin.favorite_agencies.unfollow']);
    });
    // end favorite agencies

    // reviews
    $route->group(['prefix' => '/reviews', 'namespace' => 'Reviews'], function ($route) {
        $route->get('/', ['uses' => 'ManageController@index', 'as' => 'member_admin.reviews']);
        $route->get('/remove', ['uses' => 'RemoveController@handle', 'as' => 'member_admin.reviews.remove']);
    });
    // end reviews

    // comments
    $route->group(['prefix' => '/comments', 'namespace' => 'Comments'], function ($route) {
        $route->get('/', ['uses' => 'ManageController@index', 'as' => 'member_admin.comments']);
        $route->get('/remove', ['uses' => 'RemoveController@handle', 'as' => 'member_admin.comments.remove']);
        $route->get('/add-heart', ['uses' => 'AddHeartController@handle', 'as' => 'member_admin.comments.add_heart']);
        $route->get('/remove-heart', ['uses' => 'RemoveHeartController@handle', 'as' => 'member_admin.comments.remove_heart']);
    });
    // end comments

    // emails
    $route->group(['prefix' => '/emails', 'namespace' => 'Emails'], function ($route) {
        $route->get('/', ['uses' => 'ManageController@index', 'as' => 'member_admin.emails.manage']);
        $route->get('/read/{email}', ['uses' => 'ReadEmailController@handle', 'as' => 'member_admin.emails.view']);
        $route->get('/compose', ['uses' => 'RenderFormController@view', 'as' => 'member_admin.emails.compose']);
        $route->post('/send', ['uses' => 'SendEmailController@handle', 'as' => 'member_admin.emails.send']);
        $route->get('/star/{email}', ['uses' => 'StarEmailController@handle', 'as' => 'member_admin.emails.star']);
        $route->post('/delete', ['uses' => 'DeleteEmailController@handle', 'as' => 'member_admin.emails.delete']);
        $route->get('/check-email', ['uses' => 'CheckEmailController@handle', 'as' => 'member_admin.emails.check_email']);
    });
    // end emails

    // account settings
    $route->group(['prefix' => '/account-settings', 'namespace' => 'AccountSettings'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@index', 'as' => 'member_admin.account_settings']);
        $route->post('/change-email', ['uses' => 'UpdateEmailController@handle', 'as' => 'member_admin.account_settings.update_email']);
        $route->get('/change-email/{token}', ['uses' => 'VerifyUpdateEmailController@index', 'as' => 'member_admin.account_settings.change_email']);
        $route->post('/change-password', ['uses' => 'UpdatePasswordController@handle', 'as' => 'member_admin.account_settings.change_password']);
        $route->post('/change-ban-countries', ['uses' => 'UpdateBanCountriesController@handle', 'as' => 'member_admin.account_settings.ban_countries']);
    });
    // end account settings

    // dashboard
    $route->group(['prefix' => '/', 'namespace' => 'Dashboard'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@handle', 'as' => 'member_admin.dashboard']);
        $route->get('/dashboard', ['uses' => 'IndexController@handle']);
    });
    // end dashboard
});
// end member admin routes

// frontend routes
Route::group(['prefix' => '/', 'namespace' => 'Index', 'middleware' => 'switch.locale'], function ($route) {

    // homepage
    $route->group(['prefix' => '/', 'namespace' => 'Home'], function ($route) {
        $route->get('/', ['uses' => 'IndexController@view', 'as' => 'index.home']);
        $route->get('/filter', ['uses' => 'IndexController@view', 'as' => 'index.filter']);
        $route->get('/locationdata', ['uses' => 'IndexController@getLocationNameBYId', 'as' => 'index.locationdata']);
        $route->get('/location/{country}', ['uses' => 'IndexController@view', 'as' => 'index.country']);
        $route->get('/location/{country}/{state}', ['uses' => 'IndexController@view', 'as' => 'index.state']);
        $route->get('/location/{country}/{state}/{city}', ['uses' => 'IndexController@view', 'as' => 'index.city']);
        $route->get('/filter-option', ['uses' => 'IndexController@getFilterOptions', 'as' => 'index.filteroption']);

        // ajax locations' routes
        $route->get('/escorts', ['uses' => 'EscortController@findEscort', 'as' => 'index.escort.list']);
        $route->get('/escorts/country/{countryId}', ['uses' => 'EscortController@findEscort', 'as' => 'index.escort.filter.country']);
        $route->get('/escorts/state/{stateId}', ['uses' => 'EscortController@findEscort', 'as' => 'index.escort.filter.state']);
        $route->get('/escorts/state/{cityId}', ['uses' => 'EscortController@findEscort', 'as' => 'index.escort.filter.city']);
    });
    // end homepage

    //agency
    $route->group(['prefix' => '/agency', 'namespace' => 'Agency'], function ($route) {
        $route->get('/', ['uses' => 'ListController@view', 'as' => 'agency.home']);
        $route->get('/{username}', ['uses' => 'ProfileController@view', 'as' => 'agency.profile']);
    });
    //end agency

    // profile
    $route->group(['prefix' => 'profile', 'namespace' => 'Profile'], function ($route) {
        $route->post('/add-review', ['uses' => 'AddReviewController@handle', 'as' => 'index.profile.add_review'])->middleware('handle.ajax');
        $route->post('/add-favorite', ['uses' => 'AddFavoriteController@handle', 'as' => 'index.profile.add_favorite']);
        $route->post('/remove-favorite', ['uses' => 'RemoveFavoriteController@handle', 'as' => 'index.profile.remove_favorite']);
        $route->post('/add-booking', ['uses' => 'AddBookingController@handle', 'as' => 'index.profile.add_booking'])->middleware('handle.ajax');
        $route->post('/add-report', ['uses' => 'AddReportController@handle', 'as' => 'index.profile.add_report']);
        
        
        // follower
        $route->post('/follow', ['uses' => 'FollowController@handle', 'as' => 'index.profile.follow']);
        $route->post('/unfollow', ['uses' => 'UnfollowController@handle', 'as' => 'index.profile.unfollow']);
    });
    // end profile
    $route->get('/profile/{id}', ['uses' => 'RenderProfileController@view', 'as' => 'index.profile']);
    // $route->group(['prefix' => '/auth', 'namespace' => 'Auth'], function ($route) {
    //     $route->post('/login', ['uses' => 'LoginController@handle', 'as' => 'index.auth.login']);
    //     $route->get('/logout', ['uses' => 'LogoutController@handle', 'as' => 'index.auth.logout']);
    // });

    // auth
    $route->group(['prefix' => '/auth', 'namespace' => 'Auth'], function ($route) {
        $route->get('/login', ['uses' => 'LoginController@index', 'as' => 'index.auth.login_form']);
        $route->post('/login', ['uses' => 'LoginController@handle', 'as' => 'index.auth.login']);
        $route->get('/logout', ['uses' => 'LogoutController@handle', 'as' => 'index.auth.logout']);
        $route->get('/profile', ['uses' => 'ProfileController@index', 'as' => 'index.auth.profile_form']);
        $route->post('/profile', ['uses' => 'ProfileController@handle', 'as' => 'index.auth.profile']);
        $route->get('/forgot-password', ['uses' => 'ForgotPasswordController@view', 'as' => 'index.auth.forgot_password']);
        $route->post('/send-reset', ['uses' => 'ForgotPasswordController@send', 'as' => 'index.auth.forgot_password.send']);
        $route->get('/reset-password', ['uses' => 'ResetPasswordController@view', 'as' => 'index.auth.reset_password.form']);
        $route->post('/reset-password', ['uses' => 'ResetPasswordController@handle', 'as' => 'index.auth.reset_password']);
    });
    // end auth

    // register
    $route->group(['prefix' => 'register', 'namespace' => 'Auth\Register'], function ($route) {
        $route->get('/', ['uses' => 'RegisterController@index', 'as' => 'index.auth.register']);

        // member
        $route->get('/member', ['uses' => 'RegisterMemberController@renderForm', 'as' => 'index.auth.member.register_form']);
        $route->post('/member', ['uses' => 'RegisterMemberController@handle', 'as' => 'index.auth.member.register']);
        // escort
        $route->get('/escort', ['uses' => 'RegisterEscortController@renderForm', 'as' => 'index.auth.escort.register_form']);
        $route->post('/escort', ['uses' => 'RegisterEscortController@handle', 'as' => 'index.auth.escort.register']);
        // agency
        $route->get('/agency', ['uses' => 'RegisterAgencyController@renderForm', 'as' => 'index.auth.agency.register_form']);
        $route->post('/agency', ['uses' => 'RegisterAgencyController@handle', 'as' => 'index.auth.agency.register']);
    });
    // end register

    // email
    $route->group(['prefix' => 'email', 'namespace' => 'Auth\Verification'], function ($route) {
        // email verify
        $route->get('/verify/{token}', ['uses' => 'VerifyEmailController@handle', 'as' => 'index.verification.verify']);
        $route->get('/verify', ['uses' => 'VerifyEmailController@renderNotice', 'as' => 'index.verification.notice']);

        $route->get('/resend', ['uses' => 'ResendEmailVerificationController@renderForm', 'as' => 'index.verification.resend.form']);
        $route->post('/resend', ['uses' => 'ResendEmailVerificationController@handle', 'as' => 'index.verification.resend']);
    });
    // end email

    // page
    $route->group(['prefix' => 'page'], function ($route) {
        $route->get('/terms-conditions', function(){
            return view('Index::pages.terms_conditions');
        });
    });

    // post category
    $route->get('/category/{path}', ['uses' => 'Posts\Categories\ViewController@handle', 'as' => 'index.posts.categories.view'])
    ->where(['path' => '.*']);
    // post category
    $route->get('/category-redirect', ['uses' => 'Posts\Categories\RedirectController@handle', 'as' => 'index.posts.categories.redirect']);

    // post tag
    $route->get('/tag/{path}', ['uses' => 'Posts\Tags\ViewController@handle', 'as' => 'index.posts.tags.view'])
    ->where(['path' => '.*']);

    // post comment
    $route->post('/posts/comment/save', ['uses' => 'Posts\Comments\SaveController@handle', 'as' => 'index.posts.comments.save']);
    $route->get('/posts/comment/logout', ['uses' => 'Posts\Comments\LogoutController@handle', 'as' => 'index.posts.comments.logout_auth']);
    $route->get('/posts/comment/profile', ['uses' => 'Posts\Comments\ProfileController@handle', 'as' => 'index.posts.comments.profile_auth']);

    // post search
    $route->get('/posts/search', ['uses' => 'Posts\SearchController@handle', 'as' => 'index.posts.search']);
    $route->get('/posts', ['uses' => 'Posts\ListingController@handle', 'as' => 'index.posts.list']);

    // post/page
    $route->fallback('FallbackController@handle');
});
// end frontend routes