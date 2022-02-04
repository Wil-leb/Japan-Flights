<?php

namespace App\controller;

//*****GOALS: TO GIVE A DYNAMIC TITLE TO EACH VIEW, TO CREATE A ROUTE FOR EACH VIEW, TO RENDER THE PATH
//OF EACH VIEW, TO DISPLAY THE CONTENT OF EACH VIEW FOUND VIA THE DATABASE, TO DISPLAY THE FORMS'
//MESSAGES, AND TO GIVE ACCESS TO SPECIFIC PAGES OR CONTENT FOR A USER ONLY OR FOR AN ADMIN ONLY*****//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE AND THE CONTROLLERS TO FIND THE DESIRED CONTENT, TO OPEN
//A SESSION WHEREVER IT IS NEEDED, TO REDIRECT A USER OR AN ADMIN, AND TO REQUIRE THE TEMPLATE SO AS TO
//LINK IT WITH THE VIEWS' MAIN CONTENT*****************************************************************//

//*****1. Calling the controllers, the appropriate core files and the models*****//
use App\controller\{AccountFormController, AdminFormController, AjaxController, ContactMessageController,                 FormController, PaymentController, RequestController, ReviewController};
use App\core\{Cookie, Https, Session};
use App\model\{Account, Admin, Article, ContactMessage, OrderDetails, Orders, Request, Review, User};

class FrontController {

//*****2. Routing the views*****//

//*****A. Homepage*****//
    public function home() {
        
//*****i. Creating a dynamic title, for the <title> tag in the template's <head>*****//
        $title = 'Japan Flights - Home';
        
//*****ii. Instantiating the Article model, and calling its method made to display all the articles*****//
        $article = new Article();
        $articles = $article->findAllArticles();
        
//*****iii. Rendering the path and the dynamic content to display in the page*****//
        $this->render('home/home', [
                                    'title' => $title,
                                    'articles' => $articles
                                    ]);
    }
    
//*****B. Admin pages*****//

//*****i. Dashboard page*****//
    public function dashboard() {
        $title = 'Japan Flights - Admin dashboard';
 
        $post = new Session();
        $admin = $post->admin();
        
//*****Redirecting to the Homepage, if no admin is connected to access the dashboard*****//
        if(!Session::admin()) {
            header('Location: index.php?p=home');
        }
        
//*****Giving a connected admin access to the dashboard*****//
        else {
            $this->render('admin/dashboard', ['title' => $title]);
            
//*****END OF THE ELSE CONDITION
        }
        
//*****END OF THE dashboard() METHOD
    }
    
//*****ii. Article dashboard page*****//
    public function articleDashboard() {
        $title = 'Japan Flights - Article dashboard';
        
        $post = new Session();
        $admin = $post->admin();
        
        $article = new Article();
        $articles = $article->findAllArticles();
        
        if(!Session::admin()) {
            header('Location: index.php?p=home');
        }
        
        else {
            $this->render('admin/articleDashboard', [
                                                    'title' => $title,
                                                    'articles' => $articles
                                                    ]);

//*****END OF THE ELSE CONDITION
        }
        
//*****END OF THE articleDashboard() METHOD
    }

//*****iii. Article modification page*****//
    public function modifyArticle() {
        $title = 'Japan Flights - Article modification';
        
        if(!Session::admin()) {
            header('Location: index.php?p=home');
        }
        
        else {
        
//*****Finding an article's ID, and redirecting to the dashboard if an ID doesn't exist*****//
            if(!array_key_exists('articleId', $_GET)) {
                header('Location: index.php?p=dashboard');
                exit;
            }
        
//*****Instantiating the Article model, and calling its method made to find an article with its ID*****//
            $article = new Article();
            $findArticle = $article->findArticleById($_GET['articleId']);
        
//*****Updating an article, when the dedicated form was submitted*****//
            if($_POST) {
                $form = new AdminFormController(new Admin());
                $messages = $form->modifyArticleForm($_POST);
            }
        
//*****Rendering the article form and the content to display in it*****//
            $this->render('admin/modifyArticle', [
                                                'title' => $title,
                                                'findArticle' => $findArticle,
                                                'messages' => ($messages) ?? null
                                                ]);
                                            
//*****END OF THE ELSE CONDITION
        }
        
//*****END OF THE modifyArticle() METHOD
    }

//*****iv. Review dashboard page*****//
    public function reviewDashboard() {
        $title = 'Japan Flights - Review dashboard';
        
        $post = new Session();
        $admin = $post->admin();
        
//*****Instantiating the Review model, and calling its method made to display all the reviews*****//
        $review = new Review();
        $reviews = $review->findAllReviews();

        if(!Session::admin()) {
            header('Location: index.php?p=home');
        }
        
        else {
            
//*****Deleting a review by clicking on a specific button*****//
            if(isset($_POST['deleteReview'])) {
                $form = new AdminFormController(new Admin());
                $deleteMessages = $form->deleteReviewForm($_POST);

//*****Refreshing the page after two seconds, so as to give time to an admin to see the deletion
//confirmation, and to see that what was deleted disappeared from the list***********************//
                header('Refresh: 2');
            }
            
            $this->render('admin/reviewDashboard', [
                                                    'title' => $title,
                                                    'reviews' => $reviews,
                                                    'deleteMessages' => ($deleteMessages) ?? null
                                                    ]);
                                            
//*****END OF THE ELSE CONDITION
        }
        
//*****END OF THE reviewDashboard() METHOD
    }

//*****v. User dashboard page*****//
    public function userDashboard() {
        $title = 'Japan Flights - User dashboard';
        
        $post = new Session();
        $admin = $post->admin();
        
//*****Instantiating the User model, and calling its method made to display all the users*****//
        $user = new User();
        $users = $user->findAllUsers();

        if(!Session::admin()) {
            header('Location: index.php?p=home');
        }
        
        else {
            
//*****Deleting a user by clicking on a specific button*****//
            if(isset($_POST['deleteUser'])) {
                $form = new AdminFormController(new Admin());
                $deleteMessages = $form->deleteUserForm($_POST);
                header('Refresh: 2');
            }
            
            $this->render('admin/userDashboard', [
                                                'title' => $title,
                                                'users' => $users,
                                                'deleteMessages' => ($deleteMessages) ?? null
                                                ]);
                                                
//*****END OF THE ELSE CONDITION
        }
        
//*****END OF THE userDashboard() METHOD
    }
    
//*****C. Connection pages*****//

//*****i. Account page*****//

