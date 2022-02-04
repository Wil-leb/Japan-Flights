export default class DataStorage {
    
//*****GOALS: TO SAVE AN ARTICLE'S INFORMATION IN THE DOM DATA STORAGE, AND TO LOAD THIS INFORMATION*****//
//*******************************************************************************************************//

//*****METHODS: TO SET AND FIND AN ARTICLE'S DATA, AND TO CONVERT IT WITH JAVASCRIPT AND JSON*****//

//*****1. Saving an article's information//
    saveDataToDomStorage(name, data) {
        
//*****A. Converting an article's information from JavaScript item to JSON string*****//
        const jsonData = JSON.stringify(data);
        
//*****B. Adding an article's information to the DOM data storage*****//
        window.localStorage.setItem(name, jsonData);
    }
    
//*****2. Loading an article's information*****//
    loadDataFromDomStorage(name) {
        
//*****A. Finding an article's information from the DOM data storage*****//
        const jsonData = window.localStorage.getItem(name);
        
//*****B. Converting an article's information from JSON string to JavaScript item*****//
        return JSON.parse(jsonData);
    }
    
//*****END OF THE DataStorage CLASS*****//
}