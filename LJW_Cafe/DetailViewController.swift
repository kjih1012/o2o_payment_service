//
//  DetailViewController.swift
//  LJW_Cafe
//
//  Created by 김윤아 on 2018. 6. 3..
//  Copyright © 2018년 SWUCOMPUTER. All rights reserved.
//

import UIKit
import CoreData

class DetailViewController: UIViewController {
    
    var Detailmenu: String!
    var Price : Int!
    var detailtitle: String?
    
    var cafelist: [String:Int] = ["드림":0 , "팬도로시":1, "가은":2, "비틀주스":3]
    
    var cafe: [NSManagedObject] = []
    
    var menucount:Int = 0
    
    @IBOutlet var menuname: UILabel!
    @IBOutlet var menuprice: UILabel!
    
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
        menuname.text = Detailmenu
        menuprice.text = String(Price)
    }
    
    override func viewWillAppear(_ animated: Bool) {
        self.title = detailtitle
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
        
    }
    
    
    @IBAction func AddMenu(_ sender: Any) {
    
        
        let appDelegate = UIApplication.shared.delegate as! AppDelegate
        
        if (appDelegate.cart.count != 0 )
        {
            if(cafelist[detailtitle!]! == cafelist[appDelegate.cafe!]!)
            {
                if(appDelegate.cart[Detailmenu] != nil) {
                let count : Int = appDelegate.cart[Detailmenu]![1]
                
                appDelegate.cart.updateValue([Price,count+1,cafelist[detailtitle!]!], forKey: Detailmenu)
                                
                displaybadge()
                
                let myAlert = UIAlertController(title : "알림", message:"장바구니에 추가되었습니다.", preferredStyle : UIAlertControllerStyle.alert)
                
                let okAction = UIAlertAction(title:"확인", style: UIAlertActionStyle.default)
                {
                    action in
                    self.dismiss(animated: true, completion:nil)
                }
                myAlert.addAction(okAction)
                self.present(myAlert, animated:true, completion:nil)
                }
                else
                {
                    appDelegate.cart.updateValue([Price,1,cafelist[detailtitle!]!], forKey: Detailmenu)
                    
                    displaybadge()
                    
                    displayMyAlertMessage(userMessage: "장바구니에 추가되었습니다.")
                }
            }
            else
            {
                displaybadge()
                
                displayMyAlertMessage(userMessage: "한번에 한 카페에 해당하는 주문만 할 수 있습니다.")
            }
        }
        
        else {
            appDelegate.cafe = detailtitle
            
            appDelegate.cart.updateValue([Price,1,cafelist[detailtitle!]!], forKey: Detailmenu)
            
            displaybadge()
            
            displayMyAlertMessage(userMessage: "장바구니에 추가되었습니다.")
            
        }
        
       
        
        
        
    }
    
    
    func displayMyAlertMessage(userMessage:String)
    {
        let myAlert = UIAlertController(title : "알림", message:userMessage, preferredStyle : UIAlertControllerStyle.alert)
        
        let okAction = UIAlertAction(title: "확인", style: UIAlertActionStyle.default, handler:nil)
        
        myAlert.addAction(okAction)
        
        self.present(myAlert, animated: true, completion: nil)
    }
    
    func displaybadge()
    {
        let appDelegate = UIApplication.shared.delegate as! AppDelegate

        menucount = 0
        for (_,value) in appDelegate.cart {
            
            menucount = menucount + value[1]
        }
        
        
        let tabController = appDelegate.window?.rootViewController
        let tableVC = tabController?.childViewControllers[2].childViewControllers[1] as! CartTableViewController
        tableVC.cartTab.badgeValue = String(format: "%d", menucount)
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
