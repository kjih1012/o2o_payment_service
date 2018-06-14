//
//  LoginViewController.swift
//  CafeListView
//
//  Created by SWUCOMPUTER on 2018. 5. 14..
//  Copyright © 2018년 SWUCOMPUTER. All rights reserved.
//

import UIKit
import Alamofire

class LoginViewController: UIViewController,UITextFieldDelegate {

    @IBOutlet var userEmailTextField: UITextField!
    @IBOutlet var userPasswordTextField: UITextField!
    
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    
    @IBAction func logintapped() {
        //let userEmail = userEmailTextField.text;
        //let userPassword = userPasswordTextField.text;
        //let userEmailStored = UserDefaults.standard.string(forKey: "UserEmail")
        //let userPasswordStored = UserDefaults.standard.string(forKey: "UserPassword")
        let parameters:[String:[String:String]] = [
            "user":[
                "email":userEmailTextField.text!,
                "password":userPasswordTextField.text!
            ]
        ]
        //register와 login 데이터 비교
        
        let url = "http://172.30.1.16:6010/login"
        Alamofire.request(url, method: .post, parameters: parameters, encoding: URLEncoding.default, headers: nil).responseString
            { response in
                
                if (response.result.value == "로그인에 성공")
                {
                    // Login is successful
                    UserDefaults.standard.set(true, forKey:"isUserLoggedIn")
                    //UserDefaults.standard.synchronize()
                    self.dismiss(animated: true, completion: nil)
                    self.displayMyAlertMessage(userMessage: "로그인 성공")
                }
                else if (response.result.value == "로그인 실패")
                {
                    self.displayMyAlertMessage(userMessage: "로그인 실패")
                }
                else
                {
                    self.displayMyAlertMessage(userMessage: "등록되지 않은 email입니다")
                }
                
        }
        
        
    }
    
    func displayMyAlertMessage(userMessage:String)
    {
        let myAlert = UIAlertController(title : "알림", message:userMessage, preferredStyle : UIAlertControllerStyle.alert)
        
        let okAction = UIAlertAction(title:"확인", style: UIAlertActionStyle.default, handler:nil)
        
        myAlert.addAction(okAction)
        
        self.present(myAlert, animated: true, completion: nil)
    }
    // TextField Delegate 
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        textField.resignFirstResponder()
        return true
    }
    
    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