    public function account() {
        $title = 'Japan Flights - Account';
        
//*****Redirecting to the Homepage, if nobody is connected*****//
        if(!Session::online()) {
            header('Location: index.php?p=home');
        }
        
//*****Redirecting to the Admin dashboard page, if an admin is connected*****//
        elseif(Session::admin()) {
            header('Location: index.php?p=dashboard');
        }
        
        else {
        
//*****Updating a user's data, when the dedicated form was submitted*****//
            if(isset($_POST['confirmChanges']) && $_POST['confirmChanges'] == 'Confirm change(s)') {
                $form = new AccountFormController(new Account());
                $messages = $form->accountForm($_POST);
                
//*****Refreshing the page after two seconds, so as to give time to a user to see the deletion
//confirmation, and to see that the new information is now displayed in the page************//
                if(!empty($messages['success'])) {
                    header('Refresh: 2');
                    
//*****END OF THE IF CONDITION FOR THE SUCCES MESSAGE CHECK*****//
                }
                
                
//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION CHECK*****//
            }
            
//*****Updating a user's email, when the dedicated form was submitted*****//
            if(isset($_POST['confirmEmailchange']) && $_POST['confirmEmailchange'] == 'Confirm email change') {
                $form = new AccountFormController(new Account());
                $emailMessages = $form->emailForm($_POST);
                
//*****Refreshing the page after two seconds and a half, so as to give time to a user to see the email
//change confirmation*******************************************************************************//
                if(!empty($emailMessages['success'])) {
                    header('Refresh: 2.5');
//*****END OF THE IF CONDITION FOR THE SUCCES MESSAGE CHECK*****//
                }
                
                
//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION CHECK*****//
            }
            
//*****Updating a user's login, when the dedicated form was submitted*****//
            if(isset($_POST['confirmLoginchange']) && $_POST['confirmLoginchange'] == 'Confirm login change') {
                $form = new AccountFormController(new Account());
                $loginMessages = $form->loginForm($_POST);
                
//*****Refreshing the page after three seconds, so as to give time to a user to see the login change
//confirmation************************************************************************************//
                if(!empty($loginMessages['success'])) {
                    header('Refresh: 3');
//*****END OF THE IF CONDITION FOR THE SUCCES MESSAGE CHECK*****//
                }
                
                
//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION CHECK*****//
            }
        
//*****Updating a user's password, when the dedicated form was submitted*****//
            if(isset($_POST['confirmPasswordchange']) && $_POST['confirmPasswordchange'] == 'Confirm password change') {
                $form = new AccountFormController(new Account());
                $passwordMessages = $form->passwordForm($_POST);
                
//*****Refreshing the page after three seconds and a half, so as to give time to a user to see the
//password change confirmation******************************************************************//
                if(!empty($passwordMessages['success'])) {
                    header('Refresh: 3.5');
//*****END OF THE IF CONDITION FOR THE SUCCES MESSAGE CHECK*****//
                }
                
                
//*****END OF THE IF CONDITION FOR THE FORM SUBMISSION CHECK*****//
            }
        
//*****Instantiating the Orders model, and calling its method made to display a user's order(s)*****//
            $order = new Orders();
            $orders = $order->findOrdersByUserId($_SESSION['user']['id']);
            
            $this->render('connection/account', [
                                                'title' => $title,
                                                'messages' => ($messages) ?? null,
                                                'emailMessages' => ($emailMessages) ?? null,
                                                'loginMessages' => ($loginMessages) ?? null,
                                                'passwordMessages' => ($passwordMessages) ?? null,
                                                'orders' => $orders
                                                ]);

//*****END OF THE ELSE CONDITION
        }
        
//*****END OF THE account() METHOD
    }
    
//*****ii. Login page*****//
    public function login() {
        $title = 'Japan Flights - Login';
        
//*****Opening a session, and redirecting to the Homepage if a session is closed*****//
        (Session::online()) ? Https::redirect('index.php') : '' ; 

//*****Connecting a user or an admin, when the dedicated form was submitted*****//
        if($_POST) {
            $form = new FormController(new User());
            $messages = $form->loginForm($_POST);
            
        }
        
        $this->render('connection/login', [
                                        'title' => $title,
                                        'messages' => ($messages) ?? null, 'cookie' => new Cookie]);
    }
    
//*****iii. Logout page*****//
    
