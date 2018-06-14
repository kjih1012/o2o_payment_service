//
//  CafeTableViewController.swift
//  CafeListView
//
//  Created by SWUCOMPUTER on 2018. 5. 2..
//  Copyright © 2018년 SWUCOMPUTER. All rights reserved.
//

import UIKit

class CafeTableViewController: UITableViewController {
    
    
    var swucafe:[String : [String : Int]] =
        ["가은" : ["아메리카노" : 3800 , "카페모카": 4000],
         "드림" : ["아메리카노" : 2800, "카페모카": 3700],
         "팬도로시" : ["아메리카노":3200, "카페모카":3100],
         "비틀주스" : ["망고주스":4000, "키위주스" : 4100]]
    
   /* var totalCount: [Int] = [0,0,0]
    var currentSection = 0; */

    override func viewDidLoad() {
        super.viewDidLoad()

        // Uncomment the following line to preserve selection between presentations
        // self.clearsSelectionOnViewWillAppear = false

        // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
        // self.navigationItem.rightBarButtonItem = self.editButtonItem
        
        self.title="SWUCAFE"
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    // MARK: - Table view data source

    override func numberOfSections(in tableView: UITableView) -> Int {
        // #warning Incomplete implementation, return the number of sections
        return 1
    }

    override func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        // #warning Incomplete implementation, return the number of rows
        return swucafe.count
    }

    
    override func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "Cafe Cell", for: indexPath)

        // Configure the cell...
        
        
        var cafeName = Array(swucafe.keys)
        cell.textLabel?.text = cafeName[indexPath.row]
        //let numCount = Array(menuInfo.values) [indexPath.row]
     
       

        return cell
    }
    
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
//        if segue.identifier == "toMenuView" {
//            if let destination = segue.destination as? MenuTableViewController {
//                if let selectedIndex = self.tableView.indexPathsForSelectedRows?.first?.row {
//                    print(selectedIndex)
//                    destination.title = Array(swucafe.keys) [selectedIndex]
//                    destination.menuList = Array(swucafe.values) [selectedIndex]
//                }
//            }
//        }
        
        if segue.identifier == "toMenuView" {
            if let tabVC:UITabBarController = segue.destination as? UITabBarController {
                if let menuVC:MenuTableViewController = tabVC.viewControllers?.first as? MenuTableViewController {
                    let selectedIndex = self.tableView.indexPathForSelectedRow?.row
                    menuVC.title = Array(swucafe.keys)[selectedIndex!]
                    menuVC.menuList = Array(swucafe.values)[selectedIndex!]
                }
            }
        }
    }
    

    /*
    // Override to support conditional editing of the table view.
    override func tableView(_ tableView: UITableView, canEditRowAt indexPath: IndexPath) -> Bool {
        // Return false if you do not want the specified item to be editable.
        return true
    }
    */

    /*
    // Override to support editing the table view.
    override func tableView(_ tableView: UITableView, commit editingStyle: UITableViewCellEditingStyle, forRowAt indexPath: IndexPath) {
        if editingStyle == .delete {
            // Delete the row from the data source
            tableView.deleteRows(at: [indexPath], with: .fade)
        } else if editingStyle == .insert {
            // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
        }    
    }
    */

    /*
    // Override to support rearranging the table view.
    override func tableView(_ tableView: UITableView, moveRowAt fromIndexPath: IndexPath, to: IndexPath) {

    }
    */

    /*
    // Override to support conditional rearranging of the table view.
    override func tableView(_ tableView: UITableView, canMoveRowAt indexPath: IndexPath) -> Bool {
        // Return false if you do not want the item to be re-orderable.
        return true
    }
    */

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
