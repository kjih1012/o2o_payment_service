//
//  RegisterPageViewController.swift
//  CafeListView
//
//  Created by SWUCOMPUTER on 2018. 5. 13..
//  Copyright © 2018년 SWUCOMPUTER. All rights reserved.
//

import UIKit
import Alamofire

class RegisterPageViewController: UIViewController,UITextFieldDelegate {
    
    @IBOutlet var userEmailTextField: UITextField!
    @IBOutlet var userPasswordTextField: UITextField!
    @IBOutlet var repeatPasswordTextField: UITextField!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        // Do any additional setup after loading the view.
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func registerTapped() {
        let userEmail = userEmailTextField.text;
        let userPassword = userPasswordTextField.text;
        let userRepeatPassword = repeatPasswordTextField.text;
        let parameters:[String:[String:String]] = [
            "user":[
                "email":userEmailTextField.text!,
                "password":userPasswordTextField.text!
            ]
        ]
        // Check for empty fields
        if((userEmail?.isEmpty)! || (userPassword?.isEmpty)! || (userRepeatPassword?.isEmpty)!)
        {
            //Display alert message
            displayMyAlertMessage(userMessage: "모든 정보를 입력해 주세요");
            return
        }
        
        //Check if passwords match
        else if(userPassword != userRepeatPassword)
        {
            // Display an alert message
            displayMyAlertMessage(userMessage: "비밀번호가 일치하지 않습니다");
            return
        }
        
        else
        {
            // connect to server
            let url = "http://172.30.1.16:6010/register"
            Alamofire.request(url, method: .post, parameters: parameters, encoding: URLEncoding.default, headers: nil).responseString
                { response in
                    
                    if (response.result.value == "회원등록에 실패했습니다")
                    {
                        self.displayMyAlertMessage(userMessage: "동일한 이메일 정보가 존재합니다")
                    }
                    else
                    {
                         // Display alert message with confirmation
                        let myAlert = UIAlertController(title : "알림", message:"회원정보등록에 성공했습니다", preferredStyle : UIAlertControllerStyle.alert)
                        
                        let okAction = UIAlertAction(title:"확인", style: UIAlertActionStyle.default)
                        {
                            action in
                            self.dismiss(animated: true, completion:nil)
                        }
                        myAlert.addAction(okAction)
                        self.present(myAlert, animated:true, completion:nil)
                    }
                    
                    
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


}