    public function logout() {
//*****Closing a session and redirecting to the Homepage, when a user or an admin disconnected*****//
        Session::disconnect();
        header('Location: index.php');
        exit;
    }
    
//*****iv. Registration page*****//
    
    public function register() {
        $title = 'Japan Flights - Registration';
        
        (Session::online()) ? Https::redirect('index.php') : '' ; 
        
//*****Registering a user, when the dedicated form was submitted*****//
        if($_POST) {
            $form = new FormController(new User());
            $messages = $form->registrationForm($_POST);
        }
        
        $this->render('connection/register', [
                                            'title' => $title,
                                            'messages' => ($messages) ?? null]);
    }

//*****D. Contact pages*****//

//*****i. Contact form page*****//

    public function contactForm() {
        $title = 'Japan Flights - Contact';
        
        if(Session::admin()) {
            header('Location: index.php?p=dashboard');
        }
        
        else {
        
//*****Saving a contact message in the database, when the dedicated form was submitted*****//
            if($_POST) {
                $form = new ContactMessageController(new ContactMessage());
                $messages = $form->contactForm($_POST);
            }
        
            $this->render('contact/contactForm', [
                                            'title' => $title,
                                            'messages' => ($messages) ?? null]);

//*****END OF THE ELSE CONDITION*****//             
        }

//*****END OF THE contactForm() METHOD*****//  
    }
    
//*****ii. Customer requests page*****//
    public function customerRequests() {
        $title = 'Japan Flights - Customer requests';
        
        if(Session::admin()) {
            header('Location: index.php?p=dashboard');
        }
        
        else {
        
//*****Redirecting to the Account page, if an order's ID doesn't exist
            if(!array_key_exists('orderId', $_GET)) {
                header('Location: index.php?p=account');
                exit;
            }
        
//*****Instantiating the Article model, and calling its method made to find an order with its ID*****//
            $order = new Orders();
            $findOrder = $order->findOrderById($_GET['orderId']);
        
//*****Saving a customer request in the database, and updating the concerned order, when the dedicated
//form was submitted********************************************************************************//
            if($_POST) {
                $form = new RequestController(new Request());
                $messages = $form->requestForm($_POST);
            }
            
            $this->render('contact/customerRequests', [
                                                    'title' => $title,
                                                    'findOrder' => $findOrder,
                                                    'messages' => ($messages) ?? null
                                                    ]);
//*****END OF THE ELSE CONDITION*****//             
        }

//*****END OF THE customerRequests() METHOD*****//  
    }

//*****iii. Review page*****//
    public function review() {
        $title = 'Japan Flights - Review';
        
        if(!Session::online()) {
            header('Location: index.php?p=home');
        }
        
        elseif(Session::admin()) {
            header('Location: index.php?p=dashboard');
        }
        
        else {
            $article = new Article();
            $articles = $article->findAllArticles();
        
//*****Saving a review in the database, when the dedicated form was submitted*****//
            if($_POST) {
                $form = new ReviewController(new Review());
                $messages = $form->reviewForm($_POST);
            }
        
            $this->render('contact/review', [
                                            'title' => $title,
                                            'articles' => $articles,
                                            'messages' => ($messages) ?? null
                                            ]);
                                        
//*****END OF THE ELSE CONDITION*****//             
        }

//*****END OF THE review() METHOD*****//  
    }
    
//*****E. Destinations pages*****//

//*****i. Destinations page*****//
    
