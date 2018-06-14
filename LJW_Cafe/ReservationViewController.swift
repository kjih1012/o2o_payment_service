//
//  ReservationViewController.swift
//  LJW_Cafe
//
//  Created by SWUCOMPUTER on 2018. 6. 6..
//  Copyright © 2018년 SWUCOMPUTER. All rights reserved.
//

import UIKit

class ReservationViewController: UIViewController {

    @IBOutlet var DatePicker: UIDatePicker!
    @IBOutlet var Date: UILabel!
    var strDate: String = ""
    
    @IBAction func DateSelected(_ sender: Any) {
        let dateFormatter = DateFormatter()
        
        dateFormatter.dateStyle = DateFormatter.Style.short
        dateFormatter.timeStyle = DateFormatter.Style.short
        
        strDate = dateFormatter.string(from: DatePicker.date)
        Date.text = strDate
        print(strDate)
    }
    
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func Payment(_ sender: Any) {
    }
    
    override func prepare (for segue: UIStoryboardSegue, sender: Any?) { // Get the new view controller using segue.destinationViewController. // Pass the selected object to the new view controller.
        if segue.identifier == "toReservView" {
            if let destination = segue.destination as? CompleteViewController {
                destination.time = strDate
            }
        }
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
