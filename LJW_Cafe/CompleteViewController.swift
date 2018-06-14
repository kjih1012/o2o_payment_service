//
//  CompleteViewController.swift
//  LJW_Cafe
//
//  Created by 김윤아 on 2018. 6. 6..
//  Copyright © 2018년 SWUCOMPUTER. All rights reserved.
//

import UIKit

class CompleteViewController: UIViewController {

    var time:String?
    @IBOutlet var orderdetail: UILabel!
    @IBOutlet var amount: UILabel!
    @IBOutlet var reservation: UILabel!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        let appDelegate = UIApplication.shared.delegate as! AppDelegate
        
        var pay = 0
        orderdetail.text = ""
        for (key,value) in appDelegate.cart {
            orderdetail.text = orderdetail.text!+" "+key+" "+String(value[1])+"개 "
            pay = pay + value[0]*value[1]
        }
        amount.text = String(pay)+"원"
        reservation.text = time
        
        //orderdetail =
        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
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