    public function destinations() {
        $title = 'Japan Flights - Destinations';
        
        $article = new Article();
        $articles = $article->findAllArticles();
        
        $this->render('destinations/destinations', [
                                                    'title' => $title,
                                                    'articles' => $articles
                                                    ]);
    }

//*****ii. Destination reviews page*****//
    
    public function destinationReviews() {
        $title = 'Japan Flights - Destination reviews';
        
        $article = new Article();
        
        $review = new Review();
        $reviews = $review->findAllReviews();
        
//*****Displaying an article's name and reviews, when an article's ID was found*****//
        if(isset($_GET['articleId'])) {
            $articleName = $article->findArticleById($_GET['articleId']);
            $reviews = $review->findReviewsByArticleId($_GET['articleId']);
        }
        
        $this->render('destinations/destinationReviews', [
                                                        'title' => $title,
                                                        'articleName' => $articleName,
                                                        'reviews' => $reviews
                                                        ]);
    }
    
//*****F. Destinations pages*****//

//*****i. Cookies Page*****//
    
    public function cookies() {
        $title = 'Japan Flights - Cookies Policy';
        $this->render('legal/cookies', ['title' => $title]);
    }
    
//*****ii. Disclaimer Page*****//

    public function disclaimer() {
        $title = 'Japan Flights - Disclaimer';
        $this->render('legal/disclaimer', ['title' => $title]);
    }
    
//*****iii. Privacy Policy Page*****//
    public function privacyPolicy() {
        $title = 'Japan Flights - Privacy Policy';
        $this->render('legal/privacyPolicy', ['title' => $title]);
    }
    
//*****iv. General Sales Terms and Conditions Page*****//
    public function salesConditions() {
        $title = 'Japan Flights - Sales Terms and Conditions';
        $this->render('legal/salesConditions', ['title' => $title]);
    }
    
//*****G. Shopping pages*****//

//*****i. Cart page*****//
    
    public function cart() {
        $title = 'Japan Flights - Shopping cart';
        
        if(Session::admin()) {
            header('Location: index.php?p=dashboard');
        }
        
        else {
            $this->render('shopping/cart', ['title' => $title]);

//*****END OF THE ELSE CONDITION*****//             
        }

//*****END OF THE cart() METHOD*****//  
    }
    

//*****ii. Cart validation page*****//
    
