<?php

namespace App\controller;

//*****GOAL: TO ALLOW AN ADMIN TO MODIFY ARTICLES, DELETE USERS OR DELETE REVIEWS//
//*******************************************************************************//

//*****METHODS: TO COMMUNICATE WITH THE DATABASE TO FIND THE ARTICLES' INFORMATION, THE USERS' INFORMATION
//AND THE REVIEWS' INFORMATION, TO UPDATE OR DELETE DATA IF A FORM WAS SUBMITTED WITH ALL THE
//REQUIREMENTS, OR NOT TO UPDATE NOR DELETE THE DATA OTHERWISE*****************************//

//*****1. Calling the appropriate model and the user session*****//
use App\model\{Admin};
use App\core\Session;

class AdminFormController {
    
    protected Admin $_admin;
    public function __construct(Admin $admin) {
        $this->_admin = $admin;
    }
  
//*****2. Article modification form*****//
    public function modifyArticleForm(array $data) {

//*****A. Creating an empty array, that will contain error or succes messages*****//    
        $messages = [];
        
//*****B. Declaring variables, for content comparison with regular expressions*****//
        $nameContent = $data['newName'];
        $descriptionContent = $data['newDescription'];
        $priceContent = $data['newPrice'];
        
//*****C. Declaring regular expressions, to allow only certain characters in the form fields and prevent
//injections in the databse***************************************************************************//
        $regex = '/^[a-zÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ0-9\-\/();,.!?"\s]*$/i';
        $priceRegex = '/^[0-9]{4}[.][0-9]{2}$/i';

//*****D. Finding an article's ID*****//
        $id = $_GET['articleId'];
        
//*****E. Declaring the folder path of an article's picture*****//
        $folder = './assets/img/articles/'.$id.'';
        
//*****F. Declaring the minimum time elapsed after an article's picture was modified*****//
        $minAge = 10;
        
//*****G. If any field is empty*****//
        if(empty($data['newName']) || empty($data['newDescription']) || empty($data['newPrice'])) {
            $messages['errors'][] = 'Please fill in all the fields.';
        }
        

//*****H. If the new article name or new article description do not match their regular expression*****//
        if(!empty($data['newName']) && !preg_match($regex, $nameContent, $matches)
            || !empty($data['newDescription']) && !preg_match($regex, $descriptionContent, $matches)) {
            $messages['errors'][] = 'Characters allowed for the article name and description: letters, numbers, dashes, slashes, parentheses, semicolons, commas, dots, periods, exclamation marks, question marks, straight double quotation marks and white spaces.';
        }
        
//*****I. If the new price does not match its regular expression*****//

        if(!empty($data['newPrice']) && !preg_match($priceRegex, $priceContent, $matches)) {
            $messages['errors'][] = 'Pattern expected for the article price: floating number with four digits, followed by a dot separator and two digits for the decimal.';
        }
            
/*****J. Managing a picture*****/
        function deletePicture($folder, $minAge) {
            
//*****i. Opening a picture's directory*****//
        $directory = opendir($folder);
        
//*****ii. Reading the files existing in a directory, with a loop*****//
            while(false !== ($picture = readdir($directory))) {

//*****Stocking a picture's path in a variable*****//
                $path = $folder."/".$picture;
            
//*****Returning the path's information*****//
                $info = pathinfo($path);

//*****Returning the last time when a picture was modified*****//
                $fileAge = time() - filemtime($path);
                
//*****Deleting the pictures from a selected folder, if the pictures are not a directory themselves*****//
                if($picture !="." && $picture!=".." && !is_dir($picture) && $fileAge > $minAge) {
                    unlink($path);
                }
                
//*****END OF THE WHILE LOOP*****//
            }

//*****iii. CLosing a picture's directory*****//
            closedir($directory);
        }
        
//*****K. Setting a new picture's name, if the picture was uploaded successfully*****//
        if($_FILES['newPicture']['error'] === 0){
            $picture = $_FILES['newPicture']['name'];
        }
        
//*****L. Returning an error message, if a new picture was not uploaded successfully*****//
        else {
            $messages['errors'][] = 'Please fill in all the fields.';
        }
        
//*****M. Deleting an existing picture and updating an article, if all the requirements were met*****//
        if(empty($messages['errors'])) {
            deletePicture($folder, $minAge);
            $update = $this->_admin->updateArticle($id, $data['newName'], $data['newDescription'], $data['newPrice'], $picture);
        }
        
//*****N. Setting a new picture's temporary name, and moving it to a selected folder, if it was uploaded
//successfully****************************************************************************************//
            
        if($_FILES['newPicture']['error'] === 0) {
            move_uploaded_file($_FILES['newPicture']['tmp_name'], $folder.'/'.$picture);
        }
        
//*****O. Confirming an article's update, if all the requirements were met*****//
        
        if(empty($messages['errors'])) {
            $update = $this->_admin->updateArticle($id, $data['newName'], $data['newDescription'], $data['newPrice'], $picture);
                                                    
//*****Fixing the content of the success message*****//
            $messages['success'] = ['The article has been updated with success!'];
        }
        
        return $messages;
    }
    
    
//*****2. User deletion form*****//
    public function deleteUserForm($id) {

//*****A. Creating an empty array, that will contain error or succes messages*****//    
        $deleteMessages = [];
        
//*****B. If the form is submitted*****//
        if(isset($_POST['deleteUser'])) {

//*****i. Finding a user's ID*****//
            $id = $_GET['userId'];

//*****ii. Deleting a user*****//
            $deleteUser = $this->_admin->deleteUser($id);
            
//*****iii. Fixing the content of the success message*****//
            $deleteMessages['success'] = ['The user No.'.$id.' has been deleted with success.'];
        }
        
        return $deleteMessages;
    }
    
    
//*****3. Review deletion form*****//
    public function deleteReviewForm($id) {

//*****A. Creating an empty array, that will contain error or succes messages*****//  
        $deleteMessages = [];
        
//*****B. If the form is submitted*****//
        if(isset($_POST['deleteReview'])) {

//*****i. Finding a review's ID*****//          
            $id = $_GET['reviewId'];

//*****ii. Deleting a review*****//
            $deleteReview = $this->_admin->deleteReview($id);

//*****iii. Fixing the content of the success message*****//
            $deleteMessages['success'] = ['The review No.'.$id.' has been deleted with success.'];
        }
        
        return $deleteMessages;
    }

//*****END OF THE AdminFormController CLASS*****//    
}