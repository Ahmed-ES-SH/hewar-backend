<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\FooterLinkController;
use App\Http\Controllers\ProjectCategoryController;
use App\Http\Controllers\NewCategoryController;
use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CenterBranchController;
use App\Http\Controllers\CenterMemberController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuestionAnswerController;
use App\Http\Controllers\SocialAccountController;
use App\Http\Controllers\SliceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariableDataController;
use Illuminate\Support\Facades\Route;

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ------------------------------
// start public Routes ----------
// ------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


// ---------------------------------
// Auth  Routes ------
// ---------------------------------

Route::post('/login', [AuthController::class, 'login']);



// ---------------------------------
// Social Data  Routes ------
// ---------------------------------

Route::controller(SocialAccountController::class)->group(function () {
    Route::get('/social-contact-info', 'getAccounts');
    Route::get('/header-data', 'getHeaderData');
});


// ---------------------------------
// Home Page Data  Routes ------
// ---------------------------------


Route::get('/home-data', [VariableDataController::class, 'getALlDataForHomePage']);

// ---------------------------------
// Slices  Routes ------
// ---------------------------------

Route::get('/slices', [SliceController::class, 'index']);


// ---------------------------------
// About  Routes ------
// ---------------------------------

Route::get('/details', [AboutController::class, 'index']);
Route::get('/custom-details', [AboutController::class, 'customData']);


// ---------------------------------
// CenterBranches  Routes ----------
// ---------------------------------

Route::get('/center-branches', [CenterBranchController::class, 'index']);


// ---------------------------------
// Projects  Routes ----------------
// ---------------------------------

Route::get('/public-projects',  [ProjectController::class, 'approved']);
Route::get('/projects/{project}',  [ProjectController::class, 'show']);


// ---------------------------------
// Projects Categoires Routes ------
// ---------------------------------

Route::controller(ProjectCategoryController::class)->group(function () {
    Route::get('/projects-categories', 'index');
    Route::get('/projects-categories/all-arabic', 'AllArabicCategories');
    Route::get('/projects-categories/all', 'AllCategories');
});





// ---------------------------------
// news Categoires Routes ------
// ---------------------------------

Route::controller(NewCategoryController::class)->group(function () {
    Route::get('/news-categories', 'index');
    Route::get('/news-categories/all-arabic', 'AllArabicCategories');
    Route::get('/news-categories/all', 'AllCategories');
});

// ---------------------------------
// Articles  Routes ----------------
// ---------------------------------

Route::get('/public-news',  [NewsController::class, 'approved']);
Route::get('/last-news',  [NewsController::class, 'lastNews']);
Route::get('/get-news/{news}',  [NewsController::class, 'show']);



// ---------------------------------
// news Categoires Routes ------
// ---------------------------------

Route::controller(ArticleCategoryController::class)->group(function () {
    Route::get('/articles-categories', 'index');
    Route::get('/articles-categories/all-arabic', 'AllArabicCategories');
    Route::get('/articles-categories/all', 'AllCategories');
});


// ---------------------------------
// Articles  Routes ----------------
// ---------------------------------

Route::get('/article-tags',  [ArticleController::class, 'getArticleTags']);
Route::get('/public-articles',  [ArticleController::class, 'approved']);
Route::get('/get-article/{article}',  [ArticleController::class, 'show']);



// ---------------------------------
// Contact  Messages Routes --------
// ---------------------------------

Route::post('/add-contact-message', [ContactMessageController::class, 'store']);


// ----------------------------------------
// Subscribe to the newsletter ------------
// ----------------------------------------

Route::post('/subscribe', [MemberController::class, 'subscribe']);


// ----------------------------------------
//  Questions Answers Routes --------------
// ----------------------------------------

Route::get('/faqs', [QuestionAnswerController::class, 'FAQs']);
Route::get('/approvedQuestions', [QuestionAnswerController::class, 'approvedQuestions']);


// ----------------------------------------
//  Center Members Routes --------------
// ----------------------------------------

Route::get('/center-members/active', [CenterMemberController::class, 'activeMembers']);


//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ------------------------------
// End public Routes ------------
// ------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------





//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------
//  Start Protected Auth Routes ------------
// -----------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


Route::middleware(['auth:sanctum'])->group(function () {
    // -------------------------
    //  Current-user Routes ----
    // -------------------------

    Route::controller(AuthController::class)->group(function () {
        Route::get('/current-user', 'getCurrentUser');
        Route::post('/logout', 'logout');
    });
});



//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------
//  End Protected Auth Routes ------------
// -----------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------







//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------
// start  Admin  Routes ----------
// -------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


// Route::middleware(['auth:sanctum', 'checkAdmin'])->group(function () {


// ---------------------------------
// Home Page control Routes --------
// ---------------------------------

Route::controller(VariableDataController::class)->group(function () {
    Route::get('/variables-data', 'getVariablesData');
    Route::get('/charity-services', 'getCharityServices');
    Route::post('/update-charity-services', 'updateCharityServices');
    Route::post('/update-variables-data', 'updateVariablesData');
});

// ---------------------------------
// Slices Routes ------------
// ---------------------------------

Route::controller(SliceController::class)->group(function () {
    Route::get('/slices/{slice}', 'show');
    Route::post('/slices', 'store');
    Route::delete('/slices/{slice}', 'destroy');
    Route::post('/update-slice/{slice}',  'update');
});

// ---------------------------------
// Projects Routes ------------
// ---------------------------------
Route::controller(ProjectController::class)->group(function () {
    Route::get('/projects',  'index');
    Route::post('/add-project',  'store');
    Route::get('/projects/{project}',  'show');
    Route::post('/projects/{project}',  'update');
    Route::delete('/projects/{project}',  'destroy');
});