    public function toPayment() {
        $orderModel = new Orders();
        
        if(!Session::online()) {
            header('Location: index.php?p=cart');
        }
    
//*****Saving an order in the database, and redirecting to the order page, if a connected user validated
//a cart**********************************************************************************************//
        elseif(Session::online() && !Session::admin()) {
            $orderId = $orderModel->addOrder($_SESSION['user']['id']);
            Https::redirect('index.php?p=order&orderId='.$orderId);
        }

        elseif(Session::online() && Session::admin()) {
            header('Location: index.php?p=dashboard');
            
//*****END OF THE ELSEIF CONDITION FOR THE ADMIN SESSION CHECK*****//
        }

//*****END OF THE toPayment() METHOD*****//
    }
    

//*****iii. Order page*****//
    public function order() {
        $title = 'Japan Flights - Order';
        
//*****Redirecting to the admin dashboard page, if an order's ID doesn't exist, and if an admin is
//connected*************************************************************************************//
        if(!array_key_exists('orderId', $_GET) && Session::admin()) {
            header('Location: index.php?p=dashboard');
        }
        
//*****Redirecting to the cart page, if an order's ID doesn't exist, and if no admin is connected*****//
        elseif(!array_key_exists('orderId', $_GET) && !Session::admin()) {
            header('Location: index.php?p=cart');
        }
        
        else {
            $this->render('shopping/order', ['title' => $title]);
            
//*****END OF THE ELSE CONDITION*****//
        }

//*****END OF THE order() METHOD*****//
    }
    
//*****iv. Payment page*****//
    public function payment() {
        $title = 'Japan Flights - Payment page';
        
        if(!array_key_exists('orderNum', $_GET) && Session::admin()) {
                header('Location: index.php?p=dashboard');
        }
            
//*****Redirecting to the Homepage, if no user is connected, or if an order's number doesn't exist*****//
        elseif(!array_key_exists('orderNum', $_GET)) {
            header('Location: index.php?p=home');
        }

        else {
            
//*****Instantiating OrderDetails model, and calling its method made to display an order's details*****//
            $orderDetails = new OrderDetails();
            $orderLines = $orderDetails->findOrderDetails($_GET['orderNum']);
            
//*****Fixing the total amount of an order, and saving an order's details*****//
            $totalAmount = 0;
    
            foreach($orderLines as $orderLine) {
                $totalAmount += $orderLine['quantity'] * $orderLine['price'];
            }

//*****Instantiating the Payment controller, and intenting a payment event*****//
            $intent = PaymentController::payment($totalAmount);
            
            $this->render('shopping/payment', [
                                                'title' => $title,
                                                'totalAmount' => $totalAmount,
                                                'intent' => $intent
                                               ]);
                                               
//*****END OF THE ELSE CONDITION*****//
        }

//*****END OF THE payment() METHOD*****//
    }

//*****v. Success page*****//

    public function success() {
        $title = 'Japan Flights - Payment success';
        $this->render('shopping/success', ['title' => $title]);
    }
    
//*****3. Updating a paid order*****//

    public function updateOrder() {
        
//*****Redirecting to the Homepage, if an order's total amount was not found with success*****//
        if(isset($_GET['amount']) == false) {
            Https::redirect('index.php');
        }
        
//*****Instantiating the Orders model, and calling its method made to update a paid order*****//
        else {
            $order = new Orders();
            $order->updateOrder($_GET['amount'], $_GET['orderId']);
            
//*****Redirecting to the Success page, if a payment was made with success*****//
            Https::redirect('index.php?p=success');
            
//*****END OF THE ELSE CONDITION*****//
        }

//*****END OF THE updateOrder() METHOD*****//
    }
    
//*****4. Rendering the view's path*****//

    public function render(string $path, $array = []) {
        
//*****A. Setting an array's keys and values for each path, if an array is not empty, with a loop*****//
        if(count($array) > 0) {
            foreach($array as $key => $value) {
                ${$key} = $value;
                
//*****END OF THE FOREACH LOOP
            }
            
//*****END OF THE IF CONDITION FOR PATH ARRAY CHECK*****//
        }
        
//*****B. Instantiating the Session and Https core files*****//
        $session = new Session;
        $https = new Https;
        
//*****C. Defining the views' path*****//

        $path = $path.".php";
        require 'template/template.php';

//*****END OF THE render() METOHD*****//
    }

//*****END OF THE FrontController CLASS*****//
}