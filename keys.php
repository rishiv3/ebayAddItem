<?php
/*  © 2007-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */

    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = false;   // toggle to true if going against production
    $compatabilityLevel = 825;    // eBay API version
    
    if ($production) {
        $devID = 'Production_devID';   // these prod keys are different from sandbox keys
        $appID = 'Production_appID';
        $certID = 'Production_certID';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        $userToken = 'Production_usertoken'; 
        $paypalEmailAddress= 'PAYPAL_EMAIL_ADDRESS';
        $endpoint = 'http://open.api.ebay.com/shopping';		
    } else {  
        $appID = 'RishiVis-asdasd-SBX-5c8e8a00c-2c9b6053';   // different from prod keys
        $devID = 'c3deea99-9395-4bf9-b8e4-99d4488aa2ab';         // insert your devID for sandbox
        $certID = 'SBX-c8e8a00c3854-7dc9-48db-a0e2-e5d5';  // need three 'keys' and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        // the token representing the eBay user to assign the call with
        // this token is a long string - don't insert new lines - different from prod token
        $userToken = 'v^1.1#i^1#I^3#f^0#r^0#p^1#t^H4sIAAAAAAAAAOVYfWwURRTv9QuxlI/EVIGi54pIwdub3b273i29S64ftCUtrb2zlCqB2d3Zdune7rEzS+/QxLOGj4AY/oAoIRr+QxNJSAhEJY1aPtRE+UeDClE0JgRjRIIfYAzq3F0p10qg0EObeNlkMzPvvfm933tv3tyCVOnURZuaNl0ud0wp3JsCqUKHgysDU0tLFk8vKpxTUgByBBx7U/NTxQNF52swjOlxsQPhuGlg5EzEdAOLmckgY1uGaEKsYdGAMYRFIouRcGuLyLNAjFsmMWVTZ5zN9UFG5gQfJylegUOqrMgCnTWu2YyaQUZAPOIDSArI1V7eU02XMbZRs4EJNEiQ4QEPXMBPnygniAIQOZ4N+Ku7GWcnsrBmGlSEBUwog1bM6Fo5UG+OFGKMLEKNMKHm8NJIW7i5vmF5tMadYys0TEOEQGLj0aM6U0HOTqjb6Obb4Iy0GLFlGWHMuEPZHUYbFcPXwNwB/AzT1T7e6/dKHomXfWoASHmhcqlpxSC5OY70jKa41IyoiAyikeStGKVsSGuRTIZHy6mJ5npn+vWEDXVN1ZAVZBpqwyvD7e1MqEPDvVqnhl0QK/RxRWq7XF7Zj/wQANnFywHJB7zC8DZZW8Mkj9mnzjQULU0Zdi43SS2imNFYZvgcZqhQm9FmhVWSxpMr5x1hkO9OhzQbQ5v0GumoohilwZkZ3pr/EW1CLE2yCRqxMHYhQ1CQgfG4pjBjFzOZOJw8CRxkegmJi253f38/2y+wptXj5gHg3F2tLRG5F8Ugk5VN1zqV126t4NIyrsiIamJNJMk4xZKgmUoBGD1MSPAEfFxgmPfRsEJjZ/8xkeOze3Q95Ks+PF7BB6EKPdDvUwR/IB/1ERpOUXcaB5Jg0hWDVh8icR3KyCXTPLNjyNIUUfCqvOBXkUvxBVSXJ6CqLsmr+FycihBASJLkgP//UybjTfQIki1E8pXp+cnyhvC6Fq3b09EaVfsSCcsbbgHJZesatWWyDnQ7Ble0rlTtRKKu3TSD462FGzsvm3HUbuqanJyEtW4p7dAiyVo7SccRpOv0NSF3cdrdyRXqtD6mBmBcY9PFzcpmzG1Ceqqnp1ZnEDvHI+SW7CTbYyNMKAqFttVxK2m0Plh6RijjV8meQNSB8avQK5tiy+SONsocdSxlUuvpJfi29kyMImVC2ROOx5tjMZtASUfNeeuN/0VfvKF7Gr033qZP6Vq/u37RyGZDrCnZSx+biTOL18ushbBpW/S+y7alb0FRsw8ZtKsQy9R1ZHVyEw72JIvxbbXeO/M6r7e+SZPZsq7R5Fk92Tz7F+KpwbzdbIoHHC/lx2/OG/D5A4KH4yfkW10mqtHkZOvoTSYmSLkLf1Hco7+WhAoyP27AMQgGHG8XOhygGri4xaCqtOjJ4qJpDKaNncXQUCQzwWpQZWn7NCCxLcT2oWQcalZhqUM7/Zl8Jec7zd5V4IGRLzVTi7iynM82oPL6Sgk34/5ySowf+DlBABzfDR65vlrMVRTfB6OfbNx5oPCFBQvPzVoaHDp29N6T+0H5iJDDUVJAk6pg3q4DHwlncfmhmmmr/1yzo2v+88qbB3/FG+Z89Wj34VXCvoPR7XPBt3suf/518QLlj42l/ulVR+cNrvih3HjYdpw6ue+vyiXvzL248aFdx8suffnFc1eUw7unHagAqcCW/tR7+5Y1gHOvpw6dqflg6LV5jZtnm9uvPl7ReMwsv3h1ifHi+d2bK068McTv3BBq//HnrUe+w09vazpDzm/QeqzEpfffrVPPXYnvmPlU6vj+gW3sqVdrB795tmW9t/zgyxIS71kze09V9afPXFw7pX532YOPdZ14eOuFy7+drdwmbJlReLrS6L/6++y1cEXZhUUffygt/H5W1+HGwY6Zl9YUbH5Fbhrq+umtIyd/qarLhvFvDwlKAkETAAA='; 
        $paypalEmailAddress = 'rishiv3@gmail.com';
        // Sandbox URL for testing	
        $endpoint = 'http://open.api.sandbox.ebay.com/Shopping'; 		
    }
?>