// ---------------------------------
// Projects Categoires Routes ------------
// ---------------------------------

Route::controller(ProjectCategoryController::class)->group(function () {
    Route::post('/projects-categories/search', 'search');
    Route::post('/projects-categories', 'store');
    Route::get('/projects-categories/{projectCategory}', 'show');
    Route::post('/update-project-category/{projectCategory}', 'update');
    Route::delete('/delete-project-category/{projectCategory}', 'destroy');
});



// ---------------------------------
// News Routes ------------
// ---------------------------------
Route::controller(NewsController::class)->group(function () {
    Route::get('/news',  'index');
    Route::post('/add-news',  'store');
    Route::post('/update-news/{news}',  'update');
    Route::delete('/delete-news/{news}',  'destroy');
});


// ---------------------------------
// news Categoires Routes ----------
// ---------------------------------

Route::controller(NewCategoryController::class)->group(function () {
    Route::post('/news-categories/search', 'search');
    Route::post('/news-categories', 'store');
    Route::get('/news-categories/{newsCategory}', 'show');
    Route::post('/update-news-category/{newsCategory}', 'update');
    Route::delete('/delete-news-category/{newsCategory}', 'destroy');
});




// ---------------------------------
// Articles Routes ------------
// ---------------------------------
Route::controller(ArticleController::class)->group(function () {
    Route::get('/articles',  'index');
    Route::post('/add-article',  'store');
    Route::post('/update-article/{article}',  'update');
    Route::delete('/delete-article/{article}',  'destroy');
});



// ---------------------------------
// articles Categoires Routes ----------
// ---------------------------------

Route::controller(ArticleCategoryController::class)->group(function () {
    Route::post('/articles-categories/search', 'search');
    Route::post('/articles-categories', 'store');
    Route::get('/articles-categories/{articleCategory}', 'show');
    Route::post('/update-articles-category/{articleCategory}', 'update');
    Route::delete('/delete-articles-category/{articleCategory}', 'destroy');
});



// ---------------------------------
// Footer  Links Routes ------------
// ---------------------------------
Route::controller(FooterLinkController::class)->group(function () {
    Route::get('/all-lists', 'getLinksByList');
    Route::post('/add-link', 'store');
    Route::get('/get-link/{id}', 'show');
    Route::post('/update-link/{id}', 'update');
    Route::delete('/delete-link/{id}', 'destroy');
});


// --------------------------------
//  Social Contact Info Routes ----
// --------------------------------


Route::controller(SocialAccountController::class)->group(function () {
    Route::get('/social-contact-info', 'getAccounts');
    Route::post('/update-social-contact-info', 'update');
});


// -------------------------
//  About Details Routes --
// -------------------------

Route::post('/update-details', [AboutController::class, 'update']);



// ---------------------------------
// Contact  Messages Routes --------
// ---------------------------------

Route::controller(ContactMessageController::class)->group(function () {
    Route::get('/contact-messages', 'index');
    Route::get('/contact-message/{id}', 'show');
    Route::post('/update-contact-message/{id}', 'update');
    Route::delete('/contact-message/{id}', 'destroy');
});


// -------------------------
//  News Letter Routes -----
// -------------------------

Route::controller(MemberController::class)->group(function () {
    Route::get('/members',  'index');
    Route::post('/members-by-email/{searchContent}',  'getMembersByEmail');
    Route::get('/get-members-ids',  'getMembersIds');
    Route::post('/send-newsletter',  'sendNewsletter');
    Route::delete('/unsubscribe/{id}',  'unsubscribe');
});

// -------------------------
//    users Routes -----
// -------------------------




Route::controller(UserController::class)->group(function () {
    Route::post('/register',  'store');
    Route::get('/user/{id}', 'show');
    Route::post('/update-user/{id}', 'update');
    Route::get('/users', 'index');
    Route::get('/users-with-selected-data', 'usersWithSelectedData');
    Route::get('/get-public-users-ids', 'getPublicUsersIds');
    Route::get('/users-ids', 'getUsersIds');
    Route::post('/search-for-user-by-name', 'searchForUsers');
    Route::delete('/delete-user/{id}', 'destroy');
});


// ---------------------------------
// Questions Answers Routes --------
// ---------------------------------

Route::controller(QuestionAnswerController::class)->group(function () {
    Route::get('/all-faqs', 'index');
    Route::post('/add-faq', 'store');
    Route::get('/get-faq/{id}', 'show');
    Route::post('/update-faq/{id}', 'update');
    Route::delete('/delete-faq/{id}', 'destroy');
});



// ---------------------------------
// Center Members Routes --------
// ---------------------------------

Route::controller(CenterMemberController::class)->group(function () {
    Route::get('/center-members', 'index');
    Route::post('/create-member', 'store');
    Route::get('/get-member/{centerMember}', 'show');
    Route::post('/update-member/{centerMember}', 'update');
    Route::delete('/delete-center-member/{centerMember}', 'destroy');
});


// ---------------------------------
// Center branches Routes --------
// ---------------------------------

Route::controller(CenterBranchController::class)->group(function () {
    Route::post('/create-branche', 'store');
    Route::get('/center-branches/{centerBranch}', 'show');
    Route::post('/update-branche/{centerBranch}', 'update');
    Route::delete('/delete-branche/{centerBranch}', 'destroy');
});

// });



//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------
// End  Admin  Routes ----------
// -------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//-
